<?php
    require_once('../config.php');
    session_start();
    $userId = $_SESSION['suser_id'];

    $getUserData = "SELECT * FROM user_credentials WHERE U_Id = $userId";
    $getUserDataRes = mysqli_query($conn, $getUserData);

    if (!$getUserDataRes) {
        die("Error retrieving user data: " . mysqli_error($conn));
    }

    $UserRow = mysqli_fetch_assoc($getUserDataRes);
    $UserType = $UserRow['User_Type'];

    $UserData = "SELECT * FROM Guide WHERE U_Id = $userId"; 
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
    <script src="../../script/global.js"></script>
    <link rel="stylesheet" href="../../style/dashboard/admindb.css">
    <title>Personal details</title>
</head>
<body>
    <div class="logo-cont">
        <div class="logo">
            <img src="../../asset/image/Logo.png" alt="" srcset="">
            <h1>Academic Project Tracker</h1>
        </div>
    </div>
    <div class="goback-cont">
        <button onclick="goBack()">&lt Go Back</button>
    </div>
    <div class="cont">
    <div class="per-det-cont">
    
    <form  id="studentForm" method="POST">
    <div class="heading">Student details</div> 
        <table >
        <tr>
            <td> <label for="name">Name:</label><br></td>
            <td><input type="text" name="name" id="name" value="<?php echo $UserDRow['G_Name'] ?>" disabled><br></td>
        </tr>
       <tr>
        <td><label for="dob">Date of Birth:</label><br></td>
        <td> <input type="date" name="dob" id="dob" value="<?php echo $UserRow['D.O.B'] ?>" disabled><br></td>
       </tr>
        <tr>
            <td> <label for="deptNo">Staff No:</label><br></td>
            <td><input type="text" name="deptno" id="deptNo" value="<?php echo $UserDRow['Guide_Id'] ?>" disabled><br></td>
        </tr>
      
       
            <td><label for="Gender">Gender:</label><br></td>
            <td><input type="text" name="Gender" id="Gender" value="<?php echo $UserDRow['Gender'] ?>" disabled><br></td>
        </tr>
        <tr>
            <td><label for="email">Email:</label><br></td>
            <td><input type="text" name="email" id="email" value="<?php echo $UserRow['Email'] ?>" disabled><br></td>
        </tr>

    </table>
</form>
    </div>
</div>
</body>
</html>
