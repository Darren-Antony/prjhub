<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/reg.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
    <title>Student Registration</title>
  
</head>
<body>
   <div class="logo-cont">
    <div class="logo">
    <img src="../../asset/image/Logo.png" alt="logo" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
        
    </div>
    
    <div class="form" id="stdreg">
        <form action="#" method="post" >
            <div class="form-title">
                <h1>Student Registration Form</h1>
            </div>
            <div class="form-cont">
            <table>
                <tr><span class="title">Personal Details </span></tr>
                <tr>
                    <td> <label for="FlName">Full Name</label></td>
                    <td> <input type="text" name="FlName" id="FlName" onchange="validateForm()"></td>
                    <td> <label for="emailId">Email Address</label></td>
                    <td> <input type="email" name="emailId" id="emailId" ></td>
                </tr>
                <tr>
                    <td><label for="dob">Date of Birth</label></td>
                    <td> <input type="date" name="dob" id="dob" onchange="validateForm()"></td>
                    <td><label for="gender" >Gender</label><br></td>
                    <td><select name="gender" id="gender" >
                   <option value="Male">Male</option>
                   <option value="Female">Female</option>  
                </select><br></td>
                </tr>
                
                <tr><td><span class="title">College Details </span></td></tr>
             
                    <tr>
                    <td><label for="deptName">Department Name</label></td>
                    <td> <select name="deptName" id="deptName" >
                          <option value="Computer Science">Computer Science</option>
                          <option value="Computer Application">Computer Application</option>  
                       </select>
                   </td>
                   <td> <label for="deptNo">Department Number</label></td>
                   <td><input type="text" name="deptNo" id="deptNo" onchange="validateForm()"><br></td>
                   </tr>
                   <tr>
                    <td><label for="curYear">Current Year</label></td>
                    <td><select id="curYear" name="curYear" >
                    <option value="1">I</option>
                    <option value="2">II</option>
                    <option value="3">III</option>
                </select></td>
                    <td> <label for="degree">Degree</label></td>
                    <td><select id="degree" name="degree" >
                    <option value="Bsc">Bsc</option>
                    <option value="Bca">Bca</option>
                    <option value="Msc">Msc</option>
                </select><br>
                    </td>
                   </tr>
                <tr>
                    <td> <label for="section">Section</label></td>
                    <td><select id="section" name="section" >
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select><br></td>
                    
                </tr>
                
                    <tr>
                        <td><label for="pwd">Password</label></td>
                    <td><input type="password" name="pwd" id="pwd" ></td>
                    
               <td> <label for="cpwd">Confirm Password</label></td>
                    <td> <input type="password" name="cpwd" id="cpwd" ></td>
                </tr>
                </table>
                </div>
            <center>
                <input class="blue-btn" type="submit" value="Submit" onclick="validateForm()">
            </center>
            <div id="validationSummary" style="margin-top: 20px;"></div>
    </div>
</form>

    
</body>
</html>

    <script>


    function validateForm() {
        var errors = [];
        var fullName = document.getElementById('FlName').value;
        var dob = document.getElementById('dob').value;
        var email = document.getElementById('emailId').value;
        var departmentNumber = document.getElementById('deptNo').value;

        // Validate Full Name
        if (!/^[a-zA-Z\s]+$/.test(fullName)) {
            errors.push("Full Name should only consist of alphabets.");
        }

        // Validate Date of Birth
        var dobDate = new Date(dob);
        var currentDate = new Date();
        var minDobDate = new Date();
        minDobDate.setFullYear(currentDate.getFullYear() - 17);
        if (dob === "" || dobDate > currentDate || dobDate > minDobDate) {
            errors.push("Invalid Date of Birth.");
        }

        // Validate Email Address
        if (email === "") {
            errors.push("Email Address cannot be empty.");
        }

        var departmentNumberPattern = /^\d{2}-[a-zA-Z]{3}-\d{3}$/;
        if (!departmentNumberPattern.test(departmentNumber.trim())) {
            errors.push("Invalid department number format. Correct format is: 21-ucs-108");
        }

        var validationSummary = document.getElementById('validationSummary');
        if (errors.length > 0) {
            validationSummary.innerHTML = "<div class='error'><ul>";
            for (var i = 0; i < errors.length; i++) {
                validationSummary.innerHTML += "<li>" + errors[i] + "</li>";
            }
            validationSummary.innerHTML += "</ul></div>";
            return false; 
        } else {
            validationSummary.innerHTML = ""; 
            return true; 
        }
    }


  var inputs = document.querySelectorAll('input, select');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('change', function() {
                validateForm();
            });
        }
</script>

<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['emailId']);
    $fullName = mysqli_real_escape_string($conn, $_POST['FlName']);
    $date = $_POST['dob'];
    $departmentName = mysqli_real_escape_string($conn, $_POST['deptName']);
    $departmentNumber = mysqli_real_escape_string($conn, $_POST['deptNo']);
    $currentYear = mysqli_real_escape_string($conn, $_POST['curYear']);
    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $password = mysqli_real_escape_string($conn, $_POST['pwd']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['cpwd']);
    
    $emailQuery = "SELECT * FROM user_credentials WHERE Email = '$email' and User_Type='Student'";
    $emailResult = mysqli_query($conn, $emailQuery);
    if (mysqli_num_rows($emailResult) > 0) {
        echo"<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Email already exists!',
          });</script>";        exit; 
    }

    if ($password !== $confirmPassword) {
        echo"<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Passwords do not match!',
          });</script>";
        exit; 
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insrtQry = "INSERT INTO user_credentials (Email, Password, User_Type, `D.O.B`) VALUES ('$email', '$hashedPassword', 'student', '$date')";

    if (mysqli_query($conn, $insrtQry)) {
      $user_id = mysqli_insert_id($conn);
      $sql = "INSERT INTO student (U_Id, Dept_No,Stu_Name,Dept_Name,Cur_Year,Section,Degree,Gender)
              VALUES ('$user_id','$departmentNumber','$fullName','$departmentName','$currentYear','$section', '$degree','$gender')";

if (mysqli_query($conn, $sql)) {
    echo '<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Your work has been saved",
        showConfirmButton: false,
        timer: 1500
      });
      
          </script>';
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

}

mysqli_close($conn);
} 
?>