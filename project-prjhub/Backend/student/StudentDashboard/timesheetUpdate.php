<?php
require_once('../../../page/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming the form fields are sanitized before processing
    $start_date = $_POST["start_date"];
    

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Define days of the week
    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    
    // Update each day's activity
    foreach ($days as $day) {
        $activity_field_name = strtolower($day) . "Activity";
        $activity_value = $_POST[$activity_field_name];
        $prjId = $_POST['prj_Id'];
        $sql = "UPDATE timesheet SET $activity_field_name = '$activity_value' WHERE startDate = '$start_date' and Proj_Id='$prjId'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    
    // Close connection
    mysqli_close($conn);
    
    // Redirect back to the form or to a success page
    header("Location:../../../page/student/stuTimesheet.php");
    exit();
} else {
    // Redirect to the form page if accessed directly without submission
    header("Location: ../../../page/student/stuTimesheet.php");
    exit();
}
