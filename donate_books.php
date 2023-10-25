<!DOCTYPE html>
<html>
<head>
    <title>Donate Books</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Style the navigation bar */
        .navbar {
            overflow: hidden;
            background-color: #c0e6f0;
            position: fixed;
            top: 0;
            width: 100%;
        }

        /* Style the links inside the navigation bar */
        .navbar a {
            float: left;
            display: block;
            color: #333;
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

        /* Style the content div */
        .content {
            margin-top: 80px;
            text-align: center;
        }

        /* Style the form */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #c0e6f0;
        }

        /* Style the form fields */
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Style the error message */
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
    <a href="donor_dashboard.php"">Home</a>
        <a href="donate.php">Financial Donation</a>
        <a class="active" href="#">Donate books</a>
        <a href="give_my_receipt.php">Request Receipt</a>
        <a href="show_my_receipts.php">Show receipt numbers</a>
        <a href="show_my_books.php">Show Book donation status</a>
        <a href="home.php" style="float:right">Logout</a>
    </div>

    <div class="content">
        <h2>Donate Books</h2>
        <form id="donate-books-form" action="process_donate_books.php" method="post">
    <label for="book-title">Title:</label>
    <input type="text" id="book-title" name="book_title" required>

    <label for="book-author">Author:</label>
    <input type="text" id="book-author" name="book_author" required>

    <label for="book-isbn">ISBN:</label>
    <input type="text" id="book-isbn" name="book_isbn" required>

    <label for="book-condition">Condition:</label>
    <select id="book-condition" name="book_condition" required>
        <option value="">Select condition</option>
        <option value="new">New</option>
        <option value="like new">Like new</option>
        <option value="good">Good</option>
        <option value="fair">Fair</option>
        <option value="poor">Average</option>
    </select>

    <label for="book-class">Class:</label>
    <select id="book-class" name="book_class" required>
        <option value="">Select class</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select>

    <label for="book-subject">Subject:</label>
    <select id="book-subject" name="book_subject" required>
        <option value="">Select subject</option>
        <option value="maths">Maths</option>
        <option value="science">Science</option>
        <option value="english">English</option>
        <option value="hindi">Hindi</option>
        <option value="general knowledge">General Knowledge</option>
        <option value="social science">Social Science</option>
        <option value="chemistry">Chemistry</option>
        <option value="biology">Biology</option>
        <option value="physics">Physics</option>
    </select>

    <label for="book-description">Description:</label>
    <textarea id="book-description" name="book_description"></textarea>

    <input type="submit" value="Donate">
</form>

        <?php
        // Display error message if set
        if (isset($error_message)) {
            echo '<div class="error">' . $error_message . '</div>';
        }
        ?>
        <script>
    // Get the form element
    var donateBooksForm = document.getElementById('donate-books-form');

    // Add a submit event listener to the form element
    donateBooksForm.addEventListener('submit', function(event) {
        // Prevent the form from submitting
        event.preventDefault();

        // Validate the form data
        if (validateForm()) {
            // Submit the form
            donateBooksForm.submit();
        }
    });

    // Function to validate the form data
    function validateForm() {
    // Get the form fields
    var bookTitle = document.getElementById('book-title');
    var bookAuthor = document.getElementById('book-author');
    var bookIsbn = document.getElementById('book-isbn');
    var bookCondition = document.getElementById('book-condition');
    var bookClass = document.getElementById('book-class');
    var bookSubject = document.getElementById('book-subject');

    // Validate the book title
    if (bookTitle.value.trim() == '') {
        alert('Please enter a book title.');
        bookTitle.focus();
        return false;
    }

    // Validate the book author
    if (bookAuthor.value.trim() == '') {
        alert('Please enter a book author.');
        bookAuthor.focus();
        return false;
    }

    // Validate the book ISBN
    if (bookIsbn.value.trim() == '') {
        alert('Please enter a book ISBN.');
        bookIsbn.focus();
        return false;
    }

    // Validate the book condition
    if (bookCondition.value == '') {
        alert('Please select a book condition.');
        bookCondition.focus();
        return false;
    }

    // Validate the book class
    if (bookClass.value == '') {
        alert('Please select a book class.');
        bookClass.focus();
        return false;
    }

    // Validate the book subject
    if (bookSubject.value == '') {
        alert('Please select a book subject.');
        bookSubject.focus();
        return false;
    }

    // If all validations pass, return true
    return true;
}
</script>
    </div>
</body>
</html>