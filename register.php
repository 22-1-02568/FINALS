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

// User registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "Username already taken. Please choose a different one.";
    } else {
        // Insert the new user into the database with the hashed password
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username; // Store the logged-in user's username in the session
            header("Location: tropical.php");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="post" action="register.php">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" name="register" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
