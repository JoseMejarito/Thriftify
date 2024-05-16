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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["productName"];
    $productDescription = $_POST["productDescription"];
    $productPrice = $_POST["productPrice"];
    $location = $_POST["location"];
    $category = $_POST["category"];
    $core = $_POST["core"];

    // Handle image upload
    $uploadDir = "public/";
    $uploadedImages = [];

    foreach ($_FILES["images"]["name"] as $key => $value) {
        $temp = $_FILES["images"]["tmp_name"][$key];
        
        // Modify the filename to ensure uniqueness
        $filename = pathinfo($value, PATHINFO_FILENAME);
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        $uniqueFilename = $filename . '_' . uniqid() . '.' . $extension;
    
        $uploadPath = $uploadDir . $uniqueFilename;
    
        move_uploaded_file($temp, $uploadPath);
        $uploadedImages[] = $uploadPath;
    }    

    $user_id = $_SESSION['user_id'];

    // Fetch seller_name from users table
    $sellerNameQuery = "SELECT name as user_name FROM users WHERE user_id = ?";
    $stmt = $con->prepare($sellerNameQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $sellerNameResult = $stmt->get_result();
    $stmt->close();

    if ($sellerNameResult->num_rows > 0) {
        $sellerName = $sellerNameResult->fetch_assoc()["user_name"];

        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO listings (user_id, product_name, product_description, product_price, location, category, core, image_path, seller_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssisss", $user_id, $productName, $productDescription, $productPrice, $location, $category, $core, implode(",", $uploadedImages), $sellerName);

        if ($stmt->execute()) {
            header("Location: MyListings.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: User not found";
    }

    // Close the database connection
    $con->close();
}
?>
