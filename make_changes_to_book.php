<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'dbms2023');

// Get the ID of the book donation from the query parameter
$id = $_GET['id'];

// Query the book_donations table for the book donation with the specified ID
$sql = "SELECT * FROM book_donations WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Make Changes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the form */
        form {
            margin: 0 auto;
            width: 50%;
            text-align: left;
        }

        label {
            display: block;
            margin-top: 1rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            margin-top:5rem;
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            length:30px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
        h1,.buttons{
            text-align:center;
        }
    </style>
</head>
<body>
    <h1>Make Changes</h1>
    <form method="post" action="admin_page.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>">
        <label for="author">Author:</label>
        <input type="text" name="author" id="author" value="<?php echo $row['author']; ?>">
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" id="isbn" value="<?php echo $row['isbn']; ?>">
        <label for="class">Class:</label>
        <input type="text" name="class" id="class" value="<?php echo $row['class']; ?>">
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" value="<?php echo $row['subject']; ?>">
        <label for="condition">Condition:</label>
        <input type="text" name="condition" id="condition" value="<?php echo $row['condition']; ?>">
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" value="<?php echo $row['description']; ?>">
        <div class="buttons"><button type="submit" name="submit" value="submit">Submit</button></div>
    </form>
</body>
</html>