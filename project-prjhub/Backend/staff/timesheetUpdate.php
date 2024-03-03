<?php
require_once('../../page/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  session_start();
    $project_id= $_POST['prj_Id'];
    $user_id = $_SESSION['suser_id'];
    
    $getstu = "SELECT student.U_Id 
    FROM student 
    JOIN project ON student.Dept_No = project.Stu_Id
    WHERE project.Prj_Id = $project_id"; 
    $getStuRes = mysqli_query($conn, $getstu);    $start_date = $_POST["start_date"];
    $getStuRow = mysqli_fetch_assoc($getStuRes);
    $Stu_uid = $getStuRow['U_Id'];
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $prjId = $_POST['prj_Id'];
    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    
    // Update each day's activity
    foreach ($days as $day) {
        $activity_field_name = strtolower($day) . "Activity";
        $activity_value = $_POST[$activity_field_name];
        $prjId = $_POST['prj_Id'];
        $sql = "UPDATE timesheet SET $activity_field_name = '$activity_value', STATUS = 'approved' WHERE startDate = '$start_date' AND Proj_Id = $prjId";
        if (!mysqli_query($conn, $sql)) {
            echo "Error updating record: " . mysqli_error($conn);
        }
        $message = "This weeks timesheet has been approved";
        $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$Stu_uid,'$message','$currentDate','$currentTime')";
        $notiRes = mysqli_query($conn, $notif);
    }
    
    // Close connection
    mysqli_close($conn);
    
    // Redirect back to the form or to a success page
    echo "<script>window.history.back();</script>";
    exit();
} else {
    // Redirect to the form page if accessed directly without submission
    header("Location: viewPrjTmsht.php");
    exit();
}
