<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
    <script src="../../script/student/dashboard/dashboard.js"></script>
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/student/dashboard/ajax/selectingGuideajax.js"></script>
    <script src="../../script/student/dashboard/ajax/submitProjectAjax.js"></script>
    <script src="../../script/global.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
    <script>
          function validateForm() {
            var email = document.getElementById("emailId").value;
            var fullName = document.getElementById("FlName").value;
            var dob = document.getElementById("dob").value;
            var password = document.getElementById("pwd").value;
            var confirmPassword = document.getElementById("cpwd").value;

            // Email validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid email address!',
                    text: 'Please enter a valid email address.'
                });
                return false;
            }

            // Full name validation
            if (fullName.trim() === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing full name!',
                    text: 'Please enter your full name.'
                });
                return false;
            }

            // Date of Birth validation
            if (dob.trim() === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing date of birth!',
                    text: 'Please enter your date of birth.'
                });
                return false;
            }

            

            // Password validation
            if (password.trim() === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing password!',
                    text: 'Please enter a password.'
                });
                return false;
            }

            // Confirm Password validation
            if (confirmPassword.trim() === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing confirmation password!',
                    text: 'Please confirm your password.'
                });
                return false;
            }

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords do not match!',
                    text: 'Please make sure your passwords match.'
                });
                return false;
            }

            return true; // Form is valid
        }
    </script>
</head>
<body>
<div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="logo" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    
    <div class="form" id="stdreg">
        <form action="#" method="post" onsubmit="return validateForm()">
            <div class="form-title">
                <h1>Admin Registration Form</h1>
            </div>
            <div class="form-cont">
                <label for="FlName">Full Name</label><br>
                <input type="text" name="FlName" id="FlName" ><br>
        
                <label for="emailId">Email Address</label><br>
                <input type="email" name="emailId" id="emailId" ><br>
                 
                <label for="dob">Date of Birth</label><br>
                <input type="date" name="dob" id="dob"><br>

              

                <label for="gender" >Gender</label><br>
                <select name="gender" id="gender" >
                   <option value="Male">Male</option>
                   <option value="Female">Female</option>  
                </select><br>
                

                <label for="pwd">Password</label><br>
                <input type="password" name="pwd" id="pwd" ><br>

                <label for="cpwd">Confirm Password</label><br>
                <input type="password" name="cpwd" id="cpwd" ><br>
                
            </div> 
            <center>
                <input class="blue-btn" type="submit" value="Submit">
            </center>
</form>
    </div>
    
</body>

</html>
<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['emailId']);
    $fullName = mysqli_real_escape_string($conn, $_POST['FlName']);
    $date = $_POST['dob'];
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $password = mysqli_real_escape_string($conn, $_POST['pwd']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['cpwd']);
    
    $emailQuery = "SELECT * FROM user_credentials WHERE Email = '$email' and User_Type='Admin'";
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
    $insrtQry = "INSERT INTO user_credentials (Email, Password, User_Type, `D.O.B`) VALUES ('$email', '$hashedPassword', 'Admin';, '$date')";

    if (mysqli_query($conn, $insrtQry)) {
      $user_id = mysqli_insert_id($conn);
      $sql = "INSERT INTO Admin (U_Id, AD_Name)
              VALUES ('$user_id','$fullName')";

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