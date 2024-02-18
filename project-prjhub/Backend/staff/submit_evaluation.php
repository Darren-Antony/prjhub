<?php
require_once('../../page/config.php');
session_start();
$user_id = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['review_id']) && isset($_POST['review_No']) && isset($_POST['total_marks']) && isset($_POST['feedback'])) {
        // Retrieve the submitted data
        $reviewId = $_POST['review_id'];
        $reviewNo = $_POST['review_No'];
        $totalMarks = $_POST['total_marks'];
        $feedback = $_POST['feedback'];
        
        // Construct the column names based on the review number
        $columnName1 = "Review" . $reviewNo . "_Mark"; 
        $columnName2 = "Rv".$reviewNo."_fdback";
        
        // Construct and execute the update query
        $updateQuery = "UPDATE review SET $columnName1 = $totalMarks, $columnName2 = '$feedback' WHERE Review_Id = $reviewId";
        $updateQueryRes = mysqli_query($conn, $updateQuery);
        
        if ($updateQueryRes) {
            // Redirect the user after successful submission
            header("Location: success_page.php");
            exit(); // Make sure to exit after redirection
        } else {
            // Handle query execution errors
            echo "Error updating review: " . mysqli_error($conn);
        }
    } else {
        // Handle the case where required fields are missing
        echo "Error: Required fields are missing!";
    }
} else {
    // Handle the case where the form is not submitted via POST method
    echo "Error: Form submission method not allowed!";
}
?>
