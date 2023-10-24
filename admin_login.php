<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the login form */
        .login-form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style the form fields */
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Style the login button */
        .login-form button {
            background-color: #0074D9;
            color: #fff;
            padding: 14px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        /* Add a hover effect to the login button */
        .login-form button:hover {
            background-color:  #0074E8;
        }

        /* Add a cancel button */
        .login-form .cancel-button {
            background-color: #333;
            color: #fff;
        }

        /* Add a hover effect to the cancel button */
        .login-form .cancel-button:hover {
            background-color: #333;
        }

        /* Style the form labels */
        .login-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        /* Style the form title */
        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style the error message */
        .login-form .error-message {
            color: #f00;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Admin Login</h2>
        <?php
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if the username and password are correct
            if ($username == 'hewwo' && $password == 'hehe') {
                // Redirect the user to the admin_page.php page
                header('Location: admin_work.php');
                exit;
            } else {
                // Set an error message
                $error_message = 'Invalid username or password.';
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <button type="button" class="cancel-button" onclick="window.location.href='home.php'">Cancel</button>

            <?php if (isset($error_message)) { ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>