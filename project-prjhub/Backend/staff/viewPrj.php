<?php
require_once('../../page/config.php');

$prjId = $_GET['prjId'];

// Query the database to get the project details based on the project ID
// Assuming you have a database connection established
$query = "SELECT * FROM project WHERE Prj_Id = $prjId";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Fetch the project details
    $project = mysqli_fetch_assoc($result);
    
    // Display the project name
   
} else {
    // Handle errors if any
    echo "Error: " . mysqli_error($conn);
}

$Stu_No = mysqli_real_escape_string($conn, $project['Stu_Id']);

// Construct the SQL query with the escaped value
$getStuDetails = "SELECT * FROM student WHERE Dept_NO = '$Stu_No'";

// Execute the query
$getStuDetailsRes = mysqli_query($conn, $getStuDetails);

// Check if the query was successful
if ($getStuDetailsRes) {
    // Fetch the row
    $StuRow = mysqli_fetch_assoc($getStuDetailsRes);
    // Use $StuRow as needed
} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}


// Construct the SQL query with the escaped value





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/prjviewpage.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>

    <title>Login</title>
</head>
<body>
   <div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    <div class="prj-cont">
        <div class="prj-cont-left">
            <div class="prj-cont-left-top">
            <?php
              echo "Project Name: " . $project['Prj_Name'];
             ?>
            </div>
             <div class="prj-cont-left-bottom">
             <?php
              echo "Project Name: " . $project['Prj_Desc'];
             ?> 
             </div>
        </div>
        <div class="prj-cont-right">
       
             <?php
           
              if($project['Prj_Status'] == 'pending-approval') {
                  echo '
                      <button onclick="acceptProject()">Accept</button>
                      <button onclick="rejectProject()">Reject</button>
                  ';
              }else{
                 echo '<h2>Project Details</h2><br>';
                 echo'<h3> Submitted on:'.$project['Date_of_Submission'].'</h3><br>';
                 echo'<h3> Status:'.$project['Prj_Status'].'</h3><br>';
                 echo'<h3> Status:'.$StuRow['Stu_Name'].'</h3><br>';
                }
             ?> 
                    </div>
    </div>
    <di<h1>Events and Marks</h1>
    <form id="markForm" method="post">
<?php

$getReviewDetails = "SELECT * FROM review WHERE Prj_Id = '$prjId'";

// Execute the query
$getReviewRes = mysqli_query($conn, $getReviewDetails);

// Check if the query was successful
if ($getReviewRes) {
    // Check if there are rows returned
    if (mysqli_num_rows($getReviewRes) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Review</th><th>Mark Review</th><th>Action</th></tr>";
        while ($RvRow = mysqli_fetch_assoc($getReviewRes)) {
            echo "<tr>";
            echo "<td>{$RvRow['Review1_Mark']}</td>";
            echo "<td>";
            if (isset($_POST['submit'])) {
                $mark = $_POST['mark'][$RvRow['Review_Id']];
                // Update the marks in the database
                $updateQuery = "UPDATE review SET Review1_Mark = '$mark' WHERE Review_Id = '{$RvRow['Review_Id']}'";
                mysqli_query($conn, $updateQuery);
                echo "<input type='number' name='mark[{$RvRow['Review_Id']}]' value='$mark'>";
            } else {
                echo "<input type='number' name='mark[{$RvRow['Review_Id']}]' value='{$RvRow['Review1_Mark']}'>";
            }
            echo "</td>";
            echo "<td><button name='submit'>Submit</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No review found.";
    }
} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}
?>
</form>
    </div>
   
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("markForm");
    var submitButtons = form.getElementsByClassName("submitBtn");
    for (var i = 0; i < submitButtons.length; i++) {
        submitButtons[i].addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission
            var row = this.closest("tr");
            var markInput = row.querySelector("input[type='number']");
            var markValue = markInput.value;
            var formData = new FormData();
            formData.append('mark[' + markInput.name.split('[')[1], markValue + ']');
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            }).then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            }).then(function(data) {
                console.log(data);
            }).catch(function(error) {
                console.error('There was a problem with the fetch operation:', error);
            });
        });
    }
});
    function acceptProject() {
        // Perform AJAX request to update project status to accepted
        // Assuming jQuery for AJAX ease
        $.ajax({
            url: 'update_status.php',
            method: 'POST',
            data: { project_id: <?php echo $project['Prj_Id']; ?>, status: 'In-Progress' },
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    }

    function rejectProject() {
        var reason = prompt("Please enter a valid reason for rejecting the project:");
        if (reason != null && reason.trim() != "") {
            console.log(reason);
            $.ajax({
                url: 'update_status.php',
                method: 'POST',
                data: { project_id: <?php echo $project['Prj_Id']; ?>, status: 'rejected', reason: reason },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        } else {
            alert("Please provide a valid reason for rejecting the project.");
        }
    }
</script>
</body>
</html>
