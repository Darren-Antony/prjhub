<?php
require_once('../../../page/config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $projectName = $_POST['prjName'];
    $projectDescription = $_POST['prj_Desc'];
    
    // Validate form data (you can add more validation as needed)
    if (!empty($projectName) && !empty($projectDescription)) {
        // Process the form data (for demonstration, we'll just echo back the submitted data)
        echo "Project Name: $projectName\n";
        echo "Description: $projectDescription\n";

        // You can perform further actions here, such as saving the data to a database
        // Replace this with your actual database operations
    } else {
        // Handle empty or invalid form data
        echo "Please fill in all fields.";
    }
} else {
    // If the request method is not POST, handle accordingly
    echo "Invalid request method.";
}
?>
