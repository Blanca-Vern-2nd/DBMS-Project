<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'dbms2023');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Prepare SQL statement to select financial_approval column from student_data table
$stmt = $conn->prepare('SELECT financial_approval FROM student_data WHERE userid = ?');
$stmt->bind_param('s', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if financial_approval is set to 'Y'
if ($row = $result->fetch_assoc()) {
    if ($row['financial_approval'] != 'Y') {
        header('Location: Not_verified.php');
        exit();
    }
} else {
    header('Location: Not_verified.php');
    exit();
}

// Check if book_id parameter is set
if (!isset($_POST['book_id'])) {
    header('Location: request_book.php');
    exit();
}

// Prepare SQL statement to select book details from inventory view
$stmt = $conn->prepare('SELECT * FROM inventory WHERE id = ?');
$stmt->bind_param('i', $_POST['book_id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if book exists in inventory
if (!$row = $result->fetch_assoc()) {
    header('Location: request_book.php');
    exit();
}

// Prepare SQL statement to insert book request into requests table
$stmt = $conn->prepare('INSERT INTO requests (userid, bookid, status) VALUES (?, ?, ?)');
$status = 'Pending';
$stmt->bind_param('iis', $_SESSION['user_id'], $_POST['book_id'], $status);
$stmt->execute();

// Close database connection
$stmt->close();
$conn->close();

// Redirect to request confirmation page
header('Location: request_book_confirm.php');
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Request</title>
    <style>
        /* Style the content */
        .content {
            margin-top: 50px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Style the book details */
        .book-details {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 50%;
            display: inline-block;
            vertical-align: top;
            margin-right: 20px;
        }

        /* Book details image */
        .book-details img {
            width: 100%;
            height: auto;
        }

        /* Book details title */
        .book-details h3 {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
            text-transform:uppercase;
        }

        /* Book details author */
        .book-details p.author {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book details ISBN */
        .book-details p.isbn {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book details class */
        .book-details p.class {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book details subject */
        .book-details p.subject {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Confirm button */
        .confirm-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
    <div class="content">
        <?php if ($row = $result->fetch_assoc()) { ?>
        <div class="book-details">
            <!--img src="<?php echo $row['image']; ?>"-->
            <h3><?php echo $row['title']; ?></h3>
            <p class="author"><?php echo $row['author']; ?></p>
            <p class="isbn"><strong>ISBN:</strong> <?php echo $row['isbn']; ?></p>
            <p class="class"><strong>Class:</strong> <?php echo $row['class']; ?></p>
            <p class="subject"><strong>Subject:</strong> <?php echo $row['subject']; ?></p>
        </div>
        <p>Please confirm that you would like to request this book:</p>
        <form action="request_book_confirm.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="confirm-btn">Confirm Request</button>
        </form>
        <?php } else { ?>
        <p>Book not found.</p>
        <?php } ?>
    </div>
</body>
</html>