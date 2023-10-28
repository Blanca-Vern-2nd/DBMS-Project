<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['userid'] = $_POST['userid'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['class'] = $_POST['class'];
}
?>
<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $otp = rand(100000, 999999);
    $hashed_otp = password_hash($otp, PASSWORD_DEFAULT);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set this to DEBUG_SERVER for troubleshooting
        $mail->isSMTP();
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'blancavern3@gmail.com';
        $mail->Password = 'nnpixmqiluurveci'; // Replace with your Yahoo Mail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('lucky615b@gmail.com', 'Blanca from Gyanganga');
        $mail->addAddress($email);
        $mail->Subject = "OTP Verification for Student Signup";
        $mail->Body = "Your OTP is: $otp";

        $mail->send();
    } catch (Exception $e) {
        $errors[] = 'Error sending OTP';
    }

    if (empty($errors)) {
        // Insert OTP into database
        $conn = new mysqli('localhost', 'root', '', 'dbms2023');
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $sql = "INSERT INTO student_otp (userid, otp) VALUES ('$userid', '$hashed_otp')";

        if ($conn->query($sql) === TRUE) {
            header('Location: student_verify_signup.php');
            exit;
        } else {
            $errors[] = 'Error inserting data into database';
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Signup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Student Signup</h3>
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
                                <label for="userid">User ID:</label>
                                <div class="input-group">
                                    <input type="text" name="userid" id="userid" class="form-control" required>
                                </div>
                                <div id="userid-error" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Confirm Password:</label>
                                <div class="input-group">
                                    <input type="text" name="confirm-password" id="confirm-password" class="form-control" required>
                                </div>
                                <div id="password-error" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <div class="input-group">
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div id="email-error" class="invalid-feedback"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="class">Class:</label>
                                <select name="class" id="class" class="form-control" required>
                                    <option value="">Select class</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" id="signup-button" name="signup-button">Signup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper-base.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        $('#userid').on('input', checkUserId);
        $('#email').on('input', checkEmail);
        $('#password').on('input', checkPassword);
        $('#confirm-password').on('input', checkPassword);
        $('#signup-button').on('click', function(event) {
    event.preventDefault();
    isPasswordweak();
    $('#signup-form').submit();
});
    });

    function checkUserId() {
    var userid = $('#userid').val();
    console.log(userid);
    if (userid == '') {
        $('#userid-error').text('User ID cannot be empty');
        $('#userid').addClass('is-invalid');
        $('#signup-button').prop('disabled', true);
        return;
    }
    $.ajax({
        url: 'check_userid.php',
        type: 'POST',
        data: {userid: userid},
        success: function(response) {
            if (response == 'exists') {
                $('#userid-error').text('User ID already in use');
                $('#userid').addClass('is-invalid');
                $('#signup-button').prop('disabled', true);
            } else {
                $('#userid-error').text('User ID available');
                $('#userid').removeClass('is-invalid');
                $('#userid').addClass('is-valid');
                $('#signup-button').prop('disabled', false);
            }
        },
        error: function() {
            $('#userid-error').text('Error checking user ID');
            $('#userid').addClass('is-invalid');
        }
    });
}

    function checkEmail() {
        var email = $('#email').val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $('#email-error').text('Invalid email format');
            $('#email').addClass('is-invalid');

            return;
        }
        $.ajax({
            url: 'check_email_id.php',
            type: 'POST',
            data: {email: email},
            success: function(response) {
                if (response == 'exists') {
                    $('#email-error').text('Email already in use');
                    $('#email').addClass('is-invalid');
                    $('#signup-button').prop('disabled', true);
                } else {
                    $('#email-error').text('Email available');
                    $('#email').removeClass('is-invalid');
                    $('#email').addClass('is-valid');
                    $('#signup-button').prop('disabled', false);
                }
            },
            error: function() {
                $('#email-error').text('Error checking email');
                $('#email').addClass('is-invalid');
            }
        });
    }
    function checkPassword() {
    var password = $('#password').val();
    var confirm_password = $('#confirm-password').val();
    if (password != confirm_password) {
        $('#password-error').text('Passwords do not match');
        $('#confirm-password').addClass('is-invalid');
        $('#signup-button').prop('disabled', true);
        
    } else {
        $('#password-error').text('');
        $('#confirm-password').removeClass('is-invalid');
        $('#confirm-password').addClass('is-valid');
        $('#signup-button').prop('disabled', false);
    }
}
function isPasswordweak() {
    var password = $('#password').val();
    var lowercaseRegex = /[a-z]/;
    var uppercaseRegex = /[A-Z]/;
    var numberRegex = /\d/;
    if (password.length < 8 || !lowercaseRegex.test(password) || !uppercaseRegex.test(password) || !numberRegex.test(password)) {
        alert('Password is weak. It should be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one number.');
    }
}
</script>
</body>
</html>