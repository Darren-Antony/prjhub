<?php
require_once('../config.php');
session_start();
$user_id = $_SESSION['suser_id'];
$getNot = "SELECT * FROM notification WHERE receiver_Id = $user_id ORDER BY Date DESC, Time DESC"; 
$result = mysqli_query($conn, $getNot);
$updateQuery = "UPDATE notification SET unreadMsg = 1 WHERE receiver_Id = $user_id AND unreadMsg = 0";
mysqli_query($conn, $updateQuery);

function getTimeElapsed($timestamp) {
    $currentTime = time();
    $notificationTime = strtotime($timestamp);
    $timeDiff = $currentTime - $notificationTime;

    if ($timeDiff < 60) {
        return "Just now";
    } elseif ($timeDiff < 3600) {
        $minutes = floor($timeDiff / 60);
        return "$minutes minute(s) ago";
    } elseif ($timeDiff < 86400) {
        $hours = floor($timeDiff / 3600);
        return "$hours hour(s) ago";
    } else {
        return date('M j, Y', $notificationTime);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../style/dashboard/notif.css">
    <link rel="stylesheet" href="../../style/dashboard/stdashboard.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>
    <script src="../../script/global.js"></script>
    <title>Notification</title>
    <style>
        .message {
            list-style: none;
            margin-bottom: 10px;
        }
        .message-text {
            font-weight: bold;
        }
        .time {
            color: gray;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="logo-cont">
        <div class="logo">
            <img src="../../asset/image/Logo.png" alt="" srcset="">
            <h1>Academic Project Tracker</h1>
        </div>
    </div>
    <div class="notificont">
        <div class="title">Your Notifications</div>
        <div class="notif-cont">
            <ul>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $isRead = $row['unreadMsg'] == 1 ? "unread" : "read";
                    $timeElapsed = getTimeElapsed($row['Date'] . ' ' . $row['Time']);
                    echo "<li class='message $isRead'>";
                    echo "<div class='message-text'>{$row['Message']}</div>";
                    echo "<div class='time'>$timeElapsed</div>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
