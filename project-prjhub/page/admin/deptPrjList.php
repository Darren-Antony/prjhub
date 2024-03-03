<?php

require_once('../config.php');
session_start();
$user_id = $_SESSION['user_id'];
$Dept_Name = $_GET['dept'];


$PrjList = "SELECT project.Stu_Id , Prj_Name FROM project 
            INNER JOIN student ON project.Stu_Id = student.Dept_No
            WHERE project.Prj_Status = 'In-Progress' AND student.Degree = '$Dept_Name'";

$PrjListRes = mysqli_query($conn, $PrjList);

if (!$PrjListRes) {
    echo mysqli_error($conn); 
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/admindb.css">
    <script src="../../dependancies/xlsx.js"></script>
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
    <style>
        /* Table styles */
        table {
           width:100%;
            border-collapse: collapse;
            margin-top: 20px; /* Add margin-top */
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:#1C91F2;
            color:white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        .blue-btn{
            padding:10px;
            height:60px;
            float:right;
        }
        
    </style>
    <title>Student details</title>
</head>
<body>
   <div class="logo-cont">
       <div class="logo">
            <img src="../../asset/image/Logo.png" alt="" srcset="">
            <h1>Academic Project Tracker</h1>
       </div>
   </div>
   <div class="table-cont">
        <div class="inner-table">
        <?php
        if(mysqli_num_rows($PrjListRes)>0){
            ?>
            <table>
                <tr>
                    <th>S.I.No</th>
                    <th>Department No</th>
                    <th>Project Title</th>
                </tr>
            <?php
            $i = 1;
            while ($Prj_row = mysqli_fetch_assoc($PrjListRes)) {
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td>" . $Prj_row['Stu_Id'] . "</td>";
                echo "<td>" . $Prj_row['Prj_Name'] . "</td>";
                echo "</tr>";
                $i++;
            }
            ?>
            </table>
        <?php
        } else {
            echo "<p>No Projects Found</p>";
        }
        ?>
        </div>
        <button class="blue-btn" onclick="exportToExcel()">Export to Excel</button>
    </div>
    <script>
    function exportToExcel() {
        // Get the table element
        var table = document.querySelector('table');

        // Convert table to Excel workbook
        var wb = XLSX.utils.table_to_book(table);

        // Save the workbook as an Excel file
        XLSX.writeFile(wb, 'table_data.xlsx');
    }
    </script>
</body>
</html>
