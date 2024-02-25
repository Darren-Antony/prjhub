<?php
require_once('../config.php');
$review_Id=$_GET['review_id'];
$review_No=$_GET['review_number'];
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
                <td>Abstarct</td>
                <td>Clearly and concisely summarizes the key points of the document.</td>
                <td><b>1 Marks</b><br>(Briefly mentions key points, but lacks clarity or conciseness)</td>
                <td><b>4 Marks</b><br>Concisely and accurately summarizes the document's essence, engaging the reader.</td>
                <td><input type="number" name="abstract_mark" min="0" max="10" onchange="updateTotalMarks()" tabindex="1"></td>
            </tr>
            <tr>
                 <td>Introduction</td>
                 <td>States the purpose, provides background information, and introduces key concepts.</td>
                 <td><b>2 Marks</b><br>Briefly states the purpose, but lacks background or key concepts.</td>
                <td><b>5 Marks</b><br>Clearly states the purpose, provides relevant background, and introduces key concepts with depth.</td>
                <td><input type="number" name="Introduction_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="2"></td>
            </tr>
            <tr>
                <td>System Analysis</td>
                <td>Clearly defines the problem, analyzes the existing system, and proposes a new system that meets the requirements.</td>
                <td><b>4 Marks</b><br>(Vaguely defines the problem, lacks analysis, and proposes a basic solution with unclear requirements.)</td>
                <td><b>7 Marks</b><br>(Clearly defines the problem, thoroughly analyzes the existing system, and proposes a well-defined, effective solution that meets all requirements.)</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>System Design</td>
                <td>Describes the architecture of the system, including hardware, software, and database design.</td>
                <td><b>4 Marks</b><br>Basic overview of system architecture, but lacks details or clarity.</td>
                <td><b>7 Marks</b><br>(Detailed and well-explained system architecture with clear descriptions of hardware, software, and database design choices.
                               )</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Project Description	</td>
                <td>Clearly describes the implementation of the project, including the GUI design, testing procedures, and expected outcomes</td>
                <td><b>4 Marks</b><br>Brief overview of implementation, with unclear descriptions of GUI, testing, or outcomes.</td>
                <td><b>7 Marks</b><br>(Detailed description of implementation, including GUI design rationale, thorough testing procedures, and well-defined expected outcomes.)</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Additional Features	</td>
                <td>Identifies and implements additional features that enhance the project's functionality (e.g., security, scalability, maintainability).</td>
                <td><b>0 Marks</b><br>No additional features identified or implemented.</td>
                <td><b>2 Marks</b><br>Identifies and implements several valuable features that significantly enhance the project's functionality and user experience.</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Documentation	</td>
                <td>Clear, concise, and well-organized documentation (e.g., user manual, technical documentation).</td>
                <td><b>1 Marks</b><br> Minimal documentation, poorly organized, or unclear instructions..</td>
                <td><b>3 Marks</b><br>Comprehensive, well-organized documentation with clear instructions, examples, and relevant information for users and developers.</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <tr>
                <td>Presentation	</td>
                <td>Compelling and informative presentation of the project (if applicable).</td>
                <td><b>0 Marks</b><br>No presentation, or poorly delivered presentation lacking clarity or engagement.</td>
                <td><b>3 Marks</b><br>Engaging and informative presentation that clearly conveys the project's key points, objectives, and impact.</td>
                <td><input type="number" name="ProSys_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
        </table>

        <p>Total Marks: <span id="totalMarks">0</span></p>

        <!-- Hidden input for review ID -->
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
        document.getElementById('totalMarksInput').value = totalMarks; // Update hidden input value
    }
</script>


</body>
</html>
