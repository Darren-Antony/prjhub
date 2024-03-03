<?php
require_once('../../page/config.php');
session_start();
$prjId = $_GET['prjId'];
$user_id = $_SESSION['suser_id'];


$query = "SELECT * FROM project WHERE Prj_Id = $prjId";
$result = mysqli_query($conn, $query);

if ($result) { 
    
    $project = mysqli_fetch_assoc($result);

} else {   
    
    echo "Error: " . mysqli_error($conn);
}

$Stu_No = mysqli_real_escape_string($conn, $project['Stu_Id']);

$getStuDetails = "SELECT * FROM student WHERE Dept_NO = '$Stu_No'";

$getStuDetailsRes = mysqli_query($conn, $getStuDetails);

if ($getStuDetailsRes) {

    $StuRow = mysqli_fetch_assoc($getStuDetailsRes);
} else {

    echo "Error: " . mysqli_error($conn);
}





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
    <script src="../../dependancies/sweetalert.js"></script>
    <title>Login</title>
</head>
<body>
   <div class="logo-cont">
    <div>
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
        <?php
if ($project['Prj_Status'] == 'In-Progress') {
    ?>
    <button onclick="viewtmsht(<?php echo $prjId ?>)">
        timesheet
    </button>
    <button onclick="viewMarks(<?php echo $prjId ?>)">
        marks
    </button>
    <?php
}
?>

    </div>
       
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
           
              if($project['Prj_Status'] == 'Pending-Approval') {
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
    
    <form id="markForm" method="post">
<?php

$getReviewDetails = "SELECT * FROM review WHERE Prj_Id = $prjId";

// Execute the query
$getReviewRes = mysqli_query($conn, $getReviewDetails);

if ($getReviewRes) {
    // Check if there are rows returned
    if (mysqli_num_rows($getReviewRes) > 0) {
                 
    }
}
if ($getReviewRes) {
    
    echo "<form method='post' action=''>"; 
    echo "<table border='1'>";
    echo "<tr><th>Review</th><th>Mark Review</th><th>Action</th></tr>";
$RvRow = mysqli_fetch_assoc($getReviewRes); 
        $rvId = $RvRow['Review_Id'];
        echo "<tr>";
        echo "<td>{$rvId}</td>";
        echo "<td>";
        if (isset($_POST['submit1'])) {
            $mark = intval($_POST['mark'][$rvId]); // Convert mark to integer
            // Update the marks in the database
            $updateQuery = "UPDATE review SET Review1_Mark = $mark WHERE Review_Id = $rvId";
            mysqli_query($conn, $updateQuery);
            echo "<input type='number' name='mark[{$rvId}]' value='$mark'>"; // Reflect the submitted mark value in the input field
        } else {
            $review1Mark = intval($RvRow['Review1_Mark']); // Convert existing mark to integer
            echo "<input type='number' name='mark[{$rvId}]' value='$review1Mark'>"; // Display existing mark value
        }
        echo "</td>";
        echo "<td><button type='submit' name='submit1'>Submit</button></td>"; // Moved the submit button into the form
        echo "</tr>";
   
    echo "</form>"; // Closing form tag

    echo "<form method='post' action=''>"; 
    echo "<table border='1'>";
    echo "<tr><th>Review</th><th>Mark Review</th><th>Action</th></tr>";

        echo "<tr>";
        echo "<td>{$rvId}</td>";
        echo "<td>";
        if (isset($_POST['submit2'])) {
            $mark = intval($_POST['mark'][$rvId]); // Convert mark to integer
            // Update the marks in the database
            $updateQuery = "UPDATE review SET Review2_Mark = $mark WHERE Review_Id = $rvId";
            mysqli_query($conn, $updateQuery);
            echo "<input type='number' name='mark[{$rvId}]' value='$mark'>"; // Reflect the submitted mark value in the input field
        } else {
            $review2Mark = intval($RvRow['Review2_Mark']); // Convert existing mark to integer
            echo "<input type='number' name='mark[{$rvId}]' value='$review2Mark'>"; // Display existing mark value
        }
        echo "</td>";
        echo "<td><button type='submit' name='submit2' >Submit</button></td>"; // Moved the submit button into the form
        echo "</tr>";
   
    echo "</form>"; // Closing form tag
    echo "<form method='post' action=''>"; 
    echo "<table border='1'>";
    echo "<tr><th>Review</th><th>Mark Review</th><th>Action</th></tr>";

        echo "<tr>";
        echo "<td>{$rvId}</td>";
        echo "<td>";
        if (isset($_POST['submit3'])) {
            $mark = intval($_POST['mark'][$rvId]); // Convert mark to integer
            // Update the marks in the database
            $updateQuery = "UPDATE review SET Review3_Mark = $mark WHERE Review_Id = $rvId";
            mysqli_query($conn, $updateQuery);
            echo "<input type='number' name='mark[{$rvId}]' value='$mark'>"; // Reflect the submitted mark value in the input field
        } else {
            $review3Mark = intval($RvRow['Review3_Mark']); // Convert existing mark to integer
            echo "<input type='number' name='mark[{$rvId}]' value='$review3Mark'>"; // Display existing mark value
        }
        echo "</td>";
        echo "<td><button type='submit' name='submit3'>Submit</button></td>"; // Moved the submit button into the form
        echo "</tr>";
   
    echo "</form>"; // Closing form tag
   
   
}

    echo "</table>";
   
  
?>

    </div>
    <div class="comment-div">
        
    <form id="commentForm" action="submit_comment.php" method="post">
        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
        <input name="prjid" id="prjid" value=<?php echo$prjId?>> <!-- Add the project ID as a hidden input field -->
        <input type="submit" value="Submit">
    </form>
</div>

<div class="comment">
<?php
// Assuming you have already connected to the database and started the session

// Fetch comments from the database based on the project ID
$getCommentsQuery = "SELECT * FROM COMMENT WHERE prj_Id = $prjId ORDER BY Date ASC, Time ASC";
$getCommentsResult = mysqli_query($conn, $getCommentsQuery);

// Display comments with appropriate formatting
while ($commentRow = mysqli_fetch_assoc($getCommentsResult)) {
    $senderId = $commentRow['Sender_Id'];
    $receiverId = $commentRow['Receiver_Id'];
    $commentText = $commentRow['Comment'];
    $commentDate = $commentRow['Date'];
    $commentTime = $commentRow['Time'];

    // Determine the format based on the sender and receiver IDs
    $commentFormat = "";
    if ($senderId == $user_id) {
        $commentFormat = "You";
    } elseif ($receiverId == $user_id) {
        $commentFormat = "Your student";
    } else {
        // Handle other cases if needed
    }

    // Output the comment with appropriate formatting
    echo "<div>{$commentFormat} ({$commentDate} {$commentTime}): {$commentText}</div>";
}
?>

</div>

    

<script>
   
    document.getElementById("commentForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get the comment and project ID from the form
    var comment = document.getElementById("comment").value;
    var prjid = document.getElementById("prjid").value;

    // Send the comment and project ID to submit_comment.php using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "submit_comment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from submit_comment.php
            var responseHTML = xhr.responseText;

            // Update the comment section with the new comment HTML
            var commentSection = document.querySelector(".comment");
            commentSection.innerHTML += responseHTML;
        }
    };
    xhr.send("comment=" + encodeURIComponent(comment) + "&prjid=" + encodeURIComponent(prjid));
});


        
function acceptProject() {
    // Check if the project status is already 'In-Progress'
    if ('<?php echo $project['Prj_Status']; ?>' === 'In-Progress') {
        console.log('Project is already in progress');
        return;
    }

    
        // If not refreshed, update the project status and set the flag
        $.ajax({
            url: 'update_status.php',
            method: 'POST',
            data: { project_id: <?php echo $project['Prj_Id']; ?>, status: 'In-Progress' },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: '',
                    text: 'Project Approved ',
                }).then(() => {
                    // Set the flag in localStorage to indicate the page has been refreshed
                    localStorage.setItem('pageRefreshed', 'true');
                    // Refresh the page
                    location.reload();
                });
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    
}


    function rejectProject() {
    Swal.fire({
        title: 'Enter Reason for Rejection',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            if (!value.trim()) {
                return 'Please enter a valid reason';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed the rejection with a reason
            const reason = result.value.trim();
            $.ajax({
                url: 'update_status.php',
                method: 'POST',
                data: { project_id: <?php echo $project['Prj_Id']; ?>, status: 'rejected', reason: reason },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: '',
                        text: 'Project Rejected',
                    }).then(() => {
                        // Refresh the page after rejection
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while rejecting the project',
                    });
                }
            });
        }
    });
}

</script>
</body>
</html>
