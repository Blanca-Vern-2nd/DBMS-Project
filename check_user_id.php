<?php
// Connect to database
$db = new mysqli('localhost', 'root', '', 'dbms2023');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

// Check if user ID is already in use
$userid = $_POST['userid'];
$stmt = $db->prepare('SELECT userid FROM student WHERE userid = ?');
$stmt->bind_param('s', $userid);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo 'User ID already in use';
} else {
    echo '';
}

// Close database connection
$stmt->close();
$db->close();
?>