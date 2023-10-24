<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['user_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Connect to the database using mysqli
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms2023";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Update the delivered column if the mark as delivered button is clicked
if (isset($_GET['delivered'])) {
    $id = $_GET['delivered'];
    $sql = "UPDATE book_donations SET delivered = 'Y' WHERE id = $id";
    mysqli_query($conn, $sql);
}

// Query the book_donations table for all pending donations
$sql = "SELECT * FROM book_donations WHERE delivered = 'N' and status='approved'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
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

        /* Change the color of links on hover */
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Add a background color to the active/current link */
        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }

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
            background-color: #0074D9;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style the mark as delivered button */
        .delivered-btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delivered-btn:hover {
            background-color: #66ff66;
        }
        .content {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="admin_page.php">Pending Donations</a>
        <a href="admin_deliv.php" class="active">Book Delivery</a>
        <a href="admin_new_req.php" >Student Approval Requests</a>
        <a href="home.php" style="float: right;">Logout</a>
    </div>
    <div class="content">
    <h1>Book Delivery</h1>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>User ID</th>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
            <th>Condition</th>
            <th>Mark as Delivered</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['isbn']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['author']; ?></td>
                <td><?php echo $row['condition']; ?></td>
                <td><button class="delivered-btn" onclick="location.href='admin_deliv.php?delivered=<?php echo $row['id']; ?>'">Mark as Delivered</button></td>
            </tr>
        <?php endwhile; ?>
    </table>
        </div>
        <?php else: ?>
        <p>No pending book donations.</p>
    <?php endif; ?>
</body>
</html>