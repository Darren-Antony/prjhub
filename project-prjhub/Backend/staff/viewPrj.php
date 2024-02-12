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

// Close the database connection
mysqli_close($conn);
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
              echo "Project Name: " . $project['Prj_Desc'];
              if($project['Prj_Status'] == 'pending-approval') {
                  echo '
                      <button onclick="acceptProject()">Accept</button>
                      <button onclick="rejectProject()">Reject</button>
                  ';
              }else{
                
              }
             ?> 
                    </div>
    </div>
   
    <script>
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
