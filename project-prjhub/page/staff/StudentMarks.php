<?php
session_start();
require_once('../config.php');
$user_id = $_SESSION['suser_id'];
$prjId = $_GET['prjId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
   
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../style/dashboard/stdashboard.css">
    <script src="../../dependancies/jquery.js"></script>
     <link rel="stylesheet" href="../../style/dashboard/markDisp.css">
    <script src="../../dependancies/progressbar.min.js"></script>
    <title>dashboard</title>
    <style>
       
       #container {
          margin: 20px;
          width: 200px;
          height: 200px;
          position: relative;
        }
       
        .containerc {
            margin: 20px;
            width: 200px;
            height: 100px;
            
        }   
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
$ReviewQuery = "SELECT * FROM review WHERE Prj_id= $prjId";
$ReviewRes = mysqli_query($conn, $ReviewQuery);
$ReviewRow = mysqli_fetch_assoc($ReviewRes);

if ($ReviewRow) {
    $Rv_Id = $ReviewRow['Review_Id'];
    $RvdocQuery1 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id and review_no=1";
    $RvdocRes1 = mysqli_query($conn, $RvdocQuery1);
   
    $RvdocQuery2 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id and review_no=2";
    $RvdocRes2 = mysqli_query($conn, $RvdocQuery2);

    $RvdocQuery3 = "SELECT * FROM review_doc WHERE rv_Id=$Rv_Id and review_no=3";
    $RvdocRes3 = mysqli_query($conn, $RvdocQuery3);

    $currentDate = date("Y-m-d");
}
?>
<div class="metadata">
    <div class="data-left">
        <?php
           $sql = "SELECT 
           SUM(CASE WHEN Review1_Date IS NOT NULL AND Review1_Mark IS NOT NULL THEN 1 ELSE 0 END) AS review1_completed,
           SUM(CASE WHEN Review2_Date IS NOT NULL AND Review2_Mark IS NOT NULL THEN 1 ELSE 0 END) AS review2_completed,
           SUM(CASE WHEN Review3_Date IS NOT NULL AND Review3_Mark IS NOT NULL THEN 1 ELSE 0 END) AS review3_completed
       FROM review WHERE Prj_Id = $prjId";

$result = mysqli_query($conn, $sql);

if ($result) {
   $row = mysqli_fetch_assoc($result);

   $total_completed_reviews = $row['review1_completed'] + $row['review2_completed'] + $row['review3_completed'];

} else {
   echo "Error executing the query: " . mysqli_error($conn);
}
$sql = "SELECT COUNT(*) AS document_count FROM review_doc WHERE Prj_Id= $prjId";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    $total_submitted_doc=$row['document_count'];
} else {
    echo "Error executing the query: " . mysqli_error($conn);
}


        ?>

        <div class="top">
        <h1>Mark Details</h1>
        </div>
        <div class="bottom">
        <h3>No of review completed:<?php echo $total_completed_reviews."/3"?></h3>
        <h3>No of Documents Submitted<?php echo $total_submitted_doc."/3"?></h3>
        
        </div>
       
    </div>
    <div class="data-right">
    <?php
$sql = "SELECT COALESCE(Review1_Mark, 0) + COALESCE(Review2_Mark, 0) + COALESCE(Review3_Mark, 0) AS total_marks FROM review WHERE Prj_Id = $prjId";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $marks = $row['total_marks'];
} else {
    echo "Error executing the query: " . mysqli_error($conn);
}
?>

     <div id="container"></div>
    </div>
</div>
<div class="mark-cont">
<div class="div-review1">
     <div class="inner-rv">
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review1_Mark'] == NULL) {
            $fillAmount1= 0;
            $maxLimit1 = 30;
            ?><div class="containerc" id="container1"></div><?php
            if ($ReviewRow['Review1_Date'] == NULL) {
                echo 'Enter a date for review1';
            } else if (mysqli_num_rows($RvdocRes1) == 0) {
                echo '<span class="nodoc" >No document submitted yet</span><br>';
            } else {
                echo '<button onclick="sendReviewId(' . $Rv_Id . ',1)">Enter Marks</button>';
            }
            
        } else {
            $fillAmount1 =   $ReviewRow['Review1_Mark'];
            $maxLimit1 = 30;
            ?><div class="containerc" id="container1"></div>       <?php }?>
    
    
    </div>
    <div class="rv-date">
        <?php
        if ($ReviewRow['Review1_Date'] == NULL) {
         
            echo '<input id="dateVal" type="date" onchange="validateForm(\'dateVal\', \'confirmDateBtn1\',\'validationSummary1\')"><br>';

            ?>
              
                <button id="confirmDateBtn1" onclick="confirmDate(1)" disabled>Confirm Date</button>
              
            <?php
        } else {
            echo"Review Date:";
            echo '<input type="date" value="' . $ReviewRow['Review1_Date'] . '" disabled>';
            
        }
        ?>
        <div class="error" id="validationSummary1" style="margin-top: 20px;"></div>
    </div>
    </div>
</div>

<div class="div-review2">
    <div class="rv-mark">
        <?php
        
                  
                    if ($ReviewRow['Review2_Mark'] == NULL) {
                        $fillAmount2 = 0;
                        $maxLimit2 = 30;
                        ?><div class="containerc" id="container2"></div><?php
                        if ($ReviewRow['Review2_Date'] == NULL) {
                            
                        } else if (mysqli_num_rows($RvdocRes2) == 0) {
                            echo "No document submitted yet";
                        } else {
                            echo '<button onclick="sendReviewId(' . $Rv_Id . ',2)">Enter Marks</button>';           
                         }
                    } else {
                        $fillAmount2 =   $ReviewRow['Review2_Mark'];
                        $maxLimit2 = 30;
                        ?><div class="containerc" id="container2"></div>       <?php }?>                    
                    <div class="rv-date">
                    <?php
                    if ($ReviewRow['Review2_Date'] == NULL && $ReviewRow['Review1_Date'] !== NULL) {
                        echo 'Enter a date for review';
                        echo '<input id="dateVal" type="date" onchange="validateForm(\'dateVal\', \'confirmDateBtn2\',\'validationSummary2\')"><br>';
                        ?>
                        <button id="confirmDateBtn2" onclick="confirmDate(2)">Confirm Date</button>
                        <?php
                    } elseif ($ReviewRow['Review2_Date'] !== NULL) {
                        echo '<input type="date" value="' . $ReviewRow['Review2_Date'] . '" disabled>';
                    } else {
                        echo 'Review 1 need to be completed';
                    }
                 ?>
                </div><?php
            
        
      
        ?>
<div class="error" id="validationSummary2" style="margin-top: 20px;"></div>
   
</div>
    </div>
<div class="div-review3">
    <div class="rv-mark">
        <?php
        
         
                    if ($ReviewRow['Review3_Mark'] == NULL) {
                        $fillAmount3 =  0;
                        $maxLimit3 = 40;
                        ?><div class="containerc" id="container3"></div><?php
                        if ($ReviewRow['Review3_Date'] == NULL) {
                           
                        } else if (mysqli_num_rows($RvdocRes3) == 0) {
                            echo "No document submitted yet";
                        } else {
                            echo '<button onclick="sendReviewId(' . $Rv_Id . ',3)">Enter Marks</button>';            }
                    } else {
                        $fillAmount3 =  $ReviewRow['Review3_Mark'];
                        $maxLimit3 = 30;
                        ?><div class="containerc" id="container3"></div>       <?php }?>                    
                    <?php
                    if ($ReviewRow['Review3_Date'] == NULL && $ReviewRow['Review2_Date'] !== NULL ) {
                        echo 'Enter a date for review';
                        echo '<input id="dateVal" type="date" onchange="validateForm(\'dateVal\', \'confirmDateBtn3\',\'validationSummary3\')"><br>';
                        ?>
                        <button id="confirmDateBtn3" onclick="confirmDate(3)">Confirm Date</button>
                        <?php
                    } elseif ($ReviewRow['Review3_Date'] !== NULL) {
                        echo '<input type="date" value="' . $ReviewRow['Review3_Date'] . '" disabled>';
                    } else {
                        echo 'Review 3 needs to be completed';
                    }
                 ?>
                </div><?php
              
             
        ?>
        <div class="error" id="validationSummary3" style="margin-top: 20px;"></div>
    </div>
   
</div>
</div>
<script>
    function validateForm(inputId, buttonId,summaryid) {
    var errors = [];
    var dateVal = document.getElementById(inputId).value;
    var inputDate1 = new Date(dateVal);
    var currentDate = new Date();

    if (inputDate1 <= currentDate) {
        errors.push("Date should be in the future.");
    }

    var validationSummary = document.getElementById(summaryid);
    if (errors.length > 0) {
    var htmlContent = "<div class='error'><ul>";
    for (var i = 0; i < errors.length; i++) {
        htmlContent += "<li>" + errors[i] + "</li>";
    }
    htmlContent += "</ul></div>";
    validationSummary.innerHTML = htmlContent;
    document.getElementById(buttonId).disabled = true; // Disable the button
    return false;
} else {
    validationSummary.innerHTML = "";
    document.getElementById(buttonId).disabled = false; // Enable the button
    return true;
}

}


//   var inputs = document.querySelectorAll('input, select');
//         for (var i = 0; i < inputs.length; i++) {
//             inputs[i].addEventListener('change', function() {
//                 validateForm();
//             });
//         }
    
var totalMarks = 100; 
var obtainedMarks = <?php echo $marks; ?>;  
console.log(obtainedMarks);
var progressValue = obtainedMarks / totalMarks;

var bar = new ProgressBar.Circle(container, {
  color: '#aaa',
  strokeWidth: 4,
  trailWidth: 1,
  easing: 'easeInOut',
  duration: 1400,
  text: {
    autoStyleContainer: false
  },
  from: { color: '#aaa', width: 1 },
  to: { color: '#333', width: 4 },
  step: function(state, circle) {
    circle.path.setAttribute('stroke', state.color);
    circle.path.setAttribute('stroke-width', state.width);

    var value = obtainedMarks + '/' + totalMarks;;
   
      circle.setText(value);
  
  }
});

bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
bar.text.style.fontSize = '2rem';

bar.animate(progressValue);

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

   var fillAmount1 = <?php echo json_encode($fillAmount1); ?>;
    
    var maxLimit1 = <?php echo json_encode($maxLimit1); ?>;
    
    var bar = new ProgressBar.SemiCircle(container1, {
        strokeWidth: 6,
        color: '#FFEA82',
        trailColor: '#eee',
        trailWidth: 1,
        easing: 'easeInOut',
        duration: 1400,
        svgStyle: null,
        text: {
            value: '',
            alignToBottom: false
        },
        from: {color: '#FFEA82'},
        to: {color: '#ED6A5A'},
        step: function (state, bar) {
            bar.path.setAttribute('stroke', state.color);
            var value = fillAmount1 + '/' + 30;


            if (value === 0) {
                bar.setText('');
            } else {
                bar.setText(value);
            }
            bar.text.style.color = state.color;
        }
    });

    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';

    bar.animate(fillAmount1 / maxLimit1);
  
    var fillAmount2 = <?php echo json_encode($fillAmount2); ?>;
    
    var maxLimit2= <?php echo json_encode($maxLimit2); ?>;
    
    var bar = new ProgressBar.SemiCircle(container2, {
        strokeWidth: 6,
        color: '#FFEA82',
        trailColor: '#eee',
        trailWidth: 1,
        easing: 'easeInOut',
        duration: 1400,
        svgStyle: null,
        text: {
            value: '',
            alignToBottom: false
        },
        from: {color: '#FFEA82'},
        to: {color: '#ED6A5A'},
        step: function (state, bar) {
            bar.path.setAttribute('stroke', state.color);
            var value = fillAmount2 + '/' + 30;


            if (value === 0) {
                bar.setText('');
            } else {
                bar.setText(value);
            }
            bar.text.style.color = state.color;
        }
    });

    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';

    bar.animate(fillAmount2 / maxLimit2);
  
    var fillAmount3 = <?php echo json_encode($fillAmount3); ?>;
    
    var maxLimit3 = <?php echo json_encode($maxLimit3); ?>;
    
    var bar = new ProgressBar.SemiCircle(container3, {
        strokeWidth: 6,
        color: '#FFEA82',
        trailColor: '#eee',
        trailWidth: 1,
        easing: 'easeInOut',
        duration: 1400,
        svgStyle: null,
        text: {
            value: '',
            alignToBottom: false
        },
        from: {color: '#FFEA82'},
        to: {color: '#ED6A5A'},
        step: function (state, bar) {
            bar.path.setAttribute('stroke', state.color);
            var value = fillAmount3 + '/' + 30;


            if (value === 0) {
                bar.setText('');
            } else {
                bar.setText(value);
            }
            bar.text.style.color = state.color;
        }
    });

    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';

    bar.animate(fillAmount3 / maxLimit3);
  
  
    
</script>

</body>

</html>
