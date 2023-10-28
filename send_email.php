<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>
    <h1>Send an Email</h1>

    <?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (isset($_POST['send_email'])) {
    $to = "mamtajoshi615@gmail.com";
    $subject = "Formal Greetings from Gyanganga Website";
    $message = "Dear Sir/Madam,\n\nWe hope this email finds you well. We are writing to inform you about our latest products and services. We believe that our offerings can greatly benefit your business and help you achieve your goals.\n\nPlease do not hesitate to contact us if you have any questions or would like to learn more about our products and services. We look forward to hearing from you soon.\n\nBest regards,\nBlanca";

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set this to DEBUG_SERVER for troubleshooting
        $mail->isSMTP();
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'blancavern3@gmail.comm';
        $mail->Password = 'nnpixmqiluurveci'; // Replace with your Yahoo Mail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('lucky615b@gmail.com', 'Blanca from Gyanganga');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo "Email sent successfully.";
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>

    <form method="post">
        <input type="submit" name="send_email" value="Send Email">
    </form>
</body>
</html>