<?php
session_start(); // Start the session to manage user login state

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // Redirect to the main page if the user is already logged in
    header("Location: tropical.php");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tropical";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Handle connection error
}

$error = null; // Initialize the error variable

// User registration process
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "Username already taken. Please choose a different one."; // Username already exists
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username; // Store the logged-in user's username in the session
            header("Location: tropical.php"); // Redirect to the main page
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error; // Handle query error
        }
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p> <!-- Display the error message if any -->
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
