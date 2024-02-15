<?php
require_once('../../../page/config.php');

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
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    mysqli_close($conn);

    // Redirect after processing
    echo "<script>window.history.back();</script>";
    exit();
} else {
    // Handle invalid request
    echo "Invalid request method.";
}
?>
