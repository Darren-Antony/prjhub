
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>

    <title>Login</title>
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
                <h1>Guide Login</h1>
            </div>
            <div class="form-cont">
                <label for="emailId"> Email ID</label><br>
                <input type="text" name="emailId" id="emailId"><br>
                
                <label for="pwd">Password</label><br>
                <input type="password" name="pwd" id="pwd"><br>
                <div class="frg-pwd"><p>forgot Password</p></div>
            </div>
            <center><input class="blue-btn"type="submit" value="submit" name="submit" onclick=""></center>  
        </form>
       
    </div>
</body>
</html>
<?php
include_once('../config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $Email = $_POST['emailId'];
    $Pwd = $_POST['pwd']; 

    try {
        $lgnQry = "SELECT * FROM user_credentials WHERE Email ='$Email' and User_Type='Guide'"; 
        $result = mysqli_query($conn, $lgnQry);

        if (!$result) {
            throw new Exception(mysqli_error($conn)); 
        }

        $result = mysqli_fetch_assoc($result); 
        if (!$result) {
            
        } else {
            $pwd = $result['Password']; 
        
            if (password_verify($Pwd, $pwd)) {
                
                session_start();
        
                
                $_SESSION['suser_id'] = $result['U_Id'];
                $_SESSION['email'] = $result['Email'];
        
               
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '',
                    text: 'Login Sucessful',
                }).then(() => {
                    window.location.href = './staffdashboard.php'; // Redirect to the same page with the department number
                });
            </script>";
                exit();
            } else {
                echo "Invalid credentials"; 
            }
        }
        
    } catch (Exception $e) {
        echo "Error finding student: " . $e->getMessage(); 
    }
} else {
}
?>
