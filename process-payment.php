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
    <title>Payment Confirmation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Payment Platform</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            <div class="ml-auto">
                <a href="home.php" style="float:right">Logout</a>
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
                    <div class="card-body">
                        <?php
                        // Get form data
                        $name = $_POST['name'];
                        $card_number = $_POST['card_number'];
                        $expiry_date = $_POST['expiry_date'];
                        $cvv = $_POST['cvv'];
                        $amount = $_POST['amount'];

                        // TODO: Process payment and store in database

                        // Display confirmation message
                        echo "<p>Thank you for your payment of $amount.</p>";
                        echo "<p>Name on Card: $name</p>";
                        echo "<p>Card Number: **** **** **** " . substr($card_number, -4) . "</p>";
                        echo "<p>Expiry Date: $expiry_date</p>";
                        echo "<p>CVV: ***</p>";
                        ?>
                        <form method="post" action="confirm_payment.php">
                            <input type="hidden" name="name" value="<?php echo $name; ?>">
                            <input type="hidden" name="card_number" value="<?php echo $card_number; ?>">
                            <input type="hidden" name="expiry_date" value="<?php echo $expiry_date; ?>">
                            <input type="hidden" name="cvv" value="<?php echo $cvv; ?>">
                            <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                            <div class="d-flex justify-content-center">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Confirm Payment</button>
                                </div>
                                </div>
                        </form>
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