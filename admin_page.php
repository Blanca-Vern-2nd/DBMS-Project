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
    $status = $_POST['status'];

    // Update or delete the book_donations table based on the status
    if ($status === 'approved') {
        // Update the row with the default data
        $sql = "UPDATE book_donations SET status = 'approved', approval_date = NOW() WHERE id = $id";
        mysqli_query($conn, $sql);
    } elseif ($status === 'rejected') {
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
</head>
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
            text-align: center;
        }

        th {
    background-color: #333;
    color: white;
    
}

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .content {
            text-align: center;
        }
       /* Style the buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 0.5rem;
}
.buttons
button:hover {
    background-color: #45a049;
}

button[type="button"] {
    background-color: #008CBA;
}

button[type="button"]:hover {
    background-color: #0077B3;
}

button[name="approve"] {
    background-color: #4CAF50;
}

button[name="approve"]:hover {
    background-color: #45a049;
}

button[name="reject"] {
    background-color: #f44336;
}

button[name="reject"]:hover {
    background-color: #d32f2f;
}

button[name="alter"] {
    background-color: #008CBA;
    margin-top: 0.5rem;
    margin-left: 0.5rem;
    padding: 0.5rem 3.5rem;
}

button[name="alter"]:hover {
    background-color: #0077B3;
    
}

        
    </style>
<body>
    <div class="navbar">
        <a href="admin_page.php" class="active">Pending Donations</a>
        <a href="admin_deliv.php">Book Delivery</a>
        <a href="admin_new_req.php">Student Approval Requests</a>
        <a href="home.php" style="float: right;">Logout</a>
    </div>

    <div class="content">
        <h1>Pending Book Donations</h1>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Condition</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['author'] ?></td>
                        <td><?= $row['isbn'] ?></td>
                        <td><?= $row['class'] ?></td>
                        <td><?= $row['subject'] ?></td>
                        <td><?= $row['condition'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="status" value="approved">Approve</button>
                                <button type="submit" name="status" value="rejected">Reject</button>
                            </form>
                            
                            <form method="get" action="alter_book_details.php">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="alter">Alter</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No pending book donations.</p>
        <?php endif; ?>
    </div>
</body>
</html>