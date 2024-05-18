<?php
session_start();
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']); // Reset the logged-in user's username
}
header("Location: tropical.php");
exit();
?>
