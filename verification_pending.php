<!DOCTYPE html>
<html>
<head>
    <title>Verification Pending</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the button */
        .return-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            color: grey;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Add a hover effect to the button */
        .return-button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms2023";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user already has a pending verification
$stmt = $conn->prepare("SELECT * FROM pending_verification WHERE user_id = ?");
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Display an error message
    echo "You already have a pending verification.";
} else {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO pending_verification (user_id, my_id_file, parent_id_file, income_proof_file) VALUES (?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("ssss", $user_id, $my_id_file, $parent_id_file, $income_proof_file);

    $user_id = $_SESSION['user_id'];
    $my_id_file = file_get_contents($_FILES['myIDFile']['tmp_name']);
    $parent_id_file = file_get_contents($_FILES['parentIDFile']['tmp_name']);
    $income_proof_file = file_get_contents($_FILES['incomeProofFile']['tmp_name']);

    // Execute the statement
    $stmt->execute();

    // Close the statement and the connection
    $stmt->close();
    $conn->close();

    // Display a success message
    echo "Thanks for submitting your verification. We will confirm your verification in 2-3 business days.";
}
?>
<a href="student_dashboard.php" class="return-button">Return Home</a>

</body>
</html>