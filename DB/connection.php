<?php
require ("constants.php");
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS);
if(!$conn) {
    die("Error!");
}
$conn->select_db(DB_NAME);


$dbSelect = mysqli_select_db($conn, DB_NAME);

if (!$dbSelect) {
    die("Error: Unable to select database. " . mysqli_error($conn));
}
?>
