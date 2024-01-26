<?php
require_once './config.php';

if (isset($_POST[""])) { // Checking if both email and password are set
    $Email = $_POST['emailId'];
    $Pwd = $_POST['pwd']; // You were missing a semicolon here

    try {
        $stmt1 = $conn->prepare("SELECT * FROM user_credentials WHERE Email = ?");
        $stmt1->bind_param('s', $Email);
        $stmt1->execute();

        $result = $stmt1->get_result(); // You named the statement $stmt1 but referred to $stmt here

        if ($result->num_rows === 0) {
            echo "User doesn't exist"; // You can't return from outside a function in PHP, so echo instead
        } else {
            $row = $result->fetch_assoc();
            $pwd = $row['Password'];

            if (password_verify($Pwd, $pwd)) { // Changed $data['pwd'] to $Pwd
                echo "Login successful"; // You might want to redirect or set session variables here instead of just echoing
            } else {
                echo "Invalid credentials";
            }
        }
    } catch (Exception $e) {
        echo "Error finding student: " . $e->getMessage(); // Echo instead of return
    }
} else {
    echo "Email and password are required fields"; // Handling case where email or password is not provided
}
?>
