<?php
  require_once('../config.php');
  session_start();
  $user_id = $_SESSION['user_id'];

  $dept = $_GET['dept_no'];
  $slQry2 = "SELECT * FROM student WHERE Dept_No ='$dept'";
  $slresult2 = mysqli_query($conn, $slQry2);
  if (!$slresult2) {
      die('Error: ' . mysqli_error($conn));
  }
    
  $sRow = mysqli_fetch_assoc($slresult2);

  $StyUid = $sRow['U_Id'];

  $UserCred = "SELECT * FROM user_credentials WHERE U_Id = $StyUid";
  $slresult3 = mysqli_query($conn,$UserCred);
  if (!$slresult3) {
    die('Error: ' . mysqli_error($conn));
}
  $urow = mysqli_fetch_assoc($slresult3);

  $prj = "SELECT * FROM project WHERE Stu_Id = '$dept' AND  Prj_Status ='In-Progress'";
  $prjres =mysqli_query($conn,$prj);
  if(!$prjres){
    die('Error: ' . mysqli_error($conn));
  }
  $prjRow = mysqli_fetch_assoc($prjres);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/admindb.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
    <title>Student details</title>
</head>
<body>
   <div class="logo-cont">
       <div class="logo">
            <img src="../../asset/image/Logo.png" alt="" srcset="">
            <h1>Academic Project Tracker</h1>
        </div>
    </div>
    <div class="cont">
        <div class="per-det-cont">
            <form  id="studentForm" method="POST">
                Personal Details
                <label for="name">Name:</label><br>
                <input type="text" name="name" id="name" value="<?php echo $sRow['Stu_Name'] ?>" disabled><br>
                <label for="dob">Date of Birth:</label><br>
                <input type="text" name="dob" id="dob" value="<?php echo $urow['D.O.B'] ?>" disabled><br>
                <label for="deptNo">Department No:</label><br>
                <input type="text" name="deptno" id="deptNo" value="<?php echo $sRow['Dept_No'] ?>" disabled><br>
                <label for="deptName">Department Name:</label><br>
                <input type="text" name="deptName" id="deptName" value="<?php echo $sRow['Dept_Name'] ?>" disabled><br>
                <label for="Cur_Year">Year:</label><br>
                <input type="text" name="Cur_Year" id="Cur_Year" value="<?php echo $sRow['Cur_Year'] ?>" disabled><br>
                <label for="Section">Section:</label><br>
                <input type="text" name="Section" id="Section" value="<?php echo $sRow['Section'] ?>" disabled><br>
                <label for="Degree">Degree:</label><br>
                <input type="text" name="Degree" id="Degree" value="<?php echo $sRow['Degree'] ?>" disabled><br>
                <label for="email">Email:</label><br>
                <input type="text" name="email" id="email" value="<?php echo  $urow['Email'] ?>" disabled><br>        
                <label for="Pname">Project Name</label><br>
                <input type="text" name="Pname" id="Pname" value ="<?php echo $prjRow['Prj_Name']?>" disabled><br>
                <label for="desc">Description</label><br>
                <textarea name="desc" id="desc" cols="30" rows="10" disabled>
                    <?php echo $prjRow['Prj_Desc']?>
                </textarea><br>
                <button type="button" id="editBtn">Edit</button>
                <button type="button" id="cancelBtn" style="display:none;">Cancel</button>
                <button type="submit" id="saveBtn" style="display:none;">Save</button>
            </form>
        </div>
    </div> 
</body>
<script>
   document.getElementById('editBtn').addEventListener('click', function() {
    // Enable form fields
    document.querySelectorAll('#studentForm input, #studentForm textarea').forEach(function(input) {
        input.disabled = false;
    });
    
    // Show save and cancel buttons, hide edit button
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    // Disable form fields
    document.querySelectorAll('#studentForm input, #studentForm textarea').forEach(function(input) {
        input.disabled = true;
    });
    
    // Hide save and cancel buttons, show edit button
    document.getElementById('editBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
});

</script>
<?php
require_once('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming the form fields are sanitized before processing
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $deptNo = $_POST["deptno"];
    $deptName = $_POST["deptName"];
    $curYear = $_POST["Cur_Year"];
    $section = $_POST["Section"];
    $degree = $_POST["Degree"];
    $email = $_POST["email"];
    $prj_Name = $_POST["Pname"];
    $Prj_Desc = $_POST['desc'];
    // Update student table
    $updateStudentQuery = "UPDATE student SET Stu_Name='$name', Dept_No='$deptNo', Dept_Name='$deptName', Cur_Year='$curYear', Section='$section', Degree='$degree' WHERE U_Id=
    $StyUid";

    // Update user_credentials table
    $updateUserCredQuery = "UPDATE user_credentials SET Email='$email',`D.O.B`='$dob'WHERE U_Id= $StyUid";
 
    $updatePrj ="UPDATE project SET Prj_Name = '$prj_Name',Prj_Desc='$Prj_Desc' WHERE Stu_Id = '$dept'";
    $updatePrjRes = mysqli_query($conn,$updatePrj);
    
    // Perform the updates
    $success = true;
    if (!mysqli_query($conn, $updateStudentQuery)) {
        $success = false;
        echo"<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error Updating',
          });</script>";      }
    if (!mysqli_query($conn, $updateUserCredQuery)) {
        $success = false;
        echo '<script>alert("Error updating user credentials data: ' . mysqli_error($conn) . '");</script>';
    }

    if ($success) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: '',
                text: 'Data Updated',
            }).then(() => {
                window.location.href = 'studentdetail.php?dept_no=$dept'; // Redirect to the same page with the department number
            });
        </script>";
        exit; // Stop further execution of the script
    }
}

// Fetch the updated data to display in the form
$slQry2 = "SELECT * FROM student WHERE U_Id =$user_id";
$slresult2 = mysqli_query($conn, $slQry2);
if (!$slresult2) {
    die('Error: ' . mysqli_error($conn));
}

$sRow = mysqli_fetch_assoc($slresult2);
?>

</html>
