<?php
require_once('../../page/config.php');

// Check if the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["project_id"]) && isset($_POST["status"])) {
    // Sanitize input data
    $project_id = filter_var($_POST["project_id"], FILTER_SANITIZE_NUMBER_INT);
    $status = $_POST["status"];

    if($status == 'In-Progress') {
        // Update project status based on the provided data
        $sql = "UPDATE project SET Prj_Status = ? WHERE Prj_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $project_id);
        if ($stmt->execute()) {
            // Return a success message (you can customize this response as needed)
            echo "Project status updated successfully to '$status'!";
            $insRvRec="INSERT INTO review (Prj_Id) VALUES($project_id)";
            $exqry = mysqli_query($conn,$insRvRec); 
        } else {
            echo "Error updating project status: " . $stmt->error;
        }
    } elseif ($status == 'rejected' && isset($_POST["reason"])) {
        $reason = $_POST["reason"];
        // Update project status and reason for rejection based on the provided data
        $sql = "UPDATE project SET Prj_Status = 'rejected', rejection_reason	 = ? WHERE Prj_Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $reason, $project_id);
        if ($stmt->execute()) {
            // Return a success message (you can customize this response as needed)
            echo "Project status updated successfully to 'Rejected' with reason: '$reason'!";
        } else {
            echo "Error updating project status: " . $stmt->error;
        }
    } else {
        echo "Error: Invalid status or missing reason for rejection!";
    }
} else {
    // If the request method is not POST or if required parameters are missing
    http_response_code(400); // Bad request
    echo "Error: Invalid request!";
}

// Close connection
$conn->close();
?>
