

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
    <title>Login</title>
</head>
<body>
   <div class="logo-cont">
        <img src="../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    
    <div class="form">
        
        <form action="#" method="post">
            <div class="form-title">
                <h1>Forget Password</h1>
            </div>
            <div class="form-cont">
                <label for="emailId">Email</label><br>
                <input type="text" name="emailId" id="emailId"><br>
               
                <label for="dob">Date Of Birth</label><br>
                <input type="date" name="dob" id="dob"><br>
                
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
include_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $Email = $_POST['emailId'];
    $Pwd = $_POST['Pwd']; 
    $cPwd = $_POST['cPwd'];
    $date = $_POST['dob'];
    
    $ChkQry = "SELECT * FROM user_credentials WHERE Email ='$Email' AND `D.O.B`='$date'"; 
    $result = mysqli_query($conn, $ChkQry);
    
    if(mysqli_num_rows($result) > 0){
        $U_Row = mysqli_fetch_assoc($result);
        $userrId = $U_Row['U_Id'];
        
        if($Pwd == $cPwd){
            $hashedPassword = password_hash($Pwd, PASSWORD_DEFAULT);
            $UpdateQuery = "UPDATE user_credentials 
                            SET Password = '$hashedPassword' WHERE U_Id = '$userrId'";
            if(mysqli_query($conn, $UpdateQuery)) {
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
                    text: 'No User Found'
                });
            </script>";
    }
}   
?>
    