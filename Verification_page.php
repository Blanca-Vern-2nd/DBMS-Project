<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms2023";

$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
$user_id=$_SESSION['user_id'];
// Check if the user already has a pending verification
$stmt = $conn->prepare("SELECT * FROM pending_verification WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Display a message to the user to be patient and redirect to the student dashboard after 3 seconds
    echo '<p>Your verification is already pending. Please be patient and wait for it to be processed. You will be redirected to the student dashboard in <span id="countdown">3</span> seconds.</p>
    <script>
        var seconds = 3;
        setInterval(function() {
            seconds--;
            document.getElementById("countdown").textContent = seconds;
            if (seconds == 0) {
                window.location.href = "student_dashboard.php";
            }
        }, 1000);
    </script>';
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all files were uploaded successfully
    if (isset($_FILES["myIDFile"]) && isset($_FILES["parentIDFile"]) && isset($_FILES["incomeProofFile"]) &&
        $_FILES["myIDFile"]["error"] == UPLOAD_ERR_OK && $_FILES["parentIDFile"]["error"] == UPLOAD_ERR_OK &&
        $_FILES["incomeProofFile"]["error"] == UPLOAD_ERR_OK) {
        // Check file type and size constraints
        $allowedExtensions = ["pdf"];
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes

        $myIDFile = $_FILES["myIDFile"];
        $parentIDFile = $_FILES["parentIDFile"];
        $incomeProofFile = $_FILES["incomeProofFile"];

        if (!in_array(getFileExtension($myIDFile["name"]), $allowedExtensions) || $myIDFile["size"] > $maxSize ||
            !in_array(getFileExtension($parentIDFile["name"]), $allowedExtensions) || $parentIDFile["size"] > $maxSize ||
            !in_array(getFileExtension($incomeProofFile["name"]), $allowedExtensions) || $incomeProofFile["size"] > $maxSize) {
            // Redirect to an error page
            header("Location: verification_error.php");
            exit();
        }

        // Get the file data
        $myIDFileData = file_get_contents($myIDFile["tmp_name"]);
        $parentIDFileData = file_get_contents($parentIDFile["tmp_name"]);
        $incomeProofFileData = file_get_contents($incomeProofFile["tmp_name"]);

        // TODO: Process the file data as needed

        // Insert the verification request into the database
        $sql = "INSERT INTO pending_verification (user_id) VALUES ($user_id)";
        $conn->query($sql);

        // Display a success message and redirect to the student dashboard after 3 seconds
        echo "Thanks for submitting your verification. We will confirm your verification in 2-3 business days. You will be redirected to the student dashboard in 3 seconds.";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=student_dashboard.php\" />";
        exit();
    } else {
        // Redirect to an error page
        header("Location: verification_error.php");
        exit();
    }
}

function getFileExtension($filename) {
    return filename.split('.').pop().toLowerCase();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Verification Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f1f1f1;
        }

        h1 {
            color: #333;
        }

        form {
            border: 2px solid #333;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            margin-top:80px;
            max-width: 500px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        input[type="file"] {
            display: block;
            margin: 0 auto;
            margin-top: 5px;
            padding: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
    
            margin-top: 3rem;
        }

       

        p#verificationResult {
            font-weight: bold;
            margin-top: 10px;
        }
        .hie{
            margin-left: 8rem;
        }
        .ele{
            margin-bottom:2rem;
        }
        .warning {
            color: red;
            font-weight: bold;
            margin-top: 5px;
            text-align: center;
        }
    
    </style>
</head>
<body>
    <h1>Student Verification Page</h1>

    <?php if ($result->num_rows > 0): ?>
        <p>Your verification is already pending. Please be patient and wait for it to be processed. You will be redirected to the student dashboard in <span id="countdown">3</span> seconds.</p>
        <script>
            var seconds = 3;
            setInterval(function() {
                seconds--;
                document.getElementById("countdown").textContent = seconds;
                if (seconds == 0) {
                    window.location.href = "student_dashboard.php";
                }
            }, 1000);
        </script>
    <?php else: ?>
        <form id="verificationForm" enctype="multipart/form-data" action="verification_pending.php" method="post">
        <div class="ele"><label for="myIDFile">My ID (PDF only, max 5MB):</label>
    <div class="hie"><input type="file" id="myIDFile" name="myIDFile" accept=".pdf" required></div><p class="warning" id="myIDWarning"></p></div>

    <div class="ele"><label for="parentIDFile">Parent ID (PDF only, max 5MB):</label>
    <div class="hie"><input type="file" id="parentIDFile" name="parentIDFile" accept=".pdf" required></div><p class="warning" id="parentIDWarning"></p></div>

    <div class="ele"><label for="incomeProofFile">Income Proof (PDF only, max 5MB):</label>
    <div class="hie"><input type="file" id="incomeProofFile" name="incomeProofFile" accept=".pdf" required></div><p class="warning" id="incomeProofWarning"></p></div>
            <input type="submit" value="Submit">
        </form>
    <?php endif; ?>

    <script>
        const allowedExtensions = ["pdf"];
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes

        const myIDFile = document.getElementById("myIDFile");
        const parentIDFile = document.getElementById("parentIDFile");
        const incomeProofFile = document.getElementById("incomeProofFile");
        const myIDWarning = document.getElementById("myIDWarning");
        const parentIDWarning = document.getElementById("parentIDWarning");
        const incomeProofWarning = document.getElementById("incomeProofWarning");

        document.getElementById("verificationForm").addEventListener("submit", function (e) {
            const files = [myIDFile.files[0], parentIDFile.files[0], incomeProofFile.files[0]];
            let valid = true;

            for (const file of files) {
                if (!file || !allowedExtensions.includes(getFileExtension(file.name)) || file.size > maxSize) {
                    valid = false;
                    break;
                }
            }

            if (!valid) {
                e.preventDefault();
                myIDWarning.textContent = "";
                parentIDWarning.textContent = "";
                incomeProofWarning.textContent = "Please ensure all files are PDFs and less than 5MB.";
            }
        });

        function getFileExtension(filename) {
            return filename.split('.').pop().toLowerCase();
        }
    </script>
</body>
</html>