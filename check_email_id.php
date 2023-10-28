<?php
$db = new mysqli('localhost', 'root', '', 'dbms2023');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $stmt = $db->prepare('SELECT email FROM student_data WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $email_exists = false;
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $email_exists = true;
    }
    if ($email_exists) {
        echo 'exists';
    } else {
        echo 'not exists';
    }
}
?>