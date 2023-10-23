<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'dbms2023');

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the ID of the book donation and the status from the form
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update or delete the book_donations table based on the status
    if ($status == 'approved') {
        $sql = "UPDATE book_donations SET status = 'approved',approval_date=NOW() WHERE id = $id";
        mysqli_query($conn, $sql);
    } elseif ($status == 'rejected') {
        $sql = "DELETE FROM book_donations WHERE id = $id";
        mysqli_query($conn, $sql);
    }
}

// Query the book_donations table for all pending donations
$sql = "SELECT * FROM book_donations WHERE status = 'pending'";
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
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="active">Pending Donations</a>
        <a href="home.php" class="right">Logout</a>
    </div>

    <div class="content">
        <h2>Pending Book Donations</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Condition</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                        <td><?php echo $row['isbn']; ?></td>
                        <td><?php echo $row['condition']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="status">
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                                <input type="submit" name="submit" value="Submit">
                            </form>
                        </td>
                    </tr>
                <?php }?>
            </table>
        <?php else: ?>
            <p>No pending book donations.</p>
        <?php endif; ?>
    </div>
</body>
</html>