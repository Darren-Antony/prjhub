<?php
require_once('../../page/config.php');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch search term from GET request
$searchTerm = $_GET['term'];

$sql = "SELECT * FROM guide WHERE Guide_Id LIKE '%" . $searchTerm . "%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="det_card"><a href="../../page/admin/staffdetail.php?Guide_Id=' . $row["Guide_Id"] . '">' . $row["Guide_Id"] . '</a> ' . $row["G_Name"] . '</p><br></div>';
     
    }
} else {
    echo "<p>No results found.</p>";
}

$conn->close();
?>
