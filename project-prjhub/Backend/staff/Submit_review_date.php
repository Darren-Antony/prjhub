<?php
require_once('../../page/config.php');
if(isset($_POST['reviewID'], $_POST['reviewNumber'], $_POST['reviewDate'], $_POST['Prj_ID'])) {
  
    $reviewID = $_POST['reviewID'];
    $reviewNumber = $_POST['reviewNumber'];
    $reviewDate = $_POST['reviewDate'];
    $Prj_ID = $_POST['Prj_ID'];

    if ($reviewNumber < 1 || $reviewNumber > 3) {
        echo "Error: Invalid review number";
        exit;
    }
    
    // if (!strtotime($reviewDate)) {
    //     echo "Error: Invalid review date format";
    //     exit;
    // }


    $columnName = "Review" . $reviewNumber . "_Date";
   
    $query = "UPDATE review SET $columnName = '$reviewDate' WHERE Review_Id = $reviewID AND Prj_Id = $Prj_ID";

 
    if (mysqli_query($conn, $query)) {
      
        echo "Review $reviewNumber date updated successfully";
    } else {
        
        echo "Error updating review $reviewNumber date: " . mysqli_error($conn);
    }
} else {
    
    echo 'Error: Required parameters are missing';
}
?>
