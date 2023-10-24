<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connect to the database using PDO
$dsn = 'mysql:host=localhost;dbname=dbms2023';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Query the book_donations table for all donations by the current user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM book_donations WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$book_donations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results in a table
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Book Donations</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the table */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        /* Style the navbar */
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
        <a href="show_my_receipts.php">Show receipt numbers</a>
        <a class="active" href="#">Show Book donation status</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>
    <h1>My Book Donations</h1>
    <?php if (count($book_donations) > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Condition</th>
                <th>Status</th>
                <th>Expected Pick-Up Date</th>
            </tr>
            <?php foreach ($book_donations as $book_donation): ?>
    <tr>
        <td><?php echo $book_donation['title']; ?></td>
        <td><?php echo $book_donation['author']; ?></td>
        <td><?php echo $book_donation['isbn']; ?></td>
        <td><?php echo $book_donation['condition']; ?></td>
        <td><?php echo $book_donation['status']; ?></td>
        <?php if ($book_donation['delivered'] == 'Y'): ?>
            <td>Delivered</td>
        <?php elseif ($book_donation['status'] == 'approved'): ?>
            <?php $date = date('Y-m-d', strtotime('+7 days')); ?>
            <td><?php echo $date; ?></td>
        <?php else: ?>
            <td>N/A</td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>You have not donated any books yet.</p>
    <?php endif; ?>
</body>
</html>