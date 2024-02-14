<?php
require_once('../../page/config.php');
session_start();
$prjId = $_GET['prjId'];
$user_id = $_SESSION['user_id'];

// Query the database to get the project details based on the project ID
// Assuming you have a database connection established
$query = "SELECT * FROM project WHERE Prj_Id = $prjId";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Fetch the project details
    $project = mysqli_fetch_assoc($result);
    
    // Display the project name
   
} else {
    // Handle errors if any
    echo "Error: " . mysqli_error($conn);
}

$Stu_No = mysqli_real_escape_string($conn, $project['Stu_Id']);

// Construct the SQL query with the escaped value
$getStuDetails = "SELECT * FROM student WHERE Dept_NO = '$Stu_No'";

// Execute the query
$getStuDetailsRes = mysqli_query($conn, $getStuDetails);

// Check if the query was successful
if ($getStuDetailsRes) {
    // Fetch the row
    $StuRow = mysqli_fetch_assoc($getStuDetailsRes);
    // Use $StuRow as needed
} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}


// Construct the SQL query with the escaped value
echo "<script>const prjId = " . json_encode($prjId) . ";</script>";




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/prjviewpage.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>

    <title>Login</title>
</head>
<body>
   <div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
        <div class="btn-nav-cont">
            <button>
                timesheet
            </button>
            <button>
                marks
            </button>
        </div>
    </div>
    <?php

// Check the current day
if (date('D') != 'Mon') {
    // Take the last Monday
    $start_date = date('Y-m-d', strtotime('last Monday'));
} else {
    $start_date = date('Y-m-d');
}
echo "The start date of the current week is $start_date";
$chkCurrDate = "SELECT * FROM timesheet WHERE startDate = '$start_date' AND STATUS ='pending-approval' AND Proj_Id = '$prjId' ";
$res1 = mysqli_query($conn, $chkCurrDate);
if (mysqli_num_rows($res1) == 0) {
    ?>
    <form id="timesheetForm" method="post" action="../../Backend/student/StudentDashboard/timesheetInsert.php">
        <table border="1">
        <input type="text" name="prj_Id" value="<?php echo $prjId?>">

            <input type="text" name="start_date" value="<?php echo $start_date?>">
            <tr>
                <th>Day</th>
                <th>Activity</th>
            </tr>
            <?php
            // Define days of the week
            $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            // Loop through each day
            foreach ($days as $day) {
                echo "<tr><td>$day</td><td><input type='text' name='" . strtolower($day) . "_activity'></td></tr>";
            }
            ?>
        </table>
        <button type="submit">Submit</button>
    </form>
    <?php
} else {// Existing records, handle display or other actions
    // Fetch data from the database and populate input fields
    $row = mysqli_fetch_assoc($res1);
    ?>
     <form id="timesheetForm" method="post" action="../../Backend/student/StudentDashboard/timesheetUpdate.php">
        <table border="1">
        <input type="text" name="prj_Id" value="<?php echo $prjId?>">
            <input type="text" name="start_date" value="<?php echo $start_date?>">
            <tr>
                <th>Day</th>
                <th>Activity</th>
            </tr>
            <?php
            // Define days of the week
            $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            // Loop through each day
            foreach ($days as $day) {
                $activity_field_name = strtolower($day) . "Activity";
                $activity_value = $row[$activity_field_name]; // Get value from the database
                echo "<tr><td>$day</td><td><input type='text' name='$activity_field_name' value='$activity_value'></td></tr>";
            }
            ?>
        </table>
        <button type="submit">Submit</button>
    </form>
<?php } ?>
<h2>Select Week Starting Date:</h2>
<input type="date" id="weekStartDatePicker">
<div id="timesheetDataDisplay"></div>
<script>
    // Function to fetch and display timesheet data for the selected date
// Function to fetch and display timesheet data for the selected date
// Function to fetch and display timesheet data for the selected date
function displayTimesheetData(selectedDate, projectId) {
    // AJAX request to fetch data for the selected date
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Handle response here
            const responseData = JSON.parse(this.responseText);
            if (responseData.exists) {
                // Display timesheet data in a table format
                const timesheetData = responseData.data;
                const table = document.createElement('table');
                table.border = '1';
                const tbody = document.createElement('tbody');
                const keys = Object.keys(timesheetData);
                keys.forEach(key => {
                    const row = document.createElement('tr');
                    const cell1 = document.createElement('td');
                    const cell2 = document.createElement('td');
                    cell1.textContent = key;
                    cell2.textContent = timesheetData[key];
                    row.appendChild(cell1);
                    row.appendChild(cell2);
                    tbody.appendChild(row);
                });
                table.appendChild(tbody);
                // Clear previous data and append the new table
                const displayContainer = document.getElementById('timesheetDataDisplay');
                displayContainer.innerHTML = '';
                displayContainer.appendChild(table);
            } else {
                // If no data found for the selected date, clear the display
                document.getElementById('timesheetDataDisplay').innerHTML = '';
            }
        }
    };
    xhr.open("GET", "../../Backend/student/StudentDashboard/fetch_timesheet_data.php?date=" + selectedDate + "&prjId=" + projectId, true);
    xhr.send();
}

// Get the project ID from the URL parameter
const projectId = <?php echo $prjId ?>;
const formattedCurrentDate = today.toISOString().split('T')[0];
displayTimesheetData(formattedCurrentDate, projectId);

window.addEventListener('DOMContentLoaded', function() {
    const datePicker = document.getElementById('weekStartDatePicker');
    const today = new Date();
    const startOfWeek = getStartOfWeek(today);
    datePicker.valueAsDate = startOfWeek;

    // Display timesheet data for the current date by default
    const formattedCurrentDate = today.toISOString().split('T')[0];
    displayTimesheetData(formattedCurrentDate);

    datePicker.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const startOfWeek = getStartOfWeek(selectedDate);
        this.valueAsDate = startOfWeek;

        // Display timesheet data for the selected date
        const formattedDate = selectedDate.toISOString().split('T')[0]; // Format date as YYYY-MM-DD
        displayTimesheetData(formattedDate);
    });

    // Rest of your code...
});

    // Function to get the starting date of the current week
    function getStartOfWeek(date) {
        const day = date.getDay();
        const diff = date.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is Sunday
        return new Date(date.setDate(diff));
    }

    window.addEventListener('DOMContentLoaded', function() {
        const datePicker = document.getElementById('weekStartDatePicker');
        // Get the current date
const today = new Date();

        const startOfWeek = getStartOfWeek(today);
        datePicker.valueAsDate = startOfWeek;

        datePicker.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const startOfWeek = getStartOfWeek(selectedDate);
            this.valueAsDate = startOfWeek;

            // Upon date change, check if the selected date is present in the database
            const formattedDate = selectedDate.toISOString().split('T')[0]; // Format date as YYYY-MM-DD
            // AJAX request to check if the date exists in the database
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Handle response here, display related rows if date exists
                    const response = JSON.parse(this.responseText);
                    if (response.exists) {
                        // Display related rows
                        console.log("Related rows exist for the selected date.");
                    } else {
                        console.log("No related rows found for the selected date.");
                    }
                }
            };
            xhr.open("GET", "check_date.php?date=" + formattedDate, true);
           xhr.send();
          
        });

        datePicker.addEventListener('keydown', function(e) {
            // Prevent manual input
            e.preventDefault();
        });

        datePicker.addEventListener('click', function(e) {
            // Prevent manual input via calendar
            this.blur();
        });

        datePicker.addEventListener('focus', function() {
            // Prevent manual input via calendar
            this.blur();
        });
    });
</script>
  </body>
</html>