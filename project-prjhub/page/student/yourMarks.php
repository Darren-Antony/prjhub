<?php
require_once('../config.php');
session_start();
$user_id = $_SESSION['user_id'];
$prjId = $_GET['prjId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../style/dashboard/stdashboard.css">
    <link rel="stylesheet" href="../../style/dashboard/markDisp.css">
    <title>dashboard</title>
</head>

<body>
<div class="logo-cont">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
    <h1>Academic Project Tracker</h1>
</div>

<?php
// Query to fetch review details
$ReviewQuery = "SELECT * FROM review WHERE Prj_id= $prjId";
$ReviewRes = mysqli_query($conn, $ReviewQuery);
$ReviewRow = mysqli_fetch_assoc($ReviewRes);

// Check if review exists
if ($ReviewRow) {
    // Query to fetch review document details
    $Rv_Id = $ReviewRow['Review_Id'];
    $RvdocQuery1 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id and review_no=1";
    $RvdocRes1 = mysqli_query($conn, $RvdocQuery1);
   
    $RvdocQuery2 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id and review_no=2";
    $RvdocRes2 = mysqli_query($conn, $RvdocQuery2);

    $RvdocQuery3 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id and review_no=3";
    $RvdocRes3 = mysqli_query($conn, $RvdocQuery3);

    // Get current date
    $currentDate = date("Y-m-d");

    // Display Review 1 details
    ?>
    <!-- Review 1 -->
<div class="div-review1">
    <div class="rv-mark">
        <?php
        // Check if Review 1 mark is available
        if ($ReviewRow['Review1_Mark'] == NULL) {
            // Check if Review 1 date is available
            if ($ReviewRow['Review1_Date'] == NULL) {
                echo 'Review 1 date not available';
            } else {
                echo 'Review 1 Date: ' . $ReviewRow['Review1_Date'];
            }
            
          
        } else {
            echo 'Review 1 Marks: ' . $ReviewRow['Review1_Mark'];
        }
        ?>
    </div>
    <div class="rv-date">
           <?php
            // Check if Review 1 document is submitted
            if (mysqli_num_rows($RvdocRes1) == 0) {
                echo "No document submitted for Review 1";
                // Add file upload form for Review 1
                ?>
                <form action="../../Backend/student/StudentDashboard/upload_review_document.php/" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="prjId" value="<?php echo $prjId; ?>">
                    <input type="hidden" name="reviewNumber" value="1">
                    <input type="hidden" name="reviewID" value="<?php echo $Rv_Id; ?>">
                    <input type="file" name="review1_file" accept=".pdf">
                    <button type="submit" name="submit">Upload Document</button>
                </form>
                <?php
            } else {
                echo "Document submitted for Review 1";
            }?>
    </div>
</div>

<?php
    // Display Review 2 details
    ?>
    <!-- Review 2 -->
<div class="div-review2">
    <div class="rv-mark">
        <?php
        // Check if Review 2 mark is available
        if ($ReviewRow['Review2_Mark'] == NULL) {
            // Check if Review 2 date is available
            if ($ReviewRow['Review2_Date'] == NULL) {
                echo 'Review 2 date not available';
            } else {
                echo 'Review 2 Date: ' . $ReviewRow['Review2_Date'];
            }
        } else {
            echo 'Review 2 Marks: ' . $ReviewRow['Review2_Mark'];
        }
        ?>
    </div>
    <div class="rv-date">
        <?php
        // Check if Review 2 document submission is allowed
        $review2Date = $ReviewRow['Review2_Date'];
        if ($review2Date != NULL) {
            $allowSubmissionDate = date("Y-m-d", strtotime('-1 day', strtotime($review2Date)));
            if ($currentDate >= $allowSubmissionDate) {
               
                // Check if Review 1 document is submitted
                if (mysqli_num_rows($RvdocRes2) == 0) {
                    echo "No document submitted for Review 2";
                    // Add file upload form for Review 1
                    ?>
                    <form action="../../Backend/student/StudentDashboard/upload_review_document.php/" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="prjId" value="<?php echo $prjId; ?>">
                        <input type="hidden" name="reviewNumber" value="2">
                        <input type="hidden" name="reviewID" value="<?php echo $Rv_Id; ?>">
                        <input type="file" name="review2_file" accept=".pdf">
                        <button type="submit" name="submit">Upload Document</button>
                    </form>
                    <?php
                } else {
                    echo "Document submitted for Review 2";
                }
        } else {
            echo "Review 2 date not available";
        }
    }
        ?>
    </div>
</div>

    <?php
    // Display Review 3 details
    ?>
    <!-- Review 3 -->
    <div class="div-review3">
    <div class="rv-mark">
        <?php
        // Check if Review 2 mark is available
        if ($ReviewRow['Review3_Mark'] == NULL) {
            // Check if Review 2 date is available
            if ($ReviewRow['Review3_Date'] == NULL) {
                echo 'Review 3 date not available';
            } else {
                echo 'Review 3 Date: ' . $ReviewRow['Review3_Date'];
            }
        } else {
            echo 'Review 3 Marks: ' . $ReviewRow['Review3_Mark'];
        }
        ?>
    </div>
    <div class="rv-date">
        <?php
        // Check if Review 3 document submission is allowed
        $review3Date = $ReviewRow['Review3_Date'];
        if ($review3Date != NULL) {
            $allowSubmissionDate = date("Y-m-d", strtotime('-1 day', strtotime($review3Date)));
            if ($currentDate >= $allowSubmissionDate) {
               
                // Check if Review 1 document is submitted
                if (mysqli_num_rows($RvdocRes3) == 0) {
                    echo "No document submitted for Review 3";
                    // Add file upload form for Review 1
                    ?>
                    <form action="../../Backend/student/StudentDashboard/upload_review_document.php/" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="prjId" value="<?php echo $prjId; ?>">
                        <input type="hidden" name="reviewNumber" value="3">
                        <input type="hidden" name="reviewID" value="<?php echo $Rv_Id; ?>">
                        <input type="file" name="review3_file" accept=".pdf">
                        <button type="submit" name="submit">Upload Document</button>
                    </form>
                    <?php
                } else {
                    echo "Document submitted for Review 3";
                }
        } else {
            echo "Review 3 date not available";
        }
    }
        ?>
    </div>
</div>
    <?php
} else {
    // Display message if review details are not available
    echo "Review details not available for this project";
}
?>

</script>

</body>
</html>
