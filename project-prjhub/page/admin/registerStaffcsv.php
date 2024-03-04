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
    <form action="#" method="post" enctype="multipart/form-data" >
        <input type="file" name="csv_file" id="csv_file" accept=".csv">
        <input type="submit" name="submit" value="submit">
    </form>
</div>
<div id="validation-summary"></div>
</body>
</html>

<?php

require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))  {
    // Initialize array to store error messages and rows with errors
    $errorMessages = array();
    $rowsWithErrors = array();
    $validationSummary = "";

    // Check if file is uploaded successfully
    if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $fileName = $_FILES['csv_file']['name'];

        // Check the file extension
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (strtolower($fileExtension) !== 'csv') {
            $errorMessages[] = "Invalid File Upload Format!";
            // Stop further execution
            exit("<script>Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Invalid File Upload Format!'
            });</script>");
        }

        // Open the CSV file for reading
        $file = fopen($fileTmpPath, "r");

        // Skip the header row
        fgetcsv($file);

        $insertedRecords = 0; // Initialize counter for inserted records
        $existingEmails = array(); // Initialize array to store existing emails

        // Fetch existing emails from the database
        $result = $conn->query("SELECT Email FROM user_credentials");
        while ($row = $result->fetch_assoc()) {
            $existingEmails[] = $row['Email'];
        }

        while (($data = fgetcsv($file)) !== FALSE) {
            $col1 = $data[0];
            $col2 = $data[1];
            $col3 = $data[2];
            $dob = $data[3];
            $guideName = $data[5];

            // Validate Email format
            if (!filter_var($col1, FILTER_VALIDATE_EMAIL)) {
                $errorMessages[] = "Invalid Email format in row " . ($insertedRecords + 1);
                $rowsWithErrors[] = $data;
                continue; // Skip this row and move to the next one
            }

            // Check if email already exists
            if (in_array($col1, $existingEmails)) {
                $errorMessages[] = "Duplicate email '$col1' found in row " . ($insertedRecords + 1);
                $rowsWithErrors[] = $data;
                continue; // Skip this row and move to the next one
            }

            // Validate Date of Birth format and age greater than 17 years
            if (!strtotime($dob) || strtotime($dob) > strtotime('-17 years')) {
                $errorMessages[] = "Invalid Date of Birth or age less than 17 years in row " . ($insertedRecords + 1);
                $rowsWithErrors[] = $data;
                continue; // Skip this row and move to the next one
            }

            // Validate Guide name consists of only alphabets
            if (!ctype_alpha($guideName)) {
                $errorMessages[] = "Invalid Guide Name format in row " . ($insertedRecords + 1);
                $rowsWithErrors[] = $data;
                continue; // Skip this row and move to the next one
            }

            // Insert valid records into the database
            $sql = "INSERT INTO user_credentials (Email, Password, User_Type, `D.O.B`) VALUES ('$col1', '$col2', '$col3', '$dob')";
            if ($conn->query($sql) === TRUE) {
                $user_id = mysqli_insert_id($conn);
                $sql = "INSERT INTO guide (U_Id,Guide_Id,G_Name,No_of_Students,Gender) VALUES ($user_id,'$data[4]','$guideName',0,'$data[6]')";
                $res = mysqli_query($conn, $sql);
                $insertedRecords++; // Increment counter for inserted records
            } else {
                $errorMessages[] = "Database insertion error in row " . ($insertedRecords + 1) . ": " . $conn->error;
                $rowsWithErrors[] = $data;
            }
        }

        // Close the CSV file
        fclose($file);

        // Close the database connection
        $conn->close();

        // Display error messages for invalid rows
        if (!empty($errorMessages)) {
            $validationSummary .= "<h2>Validation Errors:</h2>";
            $validationSummary .= "<ul>";
            foreach ($errorMessages as $errorMessage) {
                // Escape single quotes in the error message
                $escapedErrorMessage = addslashes($errorMessage);
                $validationSummary .= "<li>$escapedErrorMessage</li>";
            }
            $validationSummary .= "</ul>";
        }
        
        // Display error message for rows that failed validation
        if (!empty($rowsWithErrors)) {
            $validationSummary .= "<h2>Rows with Validation Errors:</h2>";
            $validationSummary .= "<ul>";
            foreach ($rowsWithErrors as $rowData) {
                // Escape single quotes in the row data
                $escapedRowData = array_map('addslashes', $rowData);
                $validationSummary .= "<li>" . implode(",", $escapedRowData) . "</li>";
            }
            $validationSummary .= "</ul>";
        }

        // If there are no errors, display success message with inserted records count
        if (empty($errorMessages) && empty($rowsWithErrors)) {
            echo "<script>Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Inserted records: " . $insertedRecords . "'
            });</script>";
        } else {
            // Display validation summary in the HTML container
            echo "<script>document.getElementById('validation-summary').innerHTML = '$validationSummary';</script>";
        }
    } else {
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'File upload failed!'
        });</script>";
    }
}
?>

