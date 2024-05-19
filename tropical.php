<!DOCTYPE html>
<html>
<head>
    <title>Tropical Fusion Delights by Concepcion</title>
    <style>
        /* Basic styling for body and container elements */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .menu {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        /* Styling for form inputs and submit button */
        input[type="number"], input[type="submit"], input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tropical Fusion Delights by Concepcion</h1>
        <div class="menu">
            <h2>Menu</h2>
            <ul>
                <li>Halo-Halo - PHP 50</li>
                <li>Mais Con Yelo - PHP 40</li>
                <li>Saging Con Yelo - PHP 40</li>
                <li>Sago't Gulaman - PHP 20</li>
                <li>Buko Juice - PHP 20</li>
            </ul>
        </div>
        <?php
        session_start(); // Start the session to manage user login state

        // Check if the user is not logged in
        if (!isset($_SESSION['username'])) {
            // Display login form if the user is not logged in
            echo '<h3>Login or Register</h3>';
            echo '<form method="post" action="login.php">';
            echo '<label for="username">Username:</label><br>';
            echo '<input type="text" name="username" id="username" required><br>';
            echo '<label for="password">Password:</label><br>';
            echo '<input type="password" name="password" id="password" required><br>';
            echo '<input type="submit" name="login" value="Login">';
            echo '</form>';
            echo '<p>Don\'t have an account yet? <a href="register.php">Register</a></p>';
        } else {
            // Display order form if the user is logged in
            echo "<h2>Welcome, {$_SESSION['username']}!</h2>";
            echo '<form method="post" action="receipt.php">';
            echo '<label for="item">Select Item:</label>';
            echo '<select id="item" name="item">';
            echo '<option value="50">Halo-Halo - PHP 50</option>';
            echo '<option value="40">Mais Con Yelo - PHP 40</option>';
            echo '<option value="40">Saging Con Yelo - PHP 40</option>';
            echo '<option value="20">Sago\'t Gulaman - PHP 20</option>';
            echo '<option value="20">Buko Juice - PHP 20</option>';
            echo '</select><br>';
            echo '<label for="quantity">Quantity:</label>';
            echo '<input type="number" id="quantity" name="quantity" min="1" required><br>';
            echo '<label for="payment">Payment:</label>';
            echo '<input type="number" id="payment" name="payment" min="0" required><br>';
            echo '<input type="submit" value="Submit">';
            echo '<a href="logout.php">Logout</a>';
            echo '</form>';
        }
        ?>
    </div>
</body>
</html>
