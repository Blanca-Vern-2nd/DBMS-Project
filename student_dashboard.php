<?php
// Start session
session_start();
if (!isset($_SESSION['user_id'])) {
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the navigation bar */
        .navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
        }

        /* Style the links inside the navigation bar */
        .navbar a {
            float: left;
            display: block;
            color: white;
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
        <a href="courses.php">Your Courses</a>
        <a href="inventory.php">Our Inventory</a>
        <a href="request_book.php">Request Donation</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>
    
</body>
</html>