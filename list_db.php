<?php
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Show databases
$result = $conn->query("SHOW DATABASES;");
echo "Available Databases:" . PHP_EOL;
echo "====================" . PHP_EOL;
while ($row = $result->fetch_assoc()) {
    echo $row['Database'] . PHP_EOL;
}

$conn->close();
?>
