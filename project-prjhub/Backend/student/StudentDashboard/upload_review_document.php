<?php
// Include the database configuration file
require_once('../../../page/config.php');

// Check if the form is submitted
if(isset($_POST["submit"])) {
    // Get the review ID and project ID from the form
    $reviewID = $_POST['reviewID'];
    $prjId = $_POST['prjId'];
    $reviewNumber = $_POST['reviewNumber'];

    // Define the directory where uploaded files will be stored
    $targetDir = "../../../uploads/";

    // Get the file name
    $fileName = basename($_FILES["review".$reviewNumber."_file"]["name"]);

    // Define the target file path
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
                    echo "The file ".$fileName. " has been uploaded successfully.";
                } else{
                    echo "Error inserting file data into the database.";
                } 
            } else{
                echo "Error uploading file.";
            }
        } else{
            echo "Only PDF files are allowed.";
        }
    } else{
        echo "Please select a file to upload.";
    }
}
?>
