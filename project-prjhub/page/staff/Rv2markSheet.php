<?php
require_once('../config.php');
$review_Id=$_GET['review_id'];
$review_No=$_GET['review_number'];
$getPrjId = "SELECT Prj_id FROM review WHERE Review_Id=$review_Id";
$getPrjIdRes = mysqli_query($conn,$getPrjId) or die(mysqli_error($getPrjIdRes));
$getPrjIdResRow = mysqli_fetch_assoc($getPrjIdRes);
$prjId = $getPrjIdResRow['Prj_id'];

$getStuid = "SELECT Stu_Id,Prj_Name FROM project WHERE Prj_Id = $prjId";
$getStuidRes =mysqli_query($conn,$getStuid) or die(mysqli_error($getStuidRes));
$getStuidRow = mysqli_fetch_assoc($getStuidRes);
$stuId = $getStuidRow['Stu_Id'];
$prj_Name = $getStuidRow['Prj_Name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Evaluation Rubric</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="number"] {
            width: 60px;
            padding: 5px;
        }
        #submitButton {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid #007bff;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        #submitButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Project Evaluation Rubric</h2>

    <form id="evaluationForm" action="../../Backend/staff/submit_evaluation.php" method="post">
        <table>
            <tr>
                <th>Criteria</th>
                <th>Description</th>
                <th>Maximum Mark</th>
                <th>Minimum Mark (Criteria Not Met)</th>
                <th>Mark</th>
            </tr>
            <tr>
                <td> Language / Tool</td>
                <td>Evaluates the appropriateness and effectiveness of the chosen programming language or development tool.</td>
                <td><b>1 Mark</b><br>(Unsuitable language/tool, hindering project development.)</td>
                <td><b>2 Mark</b><br>(Well-suited language/tool, effectively meeting project requirements.)</td>
                <td><input type="number" name="Language_Tool_mark" min="0" max="6" onchange="updateTotalMarks()" tabindex="1"></td>
            </tr>
            <tr>
                <td>Pseudo code</td>
                <td>States the purpose, provides background information, and introduces key concepts.</td>
                <td><b>1 Mark</b><br>(Unclear pseudo code, lacking necessary information and clarity.)</td>
                <td><b>2-3 Marks</b><br>(Clear pseudo code, effectively communicates purpose and concepts.)</td>
                <td><input type="number" name="Introduction_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="2"></td>
            </tr>
            <tr>
                <td>Unit Testing</td>
                <td>Clearly defines the problem, analyzes the existing system, and proposes a new system that meets the requirements.</td>
                <td><b>1-2 Marks</b><br> (Incomplete or inaccurate unit tests, failing to adequately cover functionality.)</td>
                <td><b>3-5 Marks</b><br> (Comprehensive unit tests, accurately verifying functionality of each component.)
</td>
                <td><input type="number" name="System_Analysis_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Integration Testing</td>
                <td>Clearly defines the problem, analyzes the existing system, and proposes a new system that meets the requirements.</td>
                <td><b>1-2 Marks</b><br> (Incomplete or poorly executed integration tests, failing to identify issues.)</td>
                <td><b>3-5 Marks</b> <br> (Comprehensive integration tests, ensuring seamless communication and functionality.)</td>
                <td><input type="number" name="System_Analysis_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Acceptance Testing</td>
                <td>Clearly defines the problem, analyzes the existing system, and proposes a new system that meets the requirements.</td>
                <td><b>1-2 Marks</b><br> (Incomplete or insufficient acceptance tests, failing to validate requirements.)</td>
                <td><b>3-5 Marks</b> <br> (Thorough acceptance tests, accurately simulating real-world scenarios.)</td>
                <td><input type="number" name="System_Analysis_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Validation Testing</td>
                <td>Clearly defines the problem, analyzes the existing system, and proposes a new system that meets the requirements.</td>
                <td><b>1-2 Marks</b> <br>( Lack of defined or inadequate validation tests.)</td>
                <td> <b>3-4 Marks</b> <br> (Effective validation tests, ensuring system functionality.)</td>
                <td><input type="number" name="System_Analysis_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Documentation</td>
                <td>Clear, concise, and well-organized documentation (e.g., user manual, technical documentation).</td>
                <td><b>1-2 Marks</b><br> (Minimal documentation, poorly organized, or unclear instructions..)</td>
                <td><b>3 Marks</b><br>(Comprehensive, well-organized documentation with clear instructions, examples, and relevant information for users and developers.)</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Presentation</td>
                <td>Compelling and informative presentation of the project (if applicable).</td>
                <td><b>1-2 Marks</b><br>(No presentation, or poorly delivered presentation lacking clarity or engagement.)</td>
                <td><b>3 Marks</b><br>(Engaging and informative presentation that clearly conveys the project's key points, objectives, and impact.)</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
        </table>

        <p>Total Marks: <span id="totalMarks">0</span></p>

        <input type="text" name="review_id" value="<?php echo $review_Id?>">
        <input type="text" name="review_No" value="<?php echo $review_No?>">
        <input type="text" name="total_marks" id="totalMarksInput" value="0">
        <textarea name="feedback" id="" cols="30" rows="10" required></textarea>
        <button type="submit" id="submitButton" >Submit</button>
    </form>

    <script>
        function updateTotalMarks() {
            var totalMarks = 0;
            var markInputs = document.querySelectorAll('input[type="number"]');
            markInputs.forEach(function(input) {
                totalMarks += parseInt(input.value) || 0;
            });
            document.getElementById('totalMarks').textContent = totalMarks;
            document.getElementById('totalMarksInput').value = totalMarks; 
        }
    </script>
</body>
</html>
