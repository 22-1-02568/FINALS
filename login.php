<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: tropical.php");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tropical";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = null;

// User login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are correct
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username; // Store the logged-in user's username in the session
        header("Location: tropical.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="post" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
    <p>Don't have an account yet? <a href="register.php">Register</a></p>
</body>
</html>
