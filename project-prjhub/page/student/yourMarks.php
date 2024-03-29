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
    <script src="../../script/student/dashboard/dashboard.js"></script>
    <script src="../../script/global.js"></script>
    <title>dashboard</title>
    <style>
        .container {
            margin: 20px;
            width: 200px;
            height: 100px;
        }   
        #containerp {
          margin: 20px;
          width: 200px;
          height: 200px;
          position: relative;
        }
       
    </style>
    <script src="../../dependancies/progressbar.min.js"></script>
</head>

<body>
<div class="logo-cont">
    <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
    <h1>Academic Project Tracker</h1>
    </div>
    
</div>
<div class="goback-cont">
        <button onclick="goBack()">&ltGoBack</button>
    </div>
<?php

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

     <div id="containerp"></div>
    </div>
</div>
<div class="mark-cont">

<div class="div-review1">
<div class="rv-header">Review 1</div>
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review1_Mark'] == NULL) {
            $fillAmount =  0;
            $maxLimit = 30;
            ?><div class="container" id="container"></div>
            <?php
            if ($ReviewRow['Review1_Date'] == NULL) {
                echo 'Review 1 date not available';
            } else {
                echo 'Review 1 Date: ' . $ReviewRow['Review1_Date'];
            }
            
          
        } else {
            
            $fillAmount =  $ReviewRow['Review1_Mark'];
            $maxLimit = 30;
            ?><div class="container" id="container"></div>
            <?php
        }
        ?>
    </div>
    <div class="rv-date">
           <?php
            $review1Date = $ReviewRow['Review1_Date'];
           
              
            if (mysqli_num_rows($RvdocRes1) == 0) {
                echo "No document submitted for Review 1";
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
            }
        ?>
            
    </div>
</div>

<?php
    ?>
<div class="div-review2">
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review2_Mark'] == NULL) {
            $fillAmount2 = 0;
            $maxLimit2 = 30;
            ?><div class="container" id="container2"></div><?php
            if ($ReviewRow['Review2_Date'] == NULL) {
                echo 'Review 2 date not available';
            } else {
                echo 'Review 2 Date: ' . $ReviewRow['Review2_Date'];
            }
        } else {
            $fillAmount2 =   $ReviewRow['Review2_Mark'];
            $maxLimit2 = 30;
            ?><div class="container" id="container2"></div>       <?php }?>
    
    </div>
    <div class="rv-date">
        <?php
        $review2Date = $ReviewRow['Review2_Date'];
        if ($review2Date != NULL) {
          
           
               
                if (mysqli_num_rows($RvdocRes2) == 0) {
                    echo "No document submitted for Review 2";
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
        } 
    
        ?>
    </div>
</div>

    <?php
    ?>
    <div class="div-review3">
    <div class="rv-mark"><?php

         
        if ($ReviewRow['Review3_Mark'] == NULL) {
            $fillAmount3 =  0;
            $maxLimit3 = 40;
            ?><div class="container" id="container3"></div><?php
   
            if ($ReviewRow['Review3_Date'] == NULL) {
                echo 'Review 3 date not available';
            } else {
                echo 'Review 3 Date: ' . $ReviewRow['Review3_Date'];
            }
        } else {
            $fillAmount3 =  $ReviewRow['Review3_Mark'];
            $maxLimit3 = 40; 
            ?><div class="container" id="container3"></div>
            <?php        }
        ?>
    </div>
    <div class="rv-date">
        <?php
        $review3Date = $ReviewRow['Review3_Date'];
        if ($review3Date != NULL) {
           
               
                if (mysqli_num_rows($RvdocRes3) == 0) {
                    echo "No document submitted for Review 3";
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
        } 
    
        ?>
    </div>
</div>
    <?php
} else {
    echo "Review details not available for this project";
}
?>
</div>
<script>
    var totalMarks = 100; 
    var obtainedMarks = <?php echo $marks; ?>;  
    console.log(obtainedMarks);
    var progressValue = obtainedMarks / totalMarks;

var bar = new ProgressBar.Circle(containerp, {
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
    var fillAmount = <?php echo json_encode($fillAmount); ?>;
    
    var maxLimit = <?php echo json_encode($maxLimit); ?>;
    console.log(maxLimit);
    
    var bar = new ProgressBar.SemiCircle(container, {
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
            var value = fillAmount + '/' + 30;


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

    bar.animate(fillAmount / maxLimit);

    var fillAmount2 = <?php echo json_encode($fillAmount2); ?>;
    
    var maxLimit2 = <?php echo json_encode($maxLimit2); ?>;
    console.log(maxLimit);
    // ProgressBar.js initialization
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
        // Set default step function for all animate calls
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
    console.log(maxLimit);
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
            var value = fillAmount3 + '/' + 40;


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
