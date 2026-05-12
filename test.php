<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli('localhost', 'u378913818_elearning', 'Akhmad90@', 'u378913818_elarning');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Success!";
?>
