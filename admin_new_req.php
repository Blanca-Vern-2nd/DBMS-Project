<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer library
require 'vendor/autoload.php';

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms2023";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID and action from the form
    $id = $_POST["id"];
    $action = $_POST["action"];

    // Check if the action is to approve the request
    if ($action == "approve") {
        // Retrieve the pending verification from the database
        $stmt = $conn->prepare("SELECT * FROM pending_verification WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the verification exists
        if ($result->num_rows == 1) {
            // Get the verification data from the result set
            $row = $result->fetch_assoc();
            $user_id = $row["user_id"];
            $my_id_file = $row["my_id_file"];
            $parent_id_file = $row["parent_id_file"];
            $income_proof_file = $row["income_proof_file"];

            // Insert the verification into the confirmed_verification table
            $stmt = $conn->prepare("INSERT INTO confirmed_verification (user_id, my_id_file, income_proof_file) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user_id, $my_id_file, $income_proof_file);
            $stmt->execute();

            // Update the financial_approval column in the student_data table
            $stmt = $conn->prepare("UPDATE student_data SET financial_approval = 'y' WHERE userid = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            // Delete the verification from the pending_verification table
            $stmt = $conn->prepare("DELETE FROM pending_verification WHERE user_id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            // Send an email notification
            $mail = new PHPMailer(true);
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
                );
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'Blancavern3@gmail.com';
                $mail->Password = 'Veron3mayica';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 465;

                //Recipients
                $mail->setFrom('admin@example.com', 'Admin');
                $mail->addAddress('luckyjoshi615@gmail.com');

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Verification Approved';
                $mail->Body = 'Your verification request has been approved.';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        }
    } else if ($action == "reject") {
        // Delete the verification from the pending_verification table
        $stmt = $conn->prepare("DELETE FROM pending_verification WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Retrieve the pending verifications from the database
$stmt = $conn->prepare("SELECT * FROM pending_verification");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Approval Requests</title>
    <style>
        .verification-table {
            border-collapse: collapse;
            width: 100%;
        }

        .verification-table th, .verification-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .verification-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            text-align:center;
        }

        .verification-table td {
            font-size: 14px;
            text-align:center;
        }

        .view-button, .approve-button, .reject-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .view-button:hover, .approve-button:hover, .reject-button:hover {
            background-color: #3e8e41;
        }

        .approve-button {
            background-color: #4CAF50;
        }

        .reject-button {
            background-color: #f44336;
        }

        .approve-button:hover {
            background-color: #3e8e41;
        }

        .reject-button:hover {
            background-color: #f44336;
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
            font-family: Arial, sans-serif;
        }

        /* Style the links inside the navbar */
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change the color of the active link */
        .navbar a.active {
            background-color: #4CAF50;
        }

        /* Style the logout link */
        .navbar a.right {
            float: right;
        }

        /* Add a hover effect to all links, except for the active one */
        .navbar a:not(.active):hover {
            background-color: #ddd;
            color: black;
        }

        /* Clear floats after the navbar */
        .navbar::after {
            content: "";
            clear: both;
            display: table;
        }

        .content {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="admin_page.php" >Pending Donations</a>
        <a href="admin_deliv.php" >Book Delivery</a>
        <a href="admin_new_req.php" class="active">Student Approval Requests</a>
        <a href="home.php" style="float: right;">Logout</a>
    </div>
    <div class="content">
        <h1>Pending Approval Requests</h1>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class='verification-table'>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>My ID File</th>
                        <th>Parent ID File</th>
                        <th>Income Proof File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["user_id"]; ?></td>
                            <td><button class='view-button' onclick='viewPDF("<?php echo base64_encode($row["my_id_file"]); ?>")'>View</button></td>
                            <td><button class='view-button' onclick='viewPDF("<?php echo base64_encode($row["parent_id_file"]); ?>")'>View</button></td>
                            <td><button class='view-button' onclick='viewPDF("<?php echo base64_encode($row["income_proof_file"]); ?>")'>View</button></td>
                            <td>
                                <form method='post'>
                                    <input type='hidden' name='id' value='<?php echo $row["user_id"]; ?>'>
                                    <button class='approve-button' type='submit' name='action' value='approve'>Approve</button>
                                    <button class='reject-button' type='submit' name='action' value='reject'>Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pending book donations.</p>
        <?php endif; ?>
    </div>
    <script>
        function viewPDF(pdfData) {
            // Open the PDF file in a new window
            var win = window.open();
            win.document.write("<embed src='data:application/pdf;base64," + pdfData + "' width='100%' height='100%' type='application/pdf' />");
        }
    </script>
</body>
</html>