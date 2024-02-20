<?php
session_start();


session_destroy();
echo"hi";
header("Location: ./index.html");
exit;
?>
