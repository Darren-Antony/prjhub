<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['emailId']);
    $fullName = mysqli_real_escape_string($conn, $_POST['FlName']);
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
        echo "Email already exists. Please choose a different email.";
        exit; 
    }

    if ($password !== $confirmPassword) {
        echo "Password and confirm password do not match.";
        exit; 
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insrtQry = "INSERT INTO user_credentials (Email, Password, user_Type) VALUES ('$email', '$hashedPassword', 'student')";

    if (mysqli_query($conn, $insrtQry)) {
      $user_id = mysqli_insert_id($conn);
      $sql = "INSERT INTO student (U_Id, Dept_No,Stu_Name,Dept_Name,Cur_Year,Section,Degree,Gender)
              VALUES ('$user_id','$departmentNumber','$fullName','$departmentName','$currentYear','$section', '$degree','$gender')";

      if (mysqli_query($conn, $sql)) {
        echo "Record inserted successfully";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

    }

    mysqli_close($conn);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/reg.css">
    <script src="/dependancies/jquery.js"></script>
    <script src="/script/student/registrationPge/reg-ajx.js"></script>
    
    <title>Student Registration</title>
</head>
<body>
   <div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    
    <div class="form" id="stdreg">
        <form action="#" method="post">
            <div class="form-title">
                <h1>Student Registration Form</h1>
            </div>
            <div class="form-cont">
                <label for="FlName">Full Name</label><br>
                <input type="text" name="FlName" id="FlName" required><br>
        
                <label for="emailId">Email Address</label><br>
                <input type="email" name="emailId" id="emailId" required><br>

                <label for="deptName">Department Name</label><br>
                <select name="deptName" id="deptName">
                   <option value="Computer Science">Computer Science</option>
                   <option value="Computer Application">Computer Application</option>  
                </select><br>
                <label for="deptNo">Department Number</label><br>
                <input type="text" name="deptNo" id="deptNo" required><br>

                <label for="curYear">Current Year</label><br>
                <select id="curYear" name="curYear" required>
                    <option value="1">I</option>
                    <option value="2">II</option>
                    <option value="3">III</option>
                </select><br>

                <label for="degree">Degree</label><br>
                <select id="degree" name="degree" required>
                    <option value="Bsc">Bsc</option>
                    <option value="Bca">Bca</option>
                    <option value="Msc">Msc</option>
                </select><br>

                <label for="section">Section</label><br>
                <select id="section" name="section" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select><br>

                <label for="gender">Gender</label><br>
                <select name="gender" id="gender">
                   <option value="Male">Male</option>
                   <option value="Female">Female</option>  
                </select><br>
                

                <label for="pwd">Password</label><br>
                <input type="password" name="pwd" id="pwd" required><br>

                <label for="cpwd">Confirm Password</label><br>
                <input type="password" name="cpwd" id="cpwd" required><br>
                
            </div> 
            <center>
                <input class="blue-btn" type="submit" value="Submit">
            </center>
</form>
    </div>
    
</body>
</html>
