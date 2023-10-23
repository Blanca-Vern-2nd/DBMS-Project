<?php
// Check if the form was submitted
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $bookTitle = $_POST['book_title'];
    $bookAuthor = $_POST['book_author'];
    $bookIsbn = $_POST['book_isbn'];
    $bookCondition = $_POST['book_condition'];
    $bookDescription = $_POST['book_description'];
    $userId = $_SESSION['user_id'];

    // Validate the form data
    if (empty($bookTitle) || empty($bookAuthor) || empty($bookIsbn) || empty($bookCondition)) {
        // Set an error message
        $error_message = 'Please fill out all required fields.';
    } else {
        // Save the form data to the database
        $conn = mysqli_connect('localhost', 'root', '', 'dbms2023');
        $sql = "INSERT INTO book_donations (title, author, isbn, `condition`, description, user_id) VALUES ('$bookTitle', '$bookAuthor', '$bookIsbn', '$bookCondition', '$bookDescription', '$userId')";
        mysqli_query($conn, $sql);

        // Set a success message
        $success_message = 'Thank you for donating your book!';
    }
} else {
    // Redirect the user to the donate_books.php page
    header('Location: donate_books.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donate Books</title>
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

        /* Style the success message */
        .success {
            color: green;
            font-weight: bold;
            font-size: 24px;
            margin: 50px auto;
            text-align: center;
        }

        /* Style the error message */
        .error {
            color: red;
            font-weight: bold;
            font-size: 24px;
            margin: 50px auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="donor_dashboard.php">Home</a>
        <a href="donate.php">Financial Donation</a>
        <a class="active" href="#">Donate Books</a>
        <a href="give_my_receipt.php">Request Receipt</a>
        <a href="show_my_receipts.php">Show receipt numbers</a>
        <a href="home.php" class="right">Logout</a>
    </div>

    <div class="content">
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>