<?php
require_once('../../../page/config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
        
    // Escape user inputs for security
    $prjId = mysqli_real_escape_string($conn,$_POST['prj_Id']);
    $startDate = mysqli_real_escape_string($conn, $_POST['start_date']);
    $mondayActivity = mysqli_real_escape_string($conn, $_POST['monday_activity']);
    $tuesdayActivity = mysqli_real_escape_string($conn, $_POST['tuesday_activity']);
    $wednesdayActivity = mysqli_real_escape_string($conn, $_POST['wednesday_activity']);
    $thursdayActivity = mysqli_real_escape_string($conn, $_POST['thursday_activity']);
    $fridayActivity = mysqli_real_escape_string($conn, $_POST['friday_activity']);
    $saturdayActivity = mysqli_real_escape_string($conn, $_POST['saturday_activity']);
    $status = "pending-approval";
    
    $user_id = $_SESSION['user_id'];
    $projectName = $_POST['prjName'];
    $selectQry = "SELECT * FROM student WHERE U_Id=$user_id";
    $sresult= mysqli_query($conn,$selectQry);
    $Row = mysqli_fetch_assoc($sresult);
    $guide_Id = $Row['Guide_Id'];
    $Stu_Id = $Row['Dept_No'];
    $projectDescription = $_POST['prj_Desc'];
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    $getGuideUid = "SELECT U_Id FROM guide WHERE Guide_Id = '$guide_Id' ";
    $getGuideUidRes = mysqli_query($conn, $getGuideUid);
            $guideUidRow = mysqli_fetch_assoc($getGuideUidRes);
            $guideUid = $guideUidRow['U_Id'];

            $StuName = "SELECT Stu_Name from student WHERE U_Id = $user_id";
            $StuNameRes = mysqli_query($conn, $StuName);
            $Sname = mysqli_fetch_assoc($StuNameRes)['Stu_Name'];

            $message = $Sname.' Added this weeks timesheet';
    // Prepare an INSERT statement
    $stmt = $conn->prepare("INSERT INTO timesheet (startDate, mondayActivity, tuesdayActivity, wednesdayActivity, thursdayActivity, fridayActivity, saturdayActivity, STATUS, Proj_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check for errors
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind parameters to the statement
    $stmt->bind_param("ssssssssi", $startDate, $mondayActivity, $tuesdayActivity, $wednesdayActivity, $thursdayActivity, $fridayActivity, $saturdayActivity, $status, $prjId);

    // Execute the prepared statement
    $stmt->execute();

    // Check for successful insertion
    if ($stmt->affected_rows > 0) {
        echo "Data inserted successfully!";
        $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$guideUid,'$message','$currentDate','$currentTime')";
                $notiRes = mysqli_query($conn, $notif);
                echo "Timesheet Added Sucessfully";

    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();

    mysqli_close($conn);

    echo "<script>window.history.back();</script>";
    exit();
} else {
    echo "Invalid request method.";
}
?>
