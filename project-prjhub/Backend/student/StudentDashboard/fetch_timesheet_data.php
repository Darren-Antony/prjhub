<?php
require_once('../../../page/config.php');

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if date parameter is set
if (isset($_GET['date'])) {
    $selected_date = $_GET['date'];
    $prjId = $_GET['prjId'];

    // Query to fetch timesheet data for the selected date
    $sql = "SELECT * FROM timesheet WHERE startDate = '$selected_date' and Proj_Id = $prjId";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result) {
        // Check if any data found
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            // Encode data as JSON and send response
            echo json_encode(array('exists' => true, 'data' => $data));
        } else {
            // If no data found for the selected date
            echo json_encode(array('exists' => false));
        }
    } else {
        // If query execution failed
        echo json_encode(array('error' => 'Query execution failed: ' . mysqli_error($conn)));
    }
} else {
    // If date parameter is not set
    echo json_encode(array('error' => 'Date parameter is not set'));
}

// Close database connection
mysqli_close($conn);
?>
