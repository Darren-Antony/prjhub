<?php
require_once('../../page/config.php');
session_start();
$user_id = $_SESSION['suser_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['review_id']) && isset($_POST['review_No']) && isset($_POST['total_marks']) && isset($_POST['feedback'])) {
        $reviewId = $_POST['review_id'];
        $reviewNo = $_POST['review_No'];
        $totalMarks = $_POST['total_marks'];
        $feedback = $_POST['feedback'];
        $getprjid = "SELECT Prj_id FROM review WHERE Review_Id=$reviewId ";
        $getprjidRes = mysqli_query($conn, $getprjid) or die(mysqli_error($getprjidRes));
        $getprjidRow = mysqli_fetch_assoc($getprjidRes);
        $Prj_ID = $getprjidRow['Prj_id'];
        $getstu = "SELECT student.U_Id 
                 FROM student 
    JOIN project ON student.Dept_No = project.Stu_Id
    WHERE project.Prj_Id = $Prj_ID";
        $getStuRes = mysqli_query($conn, $getstu);
        $start_date = $_POST["start_date"];
        $getStuRow = mysqli_fetch_assoc($getStuRes);
        $Stu_uid = $getStuRow['U_Id'];
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        // Construct the column names based on the review number
        $columnName1 = "Review" . $reviewNo . "_Mark";
        $columnName2 = "Rv" . $reviewNo . "_fdback";

        // Construct and execute the update query
        $updateQuery = "UPDATE review SET $columnName1 = $totalMarks, $columnName2 = '$feedback' WHERE Review_Id = $reviewId";
        $updateQueryRes = mysqli_query($conn, $updateQuery);

        if ($updateQueryRes) {
            $message = "The marks for " . " " . $reviewNo . "has been entered";
            $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$Stu_uid,'$message','$currentDate','$currentTime')";
            $notiRes = mysqli_query($conn, $notif);
            // Redirect to a page based on the project ID
            header("Location: ../../page/staff/StudentMarks.php?prjId=$Prj_ID");
            
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
