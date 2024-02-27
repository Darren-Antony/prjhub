<?php
session_start();
require_once('../config.php');
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
    <script src="../../dependancies/jquery.js"></script>
     <script src="../../script/staff/marks/setreviewdoc.js"></script>
     <link rel="stylesheet" href="../../style/dashboard/markDisp.css">

    <title>dashboard</title>
    <style>
       

    </style>
</head>

<body >
<div class="logo-cont">
    <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
       
    </div>

<?php
$ReviewQuery = "SELECT * FROM Review WHERE Prj_Id= $prjId";
$ReviewRes = mysqli_query($conn, $ReviewQuery);
$ReviewRow = mysqli_fetch_assoc($ReviewRes);
$Rv_Id=$ReviewRow['Review_Id'];
$RvdocQuery1 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id AND review_no=1";
$RvdocRes1 = mysqli_query($conn, $RvdocQuery1);

if (!$RvdocRes1) {
    echo "Error: " . mysqli_error($conn);
    exit; 
}

$RvdocQuery2 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id AND review_no=2";
$RvdocRes2 = mysqli_query($conn, $RvdocQuery2);

if (!$RvdocRes2) {
    echo "Error: " . mysqli_error($conn);
    exit; 
}

$RvdocQuery3 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id AND review_no=3";
$RvdocRes3 = mysqli_query($conn, $RvdocQuery3);

if (!$RvdocRes3) {
    echo "Error: " . mysqli_error($conn);
    exit; 
}

$oneMonthAfterReview1 = null;
$currentDate = null;
$oneMonthAfterReview2 = null;
$oneMonthAfterReview2 = null;   
if ($ReviewRow['Review1_Mark'] !== NULL && $ReviewRow['Review1_Date'] !== NULL) {
    $review1Date = strtotime($ReviewRow['Review1_Date']);
    $oneMonthAfterReview1 = strtotime('+1 month', $review1Date);
    $currentDate = time();
    
}
if ($ReviewRow['Review2_Mark'] !== NULL && $ReviewRow['Review2_Date'] !== NULL) {
    $review2Date = strtotime($ReviewRow['Review2_Date']);
    $oneMonthAfterReview2 = strtotime('+1 month', $review2Date);
    $currentDate = time();
    
}
?>
<div class="mark-cont">
<div class="div-review1">

    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review1_Mark'] == NULL) {
            if ($ReviewRow['Review1_Date'] == NULL) {
                echo 'Enter a date for review';
            } else if (mysqli_num_rows($RvdocRes1) == 0) {
                echo "No document submitted yet <br>";
            } else {
                echo '<button onclick="sendReviewId(' . $Rv_Id . ',1)">Enter Marks</button>';            }
        } else {
            ?>
           
            <?php
        }
        ?>
    </div>
    <div class="rv-date">
        <?php
        if ($ReviewRow['Review1_Date'] == NULL) {
         
            echo '<input type="date">';
            ?>
            <button onclick="confirmDate(1)">Confirm Date</button>
            <?php
        } else {
            echo"Review Date:";
            echo '<input type="date" value="' . $ReviewRow['Review1_Date'] . '" disabled>';
            
        }
        ?>
    </div>
</div>

<div class="div-review2">
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review1_Mark'] !== NULL && $ReviewRow['Review1_Date'] !== NULL) {
            if ($oneMonthAfterReview1 !== null && $currentDate !== null) {
                if ($currentDate >= $oneMonthAfterReview1) {
                  
                    if ($ReviewRow['Review2_Mark'] == NULL) {
                        if ($ReviewRow['Review2_Date'] == NULL) {
                            echo 'Enter a date for review';
                        } else if (mysqli_num_rows($RvdocRes2) == 0) {
                            echo "No document submitted yet";
                        } else {
                            echo '<button onclick="sendReviewId(' . $Rv_Id . ',2)">Enter Marks</button>';            }
                    } else {
                        echo $ReviewRow['Review2_Mark'];
                    }
                    ?><div class="rv-date">
                    <?php
                    if ($ReviewRow['Review2_Date'] == NULL && $oneMonthAfterReview1 !== null && $currentDate !== null && $currentDate >= $oneMonthAfterReview1) {
                        echo '<input type="date">';
                        ?>
                        <button onclick="confirmDate(2)">Confirm Date</button>
                        <?php
                    } elseif ($ReviewRow['Review2_Date'] !== NULL) {
                        echo '<input type="date" value="' . $ReviewRow['Review2_Date'] . '" disabled>';
                    } else {
                        echo '<input type="date" disabled>';
                    }
                 ?>
                </div><?php
                } else {
                    echo "Review 2 cannot be scheduled yet";
                }
            }
        }
        else {
            echo "Review 1 needs to be completed first";
        }
        ?>

   
</div>
    </div>
<div class="div-review3">
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review2_Mark'] !== NULL && $ReviewRow['Review2_Date'] !== NULL) {
            if ($oneMonthAfterReview2 !== null && $currentDate !== null) {
                if ($currentDate >= $oneMonthAfterReview2) {
                    if ($ReviewRow['Review3_Mark'] == NULL) {
                        if ($ReviewRow['Review3_Date'] == NULL) {
                            echo 'Enter a date for review';
                        } else if (mysqli_num_rows($RvdocRes3) == 0) {
                            echo "No document submitted yet";
                        } else {
                            echo '<button onclick="sendReviewId(' . $Rv_Id . ',3)">Enter Marks</button>';            }
                    } else {
                        echo $ReviewRow['Review3_Mark'];
                    }
                    ?><div class="rv-date">
                    <?php
                    if ($ReviewRow['Review3_Date'] == NULL && $oneMonthAfterReview2 !== null && $currentDate !== null && $currentDate >= $oneMonthAfterReview2) {
                        echo '<input type="date">';
                        ?>
                        <button onclick="confirmDate(3)">Confirm Date</button>
                        <?php
                    } elseif ($ReviewRow['Review3_Date'] !== NULL) {
                        echo '<input type="date" value="' . $ReviewRow['Review3_Date'] . '" disabled>';
                    } else {
                        echo '<input type="date" disabled>';
                    }
                 ?>
                </div><?php
              
                } else {
                    echo "Review 3 cannot be scheduled yet";
                }
            }
        } else {
            echo "Review 2 needs to be completed first";
        }
        ?>
    </div>
   
</div>
</div>
<script>
     function sendReviewId(reviewId, reviewNumber) {
        window.location.href = '../staff/markInstruction.php?review_id=' + reviewId + '&review_number=' + reviewNumber;
    }
function confirmDate(reviewNumber) {
    var reviewID = <?php echo $ReviewRow['Review_Id']; ?>;
    var Prj_ID = <?php echo $prjId?>;

    var reviewDate = $('.div-review' + reviewNumber + ' input[type="date"]').val();

    console.log("Data to be sent:");
    console.log("Review ID: " + reviewID);
    console.log("Review Number: " + reviewNumber);
    console.log("Review Date: " + reviewDate);
    console.log("Project ID: " + Prj_ID);

    $.ajax({
        type: 'POST',
        url: '../../Backend/staff/Submit_review_date.php',
        data: { reviewID: reviewID, reviewNumber: reviewNumber, reviewDate: reviewDate, Prj_ID: Prj_ID},
        success: function(response) {
            console.log('Review ' + reviewNumber + ' date confirmed successfully');
        },
        error: function(xhr, status, error) {
            console.error('Error confirming review date:', error);
        }
    });
}



</script>

</body>

</html>
