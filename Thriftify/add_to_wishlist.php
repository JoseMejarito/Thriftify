<?php
session_start();

if (isset($_SESSION["user_id"]) && isset($_POST["listing_id"])) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "database";

    $con = new MySQLi($host, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $user_id = $_SESSION["user_id"];
    $listing_id = $_POST["listing_id"];

    // Check if the listing is not already in the wishlist
    $checkQuery = "SELECT * FROM wishlist WHERE user_id = $user_id AND listing_id = $listing_id";
    $result = $con->query($checkQuery);

    if ($result->num_rows == 0) {
        // Add the listing to the wishlist
        $addToWishlistQuery = "INSERT INTO wishlist (user_id, listing_id) VALUES ($user_id, $listing_id)";
        $con->query($addToWishlistQuery);

        echo "success";
    } else {
        echo "already_added";
    }

    // Close the database connection
    $con->close();
} else {
    echo "error";
}
?>
