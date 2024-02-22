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
        #container {
            margin: 20px;
            width: 200px;
            height: 100px;
        }
        #fillText {
            font-family: 'Raleway', Helvetica, sans-serif;
            font-size: 2rem;
            text-align: center;
            margin-top: 10px;
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
        <button onclick="goBack()">&lt Go Back</button>
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
            
            // Assuming you have PHP logic to determine the fill amount, let's say it's stored in a variable called $fillAmount
            $fillAmount =  $ReviewRow['Review1_Mark'];
            $maxLimit = 30; // Maximum limit
            ?><div id="container"></div>
            <?php
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
    ?>
<div class="div-review2">
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review2_Mark'] == NULL) {
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
        $review2Date = $ReviewRow['Review2_Date'];
        if ($review2Date != NULL) {
            $allowSubmissionDate = date("Y-m-d", strtotime('-1 day', strtotime($review2Date)));
            if ($currentDate >= $allowSubmissionDate) {
               
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
        } else {
            echo "Review 2 date not available";
        }
    }
        ?>
    </div>
</div>

    <?php
    ?>
    <div class="div-review3">
    <div class="rv-mark">
        <?php
        if ($ReviewRow['Review3_Mark'] == NULL) {
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
        $review3Date = $ReviewRow['Review3_Date'];
        if ($review3Date != NULL) {
            $allowSubmissionDate = date("Y-m-d", strtotime('-1 day', strtotime($review3Date)));
            if ($currentDate >= $allowSubmissionDate) {
               
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
        } else {
            echo "Review 3 date not available";
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

<script>
    // PHP Variables
    var fillAmount = <?php echo json_encode($fillAmount); ?>;
    
    var maxLimit = <?php echo json_encode($maxLimit); ?>;
    console.log(maxLimit);
    // ProgressBar.js initialization
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
        // Set default step function for all animate calls
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

    // Animate the progress bar
    bar.animate(fillAmount / maxLimit);
</script>


</body>
</html>
