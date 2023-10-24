<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

// Get user ID from session variable
$user_id = $_SESSION['user_id'];

// Check if form was submitted
if (isset($_POST['submit'])) {
    // Get receipt number from form data
    $receipt_number = $_POST['receipt_number'];

    // Connect to database
    $pdo = new PDO('mysql:host=localhost;dbname=dbms2023', 'root', '');

    // Get receipt from database
    $stmt = $pdo->prepare('SELECT * FROM receipts WHERE receipt_number = ? AND user_id = ?');
    $stmt->execute([$receipt_number, $user_id]);
    $receipt = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if receipt was found
    if ($receipt) {
        // Output receipt file
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $receipt_number . '.pdf"');
        echo $receipt['receipt_file'];
        exit();
    } else {
        // Display error message
        $error = 'Receipt not found.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Give My Receipt</title>
    <style>
        /* Style the navbar */
        .navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
        }

        /* Navbar links */
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        /* Navbar links on mouse-over */
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Add a color to the active/current link */
        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }

        /* Style the content */
        .content {
            margin-top: 50px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
    <a href="donor_dashboard.php">Home</a>
        <a href="donate.php">Financial Donation</a>
        <a href="donate_books.php">Donate books</a>
        <a class="active" href="#">Request Receipt</a>
        <a href="show_my_receipts.php">Show receipt numbers</a>
        <a href="show_my_books.php">Show Book donation status</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>

    <div class="content">
        <h2>Give My Receipt</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="receipt_number">Receipt Number:</label>
            <input type="text" id="receipt_number" name="receipt_number" required>
            <br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>