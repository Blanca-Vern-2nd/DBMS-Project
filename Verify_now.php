<!DOCTYPE html>
<html>
<head>
    <title>Verify Financial Status</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css" integrity="sha512-+zJ5zv9zvJ5zvJzvJ5zvJzvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5zvJ5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body text-center">
                <h2 class="card-title mb-4">Verify Financial Status</h2>
                <p class="card-text mb-4">To verify your financial status, please upload one of the following:</p>
                <form action="verification_handler.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="bank_statement" class="form-label">Bank statement</label>
                        <input type="file" class="form-control" id="bank_statement" name="bank_statement">
                    </div>
                    <div class="mb-3">
                        <label for="tax_return" class="form-label">Tax return</label>
                        <input type="file" class="form-control" id="tax_return" name="tax_return">
                    </div>
                    <div class="mb-3">
                        <label for="pay_stub" class="form-label">Pay stub</label>
                        <input type="file" class="form-control" id="pay_stub" name="pay_stub">
                    </div>
                    <div class="mb-3">
                        <label for="credit_report" class="form-label">Credit report</label>
                        <input type="file" class="form-control" id="credit_report" name="credit_report">
                    </div>
                    <div class="mb-3">
                        <label for="asset_verification" class="form-label">Asset verification</label>
                        <input type="file" class="form-control" id="asset_verification" name="asset_verification">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>