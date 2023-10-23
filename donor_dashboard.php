<!DOCTYPE html>
<html>
<head>
    <title>Donor Dashboard</title>
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
        <a class="active" href="#">Home</a>
        <a href="donate.php">Financial Donation</a>
        <a href="donate_books.php">Donate books</a>
        <a href="give_my_receipt.php">Request Receipt</a>
        <a href="show_my_receipts.php">Show receipt numbers</a>
        <a href="show_my_books.php">Show Book donation status</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>

    <div class="content">
        <h2>Welcome to the Donor Dashboard</h2>
        <p>Here you can manage your donations and view your donation history.</p>
        <p>Please select an option from the navbar above.</p>
    </div>
</body>
</html>