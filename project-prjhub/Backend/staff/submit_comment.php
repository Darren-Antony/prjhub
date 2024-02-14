<?php
require_once('../../page/config.php');
session_start();
$user_id = $_SESSION['user_id'];
if (isset($_POST['comment']) && isset($_POST['prjid'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $prjid = $_POST['prjid'];
    $getPrjDetails = "SELECT * FROM project WHERE Prj_Id='$prjid'";
    $getPrjDetailsRes = mysqli_query($conn, $getPrjDetails);
    $prjRow = mysqli_fetch_assoc($getPrjDetailsRes);
    $PrjstuNo = $prjRow['Stu_Id'];
    $getReceiverId = "SELECT * FROM student WHERE Dept_No='$PrjstuNo'";
    $getReceiverIdRes = mysqli_query($conn, $getReceiverId);
    $ReRow = mysqli_fetch_assoc($getReceiverIdRes);
    $Receiverid = $ReRow['U_Id'];
    $Senderid = $user_id;
    $currentDate = date('Y-m-d'); 
    $currentTime = date('H:i:s');
    // Use prepared statement to prevent SQL injection
    $insertCmt = "INSERT INTO COMMENT(Sender_Id, Receiver_Id, Comment, Date, Time, prj_Id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertCmt);
    mysqli_stmt_bind_param($stmt, "iissii", $Senderid, $Receiverid, $comment, $currentDate, $currentTime, $prjid);
    $res =  mysqli_stmt_execute($stmt);

    // Construct the HTML for the new comment with appropriate formatting
    $senderName = ($Senderid == $user_id) ? "You" : "Your student";
    $receiverName = ($Receiverid == $user_id) ? "You" : "Your student";
    $formattedComment = "<div><strong>{$senderName}:</strong> {$comment}</div>";

    // Return the HTML for the new comment
    echo $formattedComment;

    mysqli_stmt_close($stmt);
} else {
    echo "Error: Comment data not received.";
}
?>
