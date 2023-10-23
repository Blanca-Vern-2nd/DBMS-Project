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
    <title>Confirmation Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">My Website</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Donate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Payment Confirmation
                    </div>
                    <div class="card-body text-center">
                        <p>Thank you for your payment!</p>
                        <p>Your payment of $<?php echo $_POST['amount']; ?> has been processed.</p>
                        <p>Name on Card: <?php echo $_POST['name']; ?></p>
                        <p>Card Number: **** **** **** <?php echo substr($_POST['card_number'], -4); ?></p>
                        <p>Expiry Date: <?php echo $_POST['expiry_date']; ?></p>
                        <p>CVV: ***</p>
                        <p><a href="download_receipt.php?name=<?php echo urlencode($_POST['name']); ?>&amount=<?php echo urlencode($_POST['amount']); ?>">Download Receipt</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper-base.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>