<?php
require_once('../../page/config.php');
session_start();
$prjId = $_GET['prjId'];
$user_id = $_SESSION['user_id'];

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
    <script src="../../script/student/dashboard/dashboard.js"></script>

    <title>Login</title>
</head>
<body>
   <div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
        <div class="btn-nav-cont">
            <button onclick="timesheetPage(<?php echo $prjId?>)">
                timesheet
            </button>
            <button>
                marks
            </button>
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
  </body>
</html>
