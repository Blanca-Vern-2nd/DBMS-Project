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

// Connect to database
$pdo = new PDO('mysql:host=localhost;dbname=dbms2023', 'root', '');

// Get all receipts for the user
$stmt = $pdo->prepare('SELECT * FROM receipts WHERE user_id = ?');
$stmt->execute([$user_id]);
$receipts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Receipts</title>
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
        <a href="give_my_receipt.php">Request Receipt</a>
        <a class="active" href="#">Show receipt numbers</a>
        <a href="show_my_books.php">Show Book donation status</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>

    <div class="content">
        <h2>My Receipts</h2>
        <?php if (count($receipts) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Receipt Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($receipts as $receipt): ?>
                        <tr>
                            <td><?php echo $receipt['receipt_number']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No receipts found.</p>
        <?php endif; ?>
    </div>
</body>
</html>