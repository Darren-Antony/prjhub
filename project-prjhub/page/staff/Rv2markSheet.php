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
                <td>6</td>
                <td>0</td>
                <td><input type="number" name="Language_Tool_mark" min="0" max="6" onchange="updateTotalMarks()" tabindex="1"></td>
            </tr>
            <tr>
                <td>Introduction</td>
                <td>States the purpose, provides background information, and introduces key concepts.</td>
                <td>8</td>
                <td>0</td>
                <td><input type="number" name="Introduction_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="2"></td>
            </tr>
            <tr>
                <td>System Analysis</td>
                <td>Clearly defines the problem, analyzes the existing system, and proposes a new system that meets the requirements.</td>
                <td>8</td>
                <td>0</td>
                <td><input type="number" name="System_Analysis_mark" min="0" max="8" onchange="updateTotalMarks()" tabindex="3"></td>
            </tr>
            <!-- Other criteria rows go here -->
        </table>

        <p>Total Marks: <span id="totalMarks">0</span></p>

        <!-- Hidden input for review ID -->
        <input type="hidden" name="review_id" value="<?php echo $review_Id?>">
        <input type="hidden" name="review_No" value="<?php echo $review_No?>">
        <input type="hidden" name="total_marks" id="totalMarksInput" value="0">
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
