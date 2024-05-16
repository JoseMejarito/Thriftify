<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

$host = "localhost";
$username = "root";
$password = "";
$database = "database";

$con = new MySQLi($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// ...

// Check if listing_id is set and valid
if (isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];

    // Delete related wishlist entries
    $deleteWishlistQuery = "DELETE FROM wishlist WHERE listing_id = ?";
    $stmtWishlist = $con->prepare($deleteWishlistQuery);

    if ($stmtWishlist) {
        $stmtWishlist->bind_param("i", $listing_id);
        $stmtWishlist->execute();
        $stmtWishlist->close();
    } else {
        error_log("Error preparing wishlist deletion statement: " . $con->error);
        echo "An error occurred. Please try again later.";
        exit();
    }

    // Delete listing from the database using prepared statement
    $deleteQuery = "DELETE FROM listings WHERE listing_id = ?";
    $stmt = $con->prepare($deleteQuery);

    if ($stmt) {
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            // Redirect to the previous page after deletion
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            // Log the error instead of displaying it to the user
            error_log("Error deleting listing: " . $stmt->error);
            echo "An error occurred. Please try again later.";
        }

        $stmt->close();
    } else {
        // Log the error instead of displaying it to the user
        error_log("Error preparing statement: " . $con->error);
        echo "An error occurred. Please try again later.";
    }
} else {
    echo "Invalid listing ID.";
    exit();
}

?>
