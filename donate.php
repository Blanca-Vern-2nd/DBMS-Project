<?php
session_start();?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Platform</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
                    <a class="nav-link" href="donor_dashboard.php">Home</a>
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
                        Payment Information
                    </div>
                    <div class="card-body text-center">
       
                        <form method="post" action="process-payment.php" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="name">Name on Card</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                
                                <label for="card_number">Card Number</label>
                                <input type="text" class="form-control" id="card_number" name="card_number" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </form>
                    </div>
                    
                    <script>
                    function validateForm() {
                        // Get form fields
                        var name = document.getElementById("name").value;
                        var card_number = document.getElementById("card_number").value;
                        var expiry_date = document.getElementById("expiry_date").value;
                        var cvv = document.getElementById("cvv").value;
                        var amount = document.getElementById("amount").value;
                    
                        // Validate form fields
                        if (name == "" || card_number == "" || expiry_date == "" || cvv == "" || amount == "") {
                            alert("Please fill in all required fields");
                            return false;
                        }
                    
                        // Validate card number
                        var card_regex = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/;
                        if (!card_regex.test(card_number)) {
                            alert("Please enter a valid credit card number");
                            return false;
                        }
                    
                        // Validate expiry date
                        var expiry_regex = /^(0[1-9]|1[0-2])\/([0-9]{4})$/;
                        if (!expiry_regex.test(expiry_date)) {
                            alert("Please enter a valid expiry date (MM/YYYY)");
                            return false;
                    }

                        // Validate CVV
                        var cvv_regex = /^[0-9]{3,4}$/;
                        if (!cvv_regex.test(cvv)) {
                            alert("Please enter a valid CVV");
                            return false;
                        }
                    
                        // Validate amount
                        var amount_regex = /^[0-9]+(\.[0-9]{1,2})?$/;
                        if (!amount_regex.test(amount)) {
                            alert("Please enter a valid amount");
                            return false;
                        }
                    
                        return true;
                    }
                    
                    $(function() {
                        $("#expiry_date").datepicker({
                            dateFormat: "dd/mm/yy",
                            changeMonth: true,
                            changeYear: true,
                            showButtonPanel: true,
                            minDate: new Date()
                        });
                    });
                    </script>
                    </div>
                    </div>
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