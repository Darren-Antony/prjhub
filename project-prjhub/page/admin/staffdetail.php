<?php
  require_once('../config.php');
  session_start();
  $user_id = $_SESSION['user_id'];

  $gid= $_GET['Guide_Id'];
  $slQry2 = "SELECT * FROM guide WHERE Guide_Id ='$gid'";
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

  $prj = "SELECT * FROM student  WHERE Guide_Id = '$gid'";
  $prjres =mysqli_query($conn,$prj);
  if(!$prjres){
    die('Error: ' . mysqli_error($conn));
  }
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
    <style>
         
         table {
           width:100%;
            border-collapse: collapse;
            margin-top: 20px; 
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:#1C91F2;
            color:white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        .student-details{
            width:100%;
        }

    </style>
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
            <span class="heading">Staff Details</span>
                <table>
                    
                    <tr>
                        <td><label for="name">Name:</label></td>
                        <td><input type="text" name="name" id="FlName" value="<?php echo $sRow['G_Name'] ?>" disabled></td>
                    </tr>
                    <tr>
                        <td>
                        <label for="dob">Date of Birth:</label>
                        </td>
                        <td><input type="date" name="dob" id="dob" value="<?php echo $urow['D.O.B'] ?>" disabled></td>
                    </tr>
                    <tr>
                        <td><label for="StId">Staff Id:</label></td>
                        <td><input type="text" name="StId" id="StId" value="<?php echo $sRow['Guide_Id'] ?>" disabled></td>
                    </tr>
                    <tr>
                        <td><label for="Email">Email:</label></td>
                        <td><input type="email" name="Email" id="Email" value="<?php echo $urow['Email'] ?>" disabled></td>
                    </tr>
                </table>
                <button class="blue-btn" type="button" id="editBtn">Edit</button>
                <button class="blue-btn"type="button" id="cancelBtn" style="display:none;">Cancel</button>
                <button  type="submit" id="saveBtn" style="display:none;">Save</button>
            </form>
            <div id="validationSummary" style="margin-top: 20px;"></div>

        </div>
       
        <div class="student">
<?php
if (mysqli_num_rows($prjres) > 0) {
    ?>
    <span class="heading">Assigned Students</span>
    <?php
    echo '<div class="student-details">';
   
    echo'<table class="student-tbl">';
    echo "<thead>";
    echo "<tr>";
    echo "<th>Dept No</th>";
    echo "<th>Name</th>";
    echo "<th>Degree</th>";
    echo "</tr>";
    echo "</thead>";
    while ($stuRow = mysqli_fetch_assoc($prjres)) {
        
        
// Assuming $stuRow is an associative array containing student data
echo "<tr>";
echo "<td>" . $stuRow['Dept_No'] . "</td>";
echo "<td>" . $stuRow['Stu_Name'] . "</td>";
echo "<td>" . $stuRow['Degree'] . "</td>";
echo "</tr>";
}
}
?>
        </div>
        </div> 
</body>
<script>
   document.getElementById('editBtn').addEventListener('click', function() {
    // Enable form fields except for department name
    document.querySelectorAll('#studentForm input:not(#StId), #studentForm textarea').forEach(function(input) {
        input.disabled = false;
    });
    
    // Show save and cancel buttons, hide edit button
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    document.querySelectorAll('#studentForm input:not(#deptName), #studentForm textarea').forEach(function(input) {
        input.disabled = true;
    });
    
    
    document.getElementById('editBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
});
function validateForm(){
     var errors = [];
        var fullName = document.getElementById('FlName').value;
        var dob = document.getElementById('dob').value;
        var email = document.getElementById('Email').value;

        if (!/^[a-zA-Z\s]+$/.test(fullName)) {
            errors.push("Full Name should only consist of alphabets.");
        }

        var dobDate = new Date(dob);
        var currentDate = new Date();
        var minDobDate = new Date();
        minDobDate.setFullYear(currentDate.getFullYear() - 17);
        if (dob === "" || dobDate > currentDate || dobDate > minDobDate) {
            errors.push("Invalid Date of Birth.");
        }

        if (email === "") {
            errors.push("Email Address cannot be empty.");
        }

       
        var validationSummary = document.getElementById('validationSummary');
        if (errors.length > 0) {
            validationSummary.innerHTML = "<div class='error'><ul>";
            for (var i = 0; i < errors.length; i++) {
                validationSummary.innerHTML += "<li class='error'>" + errors[i] + "</li>";
            }
            validationSummary.innerHTML += "</ul></div>";
            document.getElementById('saveBtn').disabled = true; // Disable the button
            return false; 
        } else {
            validationSummary.innerHTML = ""; 
            document.getElementById('saveBtn').disabled = false; // Enable the button
            return true; 
        }
    }

    document.getElementById('saveBtn').addEventListener('click', function() {
        if (!validateForm()) {
            return false; // Prevent form submission if there are errors
        }
    });

    var inputs = document.querySelectorAll('input, select');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('change', function() {
            validateForm();
        });
    }
</script>
<?php
require_once('../config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    
    $email = $_POST["email"];
    
    // Update student table
    $updateStudentQuery = "UPDATE Guide SET G_Name='$name'";

    // Update user_credentials table
    $updateUserCredQuery = "UPDATE user_credentials SET Email='$email',`D.O.B`='$dob'WHERE U_Id= $StyUid";
 

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
