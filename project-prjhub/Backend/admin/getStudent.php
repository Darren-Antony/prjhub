<?php
require_once('../../page/config.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch search term from GET request
$searchTerm = $_GET['term'];

// Prepare SQL query
$sql = "SELECT * FROM student WHERE Dept_No LIKE '%" . $searchTerm . "%'";

// Execute query
$result = $conn->query($sql);

// Check if any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="det_card"><a href="../../page/admin/studentdetail.php?dept_no=' . $row["Dept_No"] . '">' . $row["Dept_No"] . '</a> ' . $row["Stu_Name"] . '</p><br></div>';
     
    }
} else {
    echo "<p>No results found.</p>";
}

// Close connection
$conn->close();
?>
