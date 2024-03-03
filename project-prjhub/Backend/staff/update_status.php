<?php
require_once('../../page/config.php');

// Check if the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["project_id"]) && isset($_POST["status"])) {
    session_start();
    
    $project_id = filter_var($_POST["project_id"], FILTER_SANITIZE_NUMBER_INT);
    $status = $_POST["status"];
    $user_id = $_SESSION['suser_id'];
    
    $getstu = "SELECT student.U_Id 
    FROM student 
    JOIN project ON student.Dept_No = project.Stu_Id
    WHERE project.Prj_Id = $project_id"; 
    $getStuRes = mysqli_query($conn, $getstu);
    if ($getStuRes) { 
        $getStuRow = mysqli_fetch_assoc($getStuRes);
        $Stu_uid = $getStuRow['U_Id'];
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        if ($status == 'In-Progress') {

            $sql = "UPDATE project SET Prj_Status = ? WHERE Prj_Id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) { 
                $stmt->bind_param("si", $status, $project_id);
                if ($stmt->execute()) {
                    echo "Project status updated successfully to '$status'!";
                    $insRvRec = "INSERT INTO review (Prj_Id) VALUES ($project_id)";
                    $exqry = mysqli_query($conn, $insRvRec);
                    if ($exqry) {
                        $message = "Your project has been approved";
                        $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$Stu_uid,'$message','$currentDate','$currentTime')";
                        $notiRes = mysqli_query($conn, $notif);
                    } else {
                        echo "Insertion failed: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error updating project status: " . $stmt->error;
                }
            } else {
                echo "Error creating prepared statement: " . $conn->error;
            }
        } elseif ($status == 'rejected' && isset($_POST["reason"])) {
            $reason = $_POST["reason"];
            $sql = "UPDATE project SET Prj_Status = 'rejected', rejection_reason = ? WHERE Prj_Id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) { // Added check if the prepared statement was successfully created
                $stmt->bind_param("si", $reason, $project_id);
                if ($stmt->execute()) {
                    $message = "Your project was rejected for the $reason";
                    $notif = "INSERT INTO notification (Sender_Id,Receiver_Id,Message,Date,Time) VALUES ($user_id,$Stu_uid,'$message','$currentDate','$currentTime')";
                    $notiRes = mysqli_query($conn, $notif);
                    echo "Project status updated successfully to 'Rejected' with reason: '$reason'!";
                } else {
                    echo "Error updating project status: " . $stmt->error;
                }
            } else {
                echo "Error creating prepared statement: " . $conn->error;
            }
        } else {
            echo "Error: Invalid status or missing reason for rejection!";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // If the request method is not POST or if required parameters are missing
    http_response_code(400); // Bad request
    echo "Error: Invalid request!";
}

// Close connection
$conn->close();
?>
