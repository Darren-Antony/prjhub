<?php
// Include the database configuration file
require_once('../../../page/config.php');
session_start();

// Check if the form is submitted
if(isset($_POST["submit"])) {
    // Get the review ID and project ID from the form
    $reviewID = $_POST['reviewID'];
    $prjId = $_POST['prjId'];
    $reviewNumber = $_POST['reviewNumber'];

    $user_id = $_SESSION['user_id'];
    $selectQry = "SELECT * FROM student WHERE U_Id=$user_id";
    $sresult= mysqli_query($conn,$selectQry);
    $Row = mysqli_fetch_assoc($sresult);
    $guide_Id = $Row['Guide_Id'];
    $Stu_Id = $Row['Dept_No'];
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    $getGuideUid = "SELECT U_Id FROM guide WHERE Guide_Id = '$guide_Id' ";
    $getGuideUidRes = mysqli_query($conn, $getGuideUid);
    $guideUidRow = mysqli_fetch_assoc($getGuideUidRes);
    $guideUid = $guideUidRow['U_Id'];

    $StuName = "SELECT Stu_Name from student WHERE U_Id = $user_id";
    $StuNameRes = mysqli_query($conn, $StuName);
    $Sname = mysqli_fetch_assoc($StuNameRes)['Stu_Name'];

    $message = $Sname.' Added '.$reviewNumber."document";   
    $targetDir = "../../../uploads/";

    $fileName = basename($_FILES["review".$reviewNumber."_file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Check if file is selected
    if(!empty($_FILES["review".$reviewNumber."_file"]["name"])){
        // Allow certain file formats
        $allowTypes = array('pdf');
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        if(in_array($fileType, $allowTypes)){
            // Upload file to the server
            if(move_uploaded_file($_FILES["review".$reviewNumber."_file"]["tmp_name"], $targetFilePath)){
                // Insert file information into the database
                $insert = "INSERT INTO review_doc (rv_Id, Prj_Id, Doc_Name, Doc_Path,review_no) VALUES ('$reviewID', '$prjId', '$targetFilePath', '$fileName',$reviewNumber)";
                if(mysqli_query($conn, $insert)){
                    $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$guideUid,'$message','$currentDate','$currentTime')";
                    $notiRes = mysqli_query($conn, $notif);
                    // Redirect back to the page upon successful file upload
                    header("Location:http://localhost/prjhub/project-prjhub/page/student/yourMarks.php?prjId=$prjId");
                    exit();
                 
                } else{
                
                    // Redirect back to the page if an error occurs
                    header("Location: javascript://history.go(-1)");
                    exit();
                } 
            } else{
                // Redirect back to the page if an error occurs
                header("Location: javascript://history.go(-1)");
                exit();
            }
        } else{
            // Redirect back to the page if an error occurs
            header("Location: javascript://history.go(-1)");
            exit();
        }
    } else{
        // Redirect back to the page if an error occurs
        header("Location: javascript://history.go(-1)");
        exit();
    }
}
?>
