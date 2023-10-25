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

// Prepare SQL statement to select books with delivery set to 'Y'
$stmt = $conn->prepare('SELECT * FROM inventory');
$stmt->execute();
$result = $stmt->get_result();

// Close database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Donation</title>
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

        /* Style the book cards */
        .book-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 30%;
            display: inline-block;
            vertical-align: top;
            margin-right: 20px;
            text-align: center;
        }

        /* Book card on mouse-over */
        .book-card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        /* Book card image */
        .book-card img {
            width: 100%;
            height: auto;
        }

        /* Book card title */
        .book-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
            text-transform:uppercase;
        }

        /* Book card author */
        .book-card p.author {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book card ISBN */
        .book-card p.isbn {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book card class */
        .book-card p.class {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book card subject */
        .book-card p.subject {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Book card number of books */
        .book-card p.num-books {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Request button */
        .request-btn {
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
    <div class="navbar">
        <a href="student_dashboard.php">Home</a>
        <a href="courses.php">Your Courses</a>
        <a class="active" href="#">Request Donation</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>

    <div class="content">
        <h2>Request Donation</h2>
        <p>Select the books you would like to request for donation:</p>
        <?php while ($row = $result->fetch_assoc()) { ?>
    <div class="book-card">
        <!--img src="<?php echo $row['image']; ?>"-->
        <h3><?php echo $row['title']; ?></h3>
        <p class="author"><?php echo $row['author']; ?></p>
        <p class="isbn"><strong>ISBN:</strong> <?php echo $row['isbn']; ?></p>
        <p class="class"><strong>Class:</strong> <?php echo $row['class']; ?></p>
        <p class="subject"><strong>Subject:</strong> <?php echo $row['subject']; ?></p>
        <p class="num-books"><strong>Number of Books:</strong> <?php echo $row['num_books']; ?></p>
        <form action="request_book_process.php" method="post">
    <input type="hidden" name="book_id" value="<?php echo $row['isbn']; ?>">
    <button type="submit" class="request-btn">Request</button>
</form>
    </div>
<?php } ?>
    </div>
</body>
</html>