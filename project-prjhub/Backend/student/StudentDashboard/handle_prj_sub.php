<?php
require_once('../../../page/config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $selectQry = "SELECT * FROM student WHERE U_Id=$user_id";
    $sresult = mysqli_query($conn, $selectQry);
    $Row = mysqli_fetch_assoc($sresult);
    $guide_Id = $Row['Guide_Id'];
    $Stu_Id = $Row['Dept_No'];
    $projectName = mysqli_real_escape_string($conn, $_POST['prjName']); 
    $projectDescription = mysqli_real_escape_string($conn, $_POST['prj_Desc']); 
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    $getGuideUid = "SELECT U_Id FROM guide WHERE Guide_Id = '$guide_Id' ";
    $getGuideUidRes = mysqli_query($conn, $getGuideUid);
    $guideUidRow = mysqli_fetch_assoc($getGuideUidRes);
    $guideUid = $guideUidRow['U_Id'];

    $StuName = "SELECT Stu_Name from student WHERE U_Id = $user_id";
    $StuNameRes = mysqli_query($conn, $StuName);
    $Sname = mysqli_fetch_assoc($StuNameRes)['Stu_Name'];

    $message = $Sname . ' Added a Project ';
    if (!empty($projectName) && !empty($projectDescription)) {
        $ChkForDupliacte = "SELECT * FROM project WHERE Prj_Name='$projectName' or Prj_Desc='$projectDescription' ";
        $result = mysqli_query($conn, $ChkForDupliacte);
      
            $result = mysqli_query($conn, $ChkForDupliacte);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "Error: Project already exists";
        exit();
    } else {
        $insrtQuery = "INSERT INTO project (Stu_Id,Guide_Id,Prj_Name,Prj_Desc,Prj_Status,Date_of_Submission,Time_of_Submission) VALUES ('$Stu_Id','$guide_Id','$projectName','$projectDescription','Pending-Approval','$currentDate','$currentTime')";

        $result = mysqli_query($conn, $insrtQuery);

        if ($result) {
            $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$guideUid,'$message','$currentDate','$currentTime')";
            $notiRes = mysqli_query($conn, $notif);
            echo "Project added successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

}
} else {
    echo "Invalid request method.";
}
?>
