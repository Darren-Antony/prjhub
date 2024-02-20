<?php
require_once('../../page/config.php');
$review_Id=$_GET['review_id'];
$review_No=$_GET['review_number'];
echo $review_Id;
$Rv_doc = "SELECT * FROM review_doc WHERE rv_Id = $review_Id and review_no=$review_No";
$Rv_Res = mysqli_query($conn,$Rv_doc);
$Rv_Row = mysqli_fetch_assoc($Rv_Res);
$Rv_Path = "../../uploads/".$Rv_Row['Doc_Path'];echo $Rv_Path;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="../../uploads/review_documents">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Evaluation Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .instructions {
            margin-bottom: 20px;
        }
        #goButton {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid #007bff;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        #goButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
''
    <h1>Review Evaluation Instructions</h1>

    <div class="instructions">
        <p><strong>Instructions:</strong></p>
        <ol>
            <li>Click on the "Go" button to start the assessment.</li>
            <li>The project review document will open in one tab.</li>
            <li>The evaluation page will open in another tab.</li>
            <li>Once you start evaluating the document, you cannot save the state changes.</li>
            <li>Complete the evaluation before submitting.</li>
            <li>After submission, marks will be awarded, and it cannot be reverted.</li>
            <li>Toggle between screens to view the review PDF and the mark allotment page.</li>
        </ol>
    </div>

    <button id="goButton" onclick="startEvaluation(<?php echo $review_Id?>)">Go</button>
    
    <script>
       function startEvaluation(reviewId) {
    // Get the review number from the URL parameters
    var urlParams = new URLSearchParams(window.location.search);
    var reviewNumber = urlParams.get('review_number');
    
    // Validate if review number is present
    if (!reviewNumber) {
        console.error('Review Number not found in URL parameters');
        return;
    }
    
    // Define the URL of the evaluation page
    var evaluationPageUrl = '';

    // Determine the evaluation page URL based on the review number
    switch (parseInt(reviewNumber)) {
        case 1:
            evaluationPageUrl = '../staff/Rv1markSheet.php?review_id=' + reviewId + '&review_number=' + reviewNumber;
            break;
        case 2:
            evaluationPageUrl = '../staff/Rv2markSheet2.php?review_id=' + reviewId + '&review_number=' + reviewNumber;
            break;
        case 3:
            evaluationPageUrl = '../staff/Rv3markSheet3.php?review_id=' + reviewId + '&review_number=' + reviewNumber;
            break;
        default:
            console.error('Invalid review number');
            return;
    }
    
    // Open the review document in one tab
    window.open('<?php echo $Rv_Path; ?>', '_blank');
    
    // Open the evaluation page in another tab
    window.open(evaluationPageUrl, '_blank');
}

    </script>
</body>
</html>
