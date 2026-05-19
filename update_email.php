<?php
$conn = new mysqli('localhost', 'root', '', 'lms_ska7u');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Update email_verified_at to NOW()
$email = 'guru_dummy@contoh.com';
$updateQuery = "UPDATE users SET email_verified_at = NOW() WHERE email = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param('s', $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "✓ Updated successfully. Affected rows: " . $stmt->affected_rows . PHP_EOL . PHP_EOL;
} else {
    echo "✗ No rows updated or user not found." . PHP_EOL;
}

// Select and display the updated record
$selectQuery = "SELECT id, name, email, email_verified_at FROM users WHERE email = ?";
$stmt = $conn->prepare($selectQuery);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Updated Record:" . PHP_EOL;
    echo "===============" . PHP_EOL;
    while ($row = $result->fetch_assoc()) {
        echo 'ID: ' . $row['id'] . PHP_EOL;
        echo 'Name: ' . $row['name'] . PHP_EOL;
        echo 'Email: ' . $row['email'] . PHP_EOL;
        echo 'Email Verified At: ' . $row['email_verified_at'] . PHP_EOL;
    }
} else {
    echo 'No record found with that email.' . PHP_EOL;
}

$conn->close();
?>
