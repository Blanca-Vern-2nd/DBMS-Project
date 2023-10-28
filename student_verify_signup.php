<?php
require 'vendor/autoload.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    print_r($_SESSION);
    $userid = $_SESSION['userid'];
    $conn = new mysqli('localhost', 'root', '', 'dbms2023');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
    $sql = "SELECT otp FROM student_otp WHERE userid= '$userid'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_otp = $row['otp'];
    
        if (!password_verify($_POST['otp'], $hashed_otp)) {
            $errors[] = 'Invalid OTP';
        }
    } else {
        $errors[] = 'Id not found';
    }
    
    $conn->close();
    if (empty($errors)) {
        $userid = $_SESSION['userid'];
        $password = $_SESSION['password'];
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];
        $class = $_SESSION['class'];
    
        $conn = new mysqli('localhost', 'root', '', 'dbms2023');
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
    
        // Insert user data into student table
        $sql = "INSERT INTO student (userid, password) VALUES ('$userid', '$password')";
        $conn->query($sql);
    
        // Insert user data into student_data table
        $sql = "INSERT INTO student_data (userid, name, email, class) VALUES ('$userid', '$name', '$email', '$class')";
        $conn->query($sql);
    
        // Delete OTP tuple from database
        $sql = "DELETE FROM student_otp WHERE userid='$userid'";
        $conn->query($sql);
    
        $conn->close();
    
        // Redirect to login page
        header('Location: student_login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Signup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Verify Signup</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="otp">OTP:</label>
                                <input type="text" name="otp" id="otp" class="form-control" required>
                            </div>
                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                            <button type="submit" class="btn btn-primary btn-block">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>