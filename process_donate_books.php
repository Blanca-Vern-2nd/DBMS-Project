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
    $bookSubject = $_POST['book_subject'];
    $bookClass = $_POST['book_class'];
    $userId = $_SESSION['user_id'];

    // Validate the form data
    if (empty($bookTitle) || empty($bookAuthor) || empty($bookIsbn) || empty($bookCondition) || empty($bookSubject) || empty($bookClass)) {
        // Set an error message
        $error_message = 'Please fill out all required fields.';
    } else {
        // Save the form data to the database
        $conn = mysqli_connect('localhost', 'root', '', 'dbms2023');
        $sql = "INSERT INTO book_donations (title, author, isbn, `condition`, description, user_id, subject, class) VALUES ('$bookTitle', '$bookAuthor', '$bookIsbn', '$bookCondition', '$bookDescription', '$userId', '$bookSubject', '$bookClass')";
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
        /* Style the navigation bar */
        .navbar {
            overflow: hidden;
            background-color: #c0e6f0;
            position: fixed;
            top: 0;
            width: 100%;
        }

        /* Style the links inside the navigation bar */
        .navbar a {
            float: left;
            display: block;
            color: #333;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        /* Change the color of links on hover */
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Add a color to the active/current link */
        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }

        /* Style the content div */
        .content {
            margin-top: 80px;
            text-align: center;
        }

        /* Style the form */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #c0e6f0;
        }

        /* Style the form fields */
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Style the error message */
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="donor_dashboard.php">Home</a>
        <a href="donate.php">Financial Donation</a>
        <a class="active" href="donate_books.php">Donate books</a>
        <a href="give_my_receipt.php">Request Receipt</a>
        <a href="show_my_receipts.php">Show receipt numbers</a>
        <a href="show_my_books.php">Show Book donation status</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>
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