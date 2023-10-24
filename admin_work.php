<!DOCTYPE html>
<html>
<head>
    <title>Admin Work</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the cards */
        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            text-align: center;
        }

        .card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .card a {
            background-color: #0074D9;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }

        .card a:hover {
            background-color: #0074E8;
        }

        /* Center the h1 element */
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Admin Work</h1>
    <div class="card">
        <h3>Book Approval</h3>
        <p>Approve or reject book donations.</p>
        <a href="admin_page.php">Go to Book Approval</a>
    </div>

    <div class="card">
        <h3>Book Delivery</h3>
        <p>View and manage book delivery requests.</p>
        <a href="admin_deliv.php">Go to Book Delivery</a>
    </div>

    <div class="card">
        <h3>Student Request Approval</h3>
        <p>Approve or reject student book requests.</p>
        <a href="admin_new_req.php">Go to Student Request Approval</a>
    </div>
</body>
</html>