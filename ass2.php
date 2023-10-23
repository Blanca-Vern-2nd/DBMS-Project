<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .d1{
            color:green;
            font-size:1.5rem;
            text-align:justify;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>SIGN UP FORM</h2>
        <form action="ass3.php" method="post">
            <div class="form-group">
                <label for="username">Name:</label>
                <input type="text" id="username" name="name" required>
            </div>
            <div class="form-group">
                <label for="favoriteColor">Address:</label>
                <input type="text" id="favoriteColor" name="color" required>
            </div>
            <div class="form-group">
                <label for="favoriteColor">Phone:</label>
                <input type="number" id="favoriteColor" name="phone" required>
            </div>
            <div class="form-group">
                <label for="favoriteColor">Email:</label>
                <input type="email" id="favoriteColor" name="email" >
            </div>
            
            <div class="form-group">
                <label for="dob">Password</label>
                <input type="password" id="favoriteColor" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="submit">
            </div>
        </form>
        

    </div>
</body>
</html>
