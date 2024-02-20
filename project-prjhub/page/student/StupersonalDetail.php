<?php
require_once('../config.php');
session_start();
$userId = $_SESSION['user_id'];

// Get user credentials
$getUserData = "SELECT * FROM user_credentials WHERE U_Id = $userId";
$getUserDataRes = mysqli_query($conn, $getUserData);

if (!$getUserDataRes) {
    die("Error retrieving user data: " . mysqli_error($conn));
}

$UserRow = mysqli_fetch_assoc($getUserDataRes);
$UserType = $UserRow['User_Type'];

// Get student details
$UserData = "SELECT * FROM student WHERE U_Id = $userId"; 
$UserDataRes = mysqli_query($conn, $UserData);

if (!$UserDataRes) {
    die("Error retrieving user details: " . mysqli_error($conn));
}

$UserDRow = mysqli_fetch_assoc($UserDataRes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <script src="../script/global.js"></script>
    <title>Personal details</title>
</head>
<body>
    <div class="logo-cont">
        <div class="logo">
            <img src="../../asset/image/Logo.png" alt="" srcset="">
            <h1>Academic Project Tracker</h1>
        </div>
    </div>
    <div class="per-det-cont">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" value="<?php echo $UserDRow['Stu_Name'] ?>" disabled><br>
        <label for="dob">Date of Birth:</label><br>
        <input type="text" name="dob" id="dob" value="<?php echo $UserRow['D.O.B'] ?>" disabled><br>
        <label for="deptNo">Department No:</label><br>
        <input type="text" name="deptno" id="deptNo" value="<?php echo $UserDRow['Dept_No'] ?>" disabled><br>
        <label for="deptName">Department Name:</label><br>
        <input type="text" name="deptName" id="deptName" value="<?php echo $UserDRow['Dept_Name'] ?>" disabled><br>
        <label for="Cur_Year">Year:</label><br>
        <input type="text" name="Cur_Year" id="Cur_Year" value="<?php echo $UserDRow['Cur_Year'] ?>" disabled><br>
        <label for="Section">Section:</label><br>
        <input type="text" name="Section" id="Section" value="<?php echo $UserDRow['Section'] ?>" disabled><br>
        <label for="Degree">Degree:</label><br>
        <input type="text" name="Degree" id="Degree" value="<?php echo $UserDRow['Degree'] ?>" disabled><br>
        <label for="email">Email:</label><br>
        <input type="text" name="email" id="email" value="<?php echo $UserRow['Email'] ?>" disabled><br>
    </div>
</body>
</html>
