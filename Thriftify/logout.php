<?php
session_start(); 

// Check if the user is already logged in
if (isset($_SESSION["user_id"])) {
    $_SESSION = array();

    // Destroy the session
    session_destroy();
}

// Redirect the user to the login page
header("Location: login.php");
exit();
?>