<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "database";

$con = new MySQLi($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $listing_id = $_POST['listing_id'];

    // Insert into wishlist
    $insertQuery = "INSERT INTO wishlist (user_id, listing_id) VALUES ('$user_id', '$listing_id')";
    $insertResult = $con->query($insertQuery);

    if ($insertResult) {
        // Handle success (e.g., redirect to wishlist page)
        header("Location: Wishlist.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . $con->error;
    }
}

// Close the database connection
$con->close();
?>
