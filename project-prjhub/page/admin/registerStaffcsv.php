<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/dashboard/admindb.css">
    <script src="../../dependancies/jquery.js"></script>
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
<div class="example-cont">
    <h1>General Instructions</h1>
    <p>Save Your file as csv have the columns in the following order</p>
    <img src="../../asset/image/excsv.png" alt="" srcset="">
</div>
<div class="form-cont">
    <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <input type="file" name="csv_file" id="csv_file" accept=".csv">
        <input type="submit" name="submit" value="submit">
    </form>
</div>
</body>
</html>

<?php

require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))  {
    // Check if file is uploaded successfully
    if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];

        // Check the file extension
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (strtolower($fileExtension) !== 'csv') {
         
            echo"<script>Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Invalid File Upload Fornat!',
              });</script>";         
            exit; // Stop further execution
        }

        // Check connection
        if ($conn->connect_error) {
            echo"<script>Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'something went wrong',
              });</script>"; 
            exit; // Stop further execution
        }

        // Open the CSV file for reading
        $file = fopen($fileTmpPath, "r");

        // Skip the header row
        fgetcsv($file);

        $insertedRecords = 0; // Initialize counter for inserted records

        while (($data = fgetcsv($file)) !== FALSE) {
            $col1 = $data[0];
            $col2 = $data[1];
            $col3 = $data[2];

            // Convert date format from "29-08-2003" to "2003-08-29"
            $dob = date('Y-m-d', strtotime($data[3]));

            $sql = "INSERT INTO user_credentials (Email, Password, User_Type, `D.O.B`) VALUES ('$col1', '$col2', '$col3', '$dob')";

            if ($conn->query($sql) === TRUE) {
                $user_id = mysqli_insert_id($conn);
                $sql = "INSERT INTO guide (U_Id,Guide_Id,G_Name,No_of_Students,Gender) VALUES ($user_id,'$data[4]','$data[5]',0,'$data[6]')";
                $res = mysqli_query($conn, $sql);
                $insertedRecords++; // Increment counter for inserted records
            } else {
                echo"<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'something went wrong',
                  });</script>"; 
            }
        }

        // Close the CSV file
        fclose($file);

        // Close the database connection
        $conn->close();

      
        echo "<script>";
        echo "Swal.fire({
                icon: 'Success',
                title: 'Oops...',
                text: 'Inserted records: " . $insertedRecords . "'
            });";
        echo "</script>";
        
    } else {
        echo "<script>";
        echo "Swal.fire({
                icon: 'success',
                title: 'Oops...',
                text: 'Inserted records: " . $insertedRecords . "'
            });";
        echo "</script>";
    }
}
?>
