
<?php
require_once('./config.php');
session_start();

// Determine user type based on session variables
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif(isset($_SESSION['Suserid'])) {
    $user_id = $_SESSION['Suserid'];
} elseif(isset($_SESSION['auserid'])) {
    $user_id = $_SESSION['auserid'];
} else {
    // Handle unauthorized access or redirect to login page
    exit("Unauthorized Access");
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/form.css">
    <script src="/dependancies/jquery.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>
     <script src="../dependancies/sweetalert.js"></script>
    <title>Change Password</title>
</head>
<body>
   <div class="logo-cont">
    <div class="logo">
    <img src="../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
        
    </div>
    
    <div class="form">
        
        <form action="#" method="post">
            <div class="form-title">
                <h1>Change Password</h1>
            </div>
            <div class="form-cont">
                <label for="curpwd">Current Password</label><br>
                <input type="password" name="curPwd" id="curPwd"><br>
                
                <label for="pwd">New Password</label><br>
                <input type="password" name="Pwd" id="Pwd"><br>

                <label for="cPwd">Confirm Password</label><br>
                <input type="password" name="cPwd" id="cPwd"><br>

            </div>
            <center><input class="blue-btn"type="submit" value="submit" name="submit" onclick=""></center>  
        </form>
       
    </div>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $curPwd = $_POST['curPwd'];
    $Pwd = $_POST['Pwd']; 
    $cPwd = $_POST['cPwd'];
    
    // Retrieve the current password from the database
    $retrievePwdQuery = "SELECT Password FROM user_credentials WHERE U_Id = '$user_id'";
    $result = mysqli_query($conn, $retrievePwdQuery);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['Password'];
        
        // Check if the current password matches the one stored in the database
        if(password_verify($curPwd, $hashedPassword)) {
            if($Pwd == $cPwd){
                $hashedNewPassword = password_hash($Pwd, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE user_credentials SET Password = '$hashedNewPassword' WHERE U_Id = '$user_id'";
                if(mysqli_query($conn, $updateQuery)) {
                    echo "<script>
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Password Changed',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        </script>";
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Password mismatch'
                        });
                    </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Current password is incorrect'
                    });
                </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No User Found'
                });
            </script>";
    }
}   
?>
    