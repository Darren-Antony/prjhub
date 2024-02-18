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
     <link rel="stylesheet" href="../../style/dashboard/timsheet.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
$chkCurrDate = "SELECT * FROM timesheet WHERE startDate = '$start_date' AND STATUS ='pending-approval' AND Proj_Id = $prjId ";
$res1 = mysqli_query($conn, $chkCurrDate);
echo'<div class="main-tms-cont">';
$row = mysqli_fetch_assoc($res1);
if (mysqli_num_rows($res1) > 0 && $row['STATUS'] != 'approved') {
    // Display the update form
    ?>
    <form id="timesheetForm" method="post" action="timesheetUpdate.php">
        <table border="1">
            <input type="hidden" name="prj_Id" value="<?php echo $prjId?>">
            <input type="hidden" name="start_date" value="<?php echo $start_date?>">
            <tr>
                <th>Day</th>
                <th>Activity</th>
            </tr>
            <?php
                $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            // Loop through each day
            foreach ($days as $day) {
                $activity_field_name = strtolower($day) . "Activity";
                $activity_value = $row[$activity_field_name]; // Get value from the database
                echo "<tr><td>$day</td><td><input type='text' name='$activity_field_name' value='$activity_value'></td></tr>";
            }
            ?>
        </table>
        <button type="submit">Approve</button>
    </form>
        </div>  
<?php } else {
    // Display message if timesheet is approved or doesn't exist
    echo "No timesheet data found for the current week or it has been approved.";
} ?>
</div>
<h2>Select Week Starting Date:</h2>
<input type="date" id="weekStartDatePicker">
<div id="timesheetDataDisplay"></div>
<script>
    const prjId =" <?php echo $prjId?>";
    console.log(prjId)
    // Function to fetch and display timesheet data for the selected date
    function displayTimesheetData(selectedDate, prjId) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const responseData = JSON.parse(this.responseText);
            if (responseData.exists) {
                const timesheetData = responseData.data;
                const table = document.createElement('table');
                table.border = '1';
                const tbody = document.createElement('tbody');

                // Custom keys for Monday to Saturday
                const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                // Loop through each day and display its corresponding activity
                for (let i = 0; i < days.length; i++) {
                    const day = days[i];
                    const activityKey = day.toLowerCase() + 'Activity';
                    const row = document.createElement('tr');
                    const cell1 = document.createElement('td');
                    const cell2 = document.createElement('td');
                    cell1.textContent = day;

                    // Display text content only for indices 2 to 8
                    if (i >= 0 && i <= 8) {
                        cell2.textContent = timesheetData[activityKey];
                    } else {
                        // For other indices, display a custom key
                        cell2.textContent = "Custom Key";
                    }
                    
                    row.appendChild(cell1);
                    row.appendChild(cell2);
                    tbody.appendChild(row);
                }

                table.appendChild(tbody);
                const displayContainer = document.getElementById('timesheetDataDisplay');
                displayContainer.innerHTML = '';
                displayContainer.appendChild(table);
            } else {
                document.getElementById('timesheetDataDisplay').innerHTML = 'No data found for the selected date.';
            }
        }
    };
    console.log('test3',prjId)

    xhr.open("GET", "../../Backend/student/StudentDashboard/fetch_timesheet_data.php?date=" + selectedDate + "&prjId=" + prjId.trim(), true);
    xhr.send();
}

function getStartOfWeek(date) {
        const day = date.getDay();
        const diff = date.getDate() - day + (day === 1 ? 0 : (day === 0 ? -6 : 1)); // Adjust when day is Sunday
        return new Date(date.setDate(diff));
    }

    window.addEventListener('DOMContentLoaded', function() {
        const datePicker = document.getElementById('weekStartDatePicker');
        const today = new Date();
        const startOfWeek = getStartOfWeek(today);
        datePicker.valueAsDate = startOfWeek;

        // Display timesheet data for the current date by default
        const formattedCurrentDate = today.toISOString().split('T')[0];
        displayTimesheetData(formattedCurrentDate, prjId);

        datePicker.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const formattedDate = selectedDate.toISOString().split('T')[0];
            displayTimesheetData(formattedDate, prjId);
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

        // Disable dates other than Mondays
        datePicker.addEventListener('input', function() {
            const selectedDate = new Date(this.value);
            if (selectedDate.getDay() !== 1) { // Monday is 1
                this.value = ''; // Clear non-Monday selections
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select a Monday to view the entire week\'s timesheet!',
                });
            }
        });
    });

</script>
  </body>
</html>
