<?php
$servername = "localhost";
$username = "u369121555_inv_master";
$password = "Admin@123";
// Create connection
$conn = new mysqli($servername, $username, $password, 'u369121555_inv_master');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$value = rand(0000,9999);


$sql = "INSERT INTO cron (id)
VALUES ($value)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}




$conn->close();
?>