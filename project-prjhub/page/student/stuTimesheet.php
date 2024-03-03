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
    <script src="../../script/global.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
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
            $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

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
            $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            foreach ($days as $day) {
                $activity_field_name = strtolower($day) . "Activity";
                $activity_value = $row[$activity_field_name]; 
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
    function displayTimesheetData(selectedDate, prjId) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const responseData = JSON.parse(this.responseText);
            if (responseData.exists) {
                const timesheetData = responseData.data;
                const table = document.createElement('table');
                const thead = document.createElement('thead'); 
                const tbody = document.createElement('tbody');

                const daysHeader = document.createElement('th');
                daysHeader.textContent = 'Days';
                const activitiesHeader = document.createElement('th');
                activitiesHeader.textContent = 'Activities';
                const headerRow = document.createElement('tr');
                headerRow.appendChild(daysHeader);
                headerRow.appendChild(activitiesHeader);
                thead.appendChild(headerRow);
                table.appendChild(thead);

                const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                for (let i = 0; i < days.length; i++) {
                    const day = days[i];
                    const activityKey = day.toLowerCase() + 'Activity';
                    const row = document.createElement('tr');
                    const cell1 = document.createElement('td');
                    const cell2 = document.createElement('td');
                    cell1.textContent = day;

                    if (i >= 0 && i <= 8) {
                        cell2.textContent = timesheetData[activityKey];
                    } else {
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



function getStartOfWeek(date) {
        const day = date.getDay();
        const diff = date.getDate() - day + (day === 1 ? 0 : (day === 0 ? -6 : 1)); 
        return new Date(date.setDate(diff));
    }

    window.addEventListener('DOMContentLoaded', function() {
        const datePicker = document.getElementById('weekStartDatePicker');
        const today = new Date();
        const startOfWeek = getStartOfWeek(today);
        datePicker.valueAsDate = startOfWeek;

        const formattedCurrentDate = today.toISOString().split('T')[0];
        displayTimesheetData(formattedCurrentDate, prjId);

        datePicker.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const formattedDate = selectedDate.toISOString().split('T')[0];
            displayTimesheetData(formattedDate, prjId);
        });

        datePicker.addEventListener('keydown', function(e) {
            e.preventDefault();
        });

        datePicker.addEventListener('click', function(e) {
            this.blur();
        });

        datePicker.addEventListener('focus', function() {
            this.blur();
        });

        datePicker.addEventListener('input', function() {
            const selectedDate = new Date(this.value);
            if (selectedDate.getDay() !== 1) {
                this.value = ''; 
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
