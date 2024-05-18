<?php
session_start();
if (isset($_POST['register']) || isset($_POST['login'])) {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tropical"; // Change the database name here

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // User registration
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username already exists
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error = "Username already taken. Please choose a different one.";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

            if ($conn->query($sql) === TRUE) {
                $output = "Registration successful! You can now log in.";
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // User login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username and password are correct
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username; // Store the logged-in user's username in the session
        } else {
            $error = "Invalid username or password.";
        }
    }

    $conn->close();
}

// Logout logic
if (isset($_GET['logout']) && isset($_SESSION['username'])) {
    unset($_SESSION['username']); // Reset the logged-in user's username
    header("Location: tropical.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tropical Fusion Delights by Concepcion</title>
    <style>
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
        label {
            font-weight: bold;
        }
        input[type="number"], input[type="submit"] {
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
        .receipt {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tropical Fusion Delights by Concepcion</h1>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<h2>Welcome, {$_SESSION['username']}!</h2>";
            echo '<a href="tropical.php">Go back to place a new order</a>';
        } else {
            echo '<h2>Login or Register to place an order</h2>';
            echo '<form method="post" action="receipt.php">';
            echo '<label for="username">Username:</label><br>';
            echo '<input type="text" name="username" id="username" required><br>';
            echo '<label for="password">Password:</label><br>';
            echo '<input type="password" name="password" id="password" required><br>';
            echo '<input type="submit" name="login" value="Login">';
            echo '<input type="submit" name="register" value="Register">';
            echo '</form>';
        }
        ?>
        <?php
        if (isset($_SESSION['username']) && isset($_POST['item'])) {
            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "tropical"; // Change the database name here

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $item_price = $_POST["item"];
            $quantity = $_POST["quantity"];
            $payment = $_POST["payment"];
            $total = $item_price * $quantity;
            $change = $payment - $total;
            $item_name = "";
            switch ($item_price) {
                case 50:
                    $item_name = "Halo-Halo - PHP 50";
                    break;
                case 40:
                    $item_name = "Mais Con Yelo - PHP 40";
                    break;
                case 20:
                    $item_name = "Sago't Gulaman - PHP 20 or Buko Juice - PHP 20";
                    break;
                default:
                    $item_name = "Unknown Item";
                    break;
            }
            echo "<div class='receipt'>";
            echo "<h2>Receipt</h2>";
            echo "<p>Item: $item_name</p>";
            echo "<p>Quantity: $quantity</p>";
            echo "<p>Total: PHP $total</p>";
            echo "<p>Payment: PHP $payment</p>";
            if ($change >= 0) {
                echo "<p>Change: PHP $change</p>";
            } else {
                echo "<p>Insufficient payment!</p>";
            }
            echo "</div>";

            $conn->close();
        }
        ?>
        <?php if (isset($_SESSION['username'])) {
            echo '<a href="logout.php">Logout</a>';
        } ?>
    </div>
</body>
</html>