<?php
require_once('../../../page/config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["guideId"])) {
        $guideId = htmlspecialchars($_POST["guideId"]);
        $user_id = $_SESSION['user_id'];
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $updateQuery1 = "UPDATE student 
                        SET Guide_Id = ? 
                        WHERE Guide_Id IS NULL AND U_Id = ?";
        $stmt1 = mysqli_prepare($conn, $updateQuery1);
        mysqli_stmt_bind_param($stmt1, "si", $guideId, $user_id);
        $updateResult1 = mysqli_stmt_execute($stmt1);
 
        if ($updateResult1) {
            $updateQuery2 = "UPDATE guide
                             SET No_of_Students = No_of_Students + 1 
                             WHERE Guide_Id = ?";
            $stmt2 = mysqli_prepare($conn, $updateQuery2);
            mysqli_stmt_bind_param($stmt2, "s", $guideId);
            $updateResult2 = mysqli_stmt_execute($stmt2);

            $getGuideUid = "SELECT U_Id FROM guide WHERE Guide_Id = '$guideId' ";
            $getGuideUidRes = mysqli_query($conn, $getGuideUid);
            $guideUidRow = mysqli_fetch_assoc($getGuideUidRes);
            $guideUid = $guideUidRow['U_Id'];

            $StuName = "SELECT Stu_Name from student WHERE U_Id = $user_id";
            $StuNameRes = mysqli_query($conn, $StuName);
            $Sname = mysqli_fetch_assoc($StuNameRes)['Stu_Name'];

            $message = 'New Student '.$Sname.' Added';
            if ($updateResult2) {
                $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$guideUid,'$message','$currentDate','$currentTime')";
                $notiRes = mysqli_query($conn, $notif);
                if($notiRes){
                    echo "Guide selected successfully!";
                }else{
                    echo "Notification failed";
                }
            } else {
                echo "Error updating guide's student count.";
            }
        } else {
            echo "Error updating student's guide.";
        }
    } else {
        echo "Guide ID is missing.";
    }
}
?>
