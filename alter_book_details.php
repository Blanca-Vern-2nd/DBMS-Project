<?php
// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dbms2023';
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $condition = $_POST['condition'];
    $description = $_POST['description'];

    // Update the row with the new data
    $sql = "UPDATE book_donations SET title = '$title', author = '$author', isbn = '$isbn', class = '$class', subject = '$subject', `condition` = '$condition' WHERE id = $id";
    mysqli_query($conn, $sql);

    // Redirect back to the admin page
    header('Location: admin_page.php');
    exit;
}

// Get the book donation details from the database
$id = $_GET['id'];
$sql = "SELECT * FROM book_donations WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alter Book Details</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4 text-center">Alter Book Details</h1>
        <form method="post" style="margin-bottom: 40px;">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?= $row['title'] ?>">
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" name="author" id="author" value="<?= $row['author'] ?>">
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" name="isbn" id="isbn" value="<?= $row['isbn'] ?>">
            </div>
            <div class="form-group">
    <label for="class">Class:</label>
    <select class="form-control" name="class" id="class">
        <option value="">Select class</option>
        <?php for ($i = 1; $i <= 12; $i++) { ?>
            <option value="<?= $i ?>"><?= $i ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label for="subject">Subject:</label>
    <select class="form-control" name="subject" id="subject">
        <option value="">Select subject</option>
        <option value="maths">Maths</option>
        <option value="science">Science</option>
        <option value="english">English</option>
        <option value="hindi">Hindi</option>
        <option value="general knowledge">General Knowledge</option>
        <option value="social science">Social Science</option>
        <option value="chemistry">Chemistry</option>
        <option value="biology">Biology</option>
        <option value="physics">Physics</option>
    </select>
    </div>
    <div class="form-group">
        <label for="condition">Condition:</label>
        <select class="form-control" name="condition" id="condition">
            <option value="">Select condition</option>
            <option value="new" <?= $row['condition'] == 'new' ? 'selected' : '' ?>>New</option>
            <option value="like new" <?= $row['condition'] == 'like new' ? 'selected' : '' ?>>Like new</option>
            <option value="good" <?= $row['condition'] == 'good' ? 'selected' : '' ?>>Good</option>
            <option value="fair" <?= $row['condition'] == 'fair' ? 'selected' : '' ?>>Fair</option>
            <option value="poor" <?= $row['condition'] == 'poor' ? 'selected' : '' ?>>Poor</option>
        </select>
</div>
            
            <div class="text-center"><button type="submit" class="btn btn-primary">Save Changes</button></div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>