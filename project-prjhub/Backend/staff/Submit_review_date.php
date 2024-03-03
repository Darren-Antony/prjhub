<?php
require_once('../../page/config.php');
if(isset($_POST['reviewID'], $_POST['reviewNumber'], $_POST['reviewDate'], $_POST['Prj_ID'])) {
    session_start();
    $user_id = $_SESSION['suser_id'];
    
    $reviewID = $_POST['reviewID'];
    $reviewNumber = $_POST['reviewNumber'];
    $reviewDate = $_POST['reviewDate'];
    $Prj_ID = $_POST['Prj_ID'];
    $getstu = "SELECT student.U_Id 
    FROM student 
    JOIN project ON student.Dept_No = project.Stu_Id
    WHERE project.Prj_Id = $Prj_ID"; 
    $getStuRes = mysqli_query($conn, $getstu);    $start_date = $_POST["start_date"];
    $getStuRow = mysqli_fetch_assoc($getStuRes);
    $Stu_uid = $getStuRow['U_Id'];
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    if ($reviewNumber < 1 || $reviewNumber > 3) {
        echo "Error: Invalid review number";
        exit;
    }
    
   


    $columnName = "Review" . $reviewNumber . "_Date";
   
    $query = "UPDATE review SET $columnName = '$reviewDate' WHERE Review_Id = $reviewID AND Prj_Id = $Prj_ID";

 
    if (mysqli_query($conn, $query)) {
        $message = "Review".$reviewNumber."Scheduled Submit document on or before".$reviewDate;
        $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$Stu_uid,'$message','$currentDate','$currentTime')";
        $notiRes = mysqli_query($conn, $notif);
        echo "Review $reviewNumber date updated successfully";
    } else {
        
        echo "Error updating review $reviewNumber date: " . mysqli_error($conn);
    }
} else {
    
    echo 'Error: Required parameters are missing';
}
?>
