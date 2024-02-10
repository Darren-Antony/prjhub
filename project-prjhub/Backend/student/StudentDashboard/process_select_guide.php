<?php
require_once('../../../page/config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["guideId"])) {
        // Sanitize the received guideId
        $guideId = htmlspecialchars($_POST["guideId"]);
        $user_id = $_SESSION['user_id'];

        // Use prepared statements to prevent SQL injection
        $updateQuery1 = "UPDATE student 
                        SET Guide_Id = ? 
                        WHERE Guide_Id IS NULL AND U_Id = ?";
        $stmt1 = mysqli_prepare($conn, $updateQuery1);
        mysqli_stmt_bind_param($stmt1, "si", $guideId, $user_id);
        $updateResult1 = mysqli_stmt_execute($stmt1);

        if ($updateResult1) {
            // Increase the number of students for the selected guide
            $updateQuery2 = "UPDATE guide
                             SET No_of_Students = No_of_Students + 1 
                             WHERE Guide_Id = ?";
            $stmt2 = mysqli_prepare($conn, $updateQuery2);
            mysqli_stmt_bind_param($stmt2, "s", $guideId);
            $updateResult2 = mysqli_stmt_execute($stmt2);

            if ($updateResult2) {
                // Success message or further actions
                echo "Guide selected successfully!";
            } else {
                // Error message or handle failure
                echo "Error updating guide's student count.";
            }
        } else {
            // Error message or handle failure
            echo "Error updating student's guide.";
        }
    } else {
        // Handle if guideId is not set
        echo "Guide ID is missing.";
    }
}
?>
