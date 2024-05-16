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

    // Remove the listing from the wishlist
    $removeFromWishlistQuery = "DELETE FROM wishlist WHERE user_id = $user_id AND listing_id = $listing_id";
    $con->query($removeFromWishlistQuery);

    // Close the database connection
    $con->close();

    echo "success";
} else {
    echo "error";
}
?>
