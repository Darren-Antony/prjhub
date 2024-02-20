<?php
   require_once('../../page/config.php');
   session_start();
   $prjId = $_GET['prjId'];

   $user_id = $_SESSION['user_id'];
 
   $slQry2 = "SELECT * FROM student WHERE U_Id = $user_id";
   $slresult2 = mysqli_query($conn, $slQry2) or die(mysqli_error($conn));
   
   $sRow = mysqli_fetch_assoc($slresult2);
   $Stu_Id = $sRow['Dept_No'];
   $query = "SELECT * FROM project WHERE Prj_Id = $prjId";
   $result = mysqli_query($conn, $query);
   

   if ($result) {
       $project = mysqli_fetch_assoc($result);
    
   
   } else {
       echo "Error: " . mysqli_error($conn);
   }

   $Stu_No = mysqli_real_escape_string($conn, $project['Stu_Id']);

   $getStuDetails = "SELECT * FROM student WHERE Dept_NO = '$Stu_No'";

   $getStuDetailsRes = mysqli_query($conn, $getStuDetails);

   if ($getStuDetailsRes) {
       $StuRow = mysqli_fetch_assoc($getStuDetailsRes);
   } else {
       echo "Error: " . mysqli_error($conn);
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/student/dashboard/dashboard.js"></script>
    <link rel="stylesheet" href="../../style/dashboard/timsheet.css">
    <title>Login</title>
</head>
<body>
   <div class="logo-cont">
    <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
      
   
    </div>
    <div class="goback-cont">
        <button onclick="goBack()">&lt Go Back</button>
    </div>
    <?php

if (date('D') != 'Mon') {
    $start_date = date('Y-m-d', strtotime('last Monday'));
} else {
    $start_date = date('Y-m-d');
}

$chkCurrDate = "SELECT * FROM timesheet WHERE startDate = '$start_date' AND Proj_Id = $prjId";
$res1 = mysqli_query($conn, $chkCurrDate);
$row = mysqli_fetch_assoc($res1);
echo'<div class="main-tms-cont">';
   echo'<div class="inner-tms-cont">';
      if (mysqli_num_rows($res1) == 0) {
    ?>
    <form id="timesheetForm" method="post" action="../../Backend/student/StudentDashboard/timesheetInsert.php">
        <table >
            <input type="hidden" name="prj_Id" value="<?php echo $prjId?>">
            <input type="hidden" name="start_date" value="<?php echo $start_date?>">
            <tr>
                <th>Day</th>
                <th>Activity</th>
            </tr>
            <?php
            // Define days of the week
            $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            // Loop through each day
            foreach ($days as $day) {
                echo "<tr><td>$day</td><td><input type='text' name='" . strtolower($day) . "_activity' required></td></tr>";
            }
            ?>
        </table>
        <button type="submit">Submit</button>
    </form>
    <?php } elseif (mysqli_num_rows($res1) > 0 && $row['STATUS'] != 'approved') { ?>
    <form id="timesheetForm" method="post" action="../../Backend/student/StudentDashboard/timesheetUpdate.php">
        <table >
            <input type="hidden" name="prj_Id" value="<?php echo $prjId?>">
            <input type="hidden" name="start_date" value="<?php echo $start_date?>">
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
                echo "<tr><td>$day</td><td><input type='text' name='$activity_field_name' value='$activity_value' required></td></tr>";
            }
            ?>
        </table>
        <button type="submit" class="blue-btn">Update</button>
    </form>
    </div>
    </div>     
        
<?php } else {
    echo "This weeks timesheet has been approved</br>";
} ?>
<div class="date-p">
<h2>Select Week Starting Date:</h2>
<input type="date" id="weekStartDatePicker">
<div id="timesheetDataDisplay"></div>
</div>

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
                const thead = document.createElement('thead'); // Create thead element
                const tbody = document.createElement('tbody');

                // Create headers for "Days" and "Activities"
                const daysHeader = document.createElement('th');
                daysHeader.textContent = 'Days';
                const activitiesHeader = document.createElement('th');
                activitiesHeader.textContent = 'Activities';
                const headerRow = document.createElement('tr');
                headerRow.appendChild(daysHeader);
                headerRow.appendChild(activitiesHeader);
                thead.appendChild(headerRow);
                table.appendChild(thead);

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

    xhr.open("GET", "../../Backend/student/StudentDashboard/fetch_timesheet_data.php?date=" + selectedDate + "&prjId=" + prjId.trim(), true);
    xhr.send();
}



// Function to get the starting date of the current week (Monday)
function getStartOfWeek(date) {
    const day = date.getDay();
    const diff = date.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is Sunday
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
        console.log('test2',prjId)
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
        
 // Function to validate the input year
function validateYear(year) {
    // Check if the input is not null or empty
    if (year.trim() === '') {
        return false;
    }
    // Check if the input is a valid year (e.g., between 1900 and the current year)
    const currentYear = new Date().getFullYear();
    const inputYear = parseInt(year);
    if (isNaN(inputYear) || inputYear < 1900 || inputYear > currentYear) {
        return false;
    }
    return true;
}

// Function to submit the form
function submitForm() {
    // Get the input value
    const yearInput = document.getElementById('yearInput').value;

    // Validate the input
    if (!validateYear(yearInput)) {
        // If the input is invalid, display a SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Invalid Year',
            text: 'Please enter a valid year between 1900 and the current year.',
        });
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

</script>
  </body>
</html>
