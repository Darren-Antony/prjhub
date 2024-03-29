
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <script src="/dependancies/jquery.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>

    <title>Admin Login</title>
</head>
<body>
   <div class="logo-cont">
   <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    </div>
    
    <div class="form">
        
        <form action="" method="post">
            <div class="form-title">
                <h1>Admin Login</h1>
            </div>
            <div class="form-cont">
                <label for="emailId"> Email ID</label><br>
                <input type="text" name="emailId" id="emailId"><br>
                
                <label for="pwd">Password</label><br>
                <input type="password" name="pwd" id="pwd"><br>
                <div class="frg-pwd"><a href="../forgetPassword.php"><p>forgot Password</p></a></div>
            </div>
            <center><input class="blue-btn"type="submit" value="submit" name="submit"></center>  
        </form>
       
    </div>
</body>
</html>
<?php
include_once('../config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Checking if both email and password are set
    $Email = $_POST['emailId'];
    $Pwd = $_POST['pwd']; // Added a semicolon here

    try {
        $lgnQry = "SELECT * FROM user_credentials WHERE Email ='$Email' and User_Type='Admin'" ; // Corrected the variable usage in the query
        $result = mysqli_query($conn, $lgnQry);

        if (!$result) {
            throw new Exception(mysqli_error($conn)); 
        }

        $result = mysqli_fetch_assoc($result); 
        if (!$result) {
            echo "User doesn't exist"; 
        } else {
            $pwd = $result['Password']; 
        
            if (password_verify($Pwd, $pwd)) {
                // Start a session
                session_start();
        
                $_SESSION['user_id'] = $result['U_Id'];
                $_SESSION['email'] = $result['Email'];
        ?>
        <?php
                header("Location: adminDashboard.php");
                exit(); 
            } else {
                echo "Invalid credentials"; // Notify invalid credentials
            }
        }
        
    } catch (Exception $e) {
        echo "Error finding student: " . $e->getMessage(); // Echo instead of return
    }
} else {
}
?>
