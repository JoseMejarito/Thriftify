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

// Check if listing_id is set and valid
if (isset($_GET['listing_id']) && is_numeric($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];

    // Fetch listing details from the database
    $query = "SELECT * FROM listings WHERE listing_id = $listing_id";
    $result = $con->query($query);

    if ($result->num_rows == 1) {
        $listing = $result->fetch_assoc();
    } else {
        echo "Listing not found.";
        exit();
    }
} else {
    echo "Invalid listing ID.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated data from the form
    $productName = $_POST["productName"];
    $productDescription = $_POST["productDescription"];
    $productPrice = $_POST["productPrice"];
    $location = $_POST["location"];
    $category = $_POST["category"];
    $core = $_POST["core"];

    // Update data in the database
    $updateQuery = "UPDATE listings SET 
                    product_name = '$productName',
                    product_description = '$productDescription',
                    product_price = $productPrice,
                    location = '$location',
                    category = $category,
                    core = $core
                    WHERE listing_id = $listing_id";

    $updateResult = $con->query($updateQuery);

    // Redirect to a success page or handle errors accordingly
    if ($updateResult) {
        header("Location: MyListings.php");
        exit();
    } else {
        echo "Error updating listing: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Edit Listing</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-Dark.css">
    <link rel="stylesheet" href="assets/css/Pretty-Login-Form.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="assets/css/Projects-Grid-Horizontal.css">
    <link rel="stylesheet" href="assets/css/responsive-navbar.css">
    <link rel="stylesheet" href="assets/css/Simple-Slider.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="font-family: 'Bebas Neue'">
    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" style="border-color: #1e1e1e; border-top-color: rgb(33,37,41); border-left-color: 37;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="HomePage.php"><span class="fs-1">Thriftify</span></a>
            <div class="btn-group" role="group">
                <?php
                if (isset($_SESSION["user_id"])) {
                    echo '<div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px; z-index: 2;"> 
                                ' . $_SESSION["user_name"] . '
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown" style="z-index: 2;">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="MyListings.php">My Listings</a></li>
                                <li><a class="dropdown-item" href="Wishlist.php">Wishlist</a></li>
                                <li><a class="dropdown-item" href="messages.php">Messages</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>';
                        $current_page = basename($_SERVER['PHP_SELF']);
                        if ($current_page == 'MyListings.php') {
                            echo '<a href="NewListing.php" class="btn btn-primary ms-md-2" role="button" data-bss-hover-animate="pulse" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">New Listing</a>';
                        }
                } else {
                    echo '<a class="btn btn-primary btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="login.php" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Sign In</a>
                        <a class="btn btn-primary btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="RegisterForm.html" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Register</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <div class="container py-4 py-xl-5">
        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2>Edit Listing</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <form action="edit_listing.php?listing_id=<?php echo $listing_id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $listing['product_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Product Description</label>
                        <textarea class="form-control" id="productDescription" name="productDescription" required><?php echo $listing['product_description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Product Price (PHP)</label>
                        <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" value="<?php echo $listing['product_price']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $listing['location']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" selected disabled>Select Category</option>
                            <option value="1" <?php echo ($listing['category'] == 1) ? 'selected' : ''; ?>>Men</option>
                            <option value="2" <?php echo ($listing['category'] == 2) ? 'selected' : ''; ?>>Women</option>
                            <option value="3" <?php echo ($listing['category'] == 3) ? 'selected' : ''; ?>>Others</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="core" class="form-label">Core</label>
                        <select class="form-select" id="core" name="core" required>
                            <option value="" selected disabled>Select Core</option>
                            <option value="1" <?php echo ($listing['core'] == 1) ? 'selected' : ''; ?>>Archive</option>
                            <option value="2" <?php echo ($listing['core'] == 2) ? 'selected' : ''; ?>>Avant Garde</option>
                            <option value="3" <?php echo ($listing['core'] == 3) ? 'selected' : ''; ?>>Designer</option>
                            <option value="4" <?php echo ($listing['core'] == 4) ? 'selected' : ''; ?>>Gorp Core</option>
                            <option value="5" <?php echo ($listing['core'] == 5) ? 'selected' : ''; ?>>Vintage</option>
                            <option value="6" <?php echo ($listing['core'] == 6) ? 'selected' : ''; ?>>Y2K</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
        <section class="py-4 py-xl-5">
        <div class="container">
            <div class="border rounded border-0 d-flex flex-column justify-content-center align-items-center p-4 py-5" style="height: 500px;background: url(&quot;assets/img/dior-fall-mens-2020-campaign-6900x687-1@2x.png&quot;) center / cover;"></div>
        </div>
        <footer class="text-center py-4">
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-3">
                    <div class="col w-100">
                        <ul class="list-inline my-2">
                            <li class="list-inline-item"><a class="link-secondary btn" type="button" href="PrivacyPolicyPage.php">Privacy Policy</a></li>
                            <li class="list-inline-item"><a class="link-secondary btn" type="button" href="TermsOfUsePage.php">Terms of Use</a></li>
                            <li class="list-inline-item"><a class="link-secondary btn" type="button" href="ContactPage.php">Contact</a></li>
                            <li class="list-inline-item"><a class="link-secondary btn" type="button" href="AboutPage.php">About</a></li>
                        </ul>
                    </div>
                    <div class="col offset-lg-4">
                        <p class="text-muted my-2">Copyright&nbsp;© 2023 Thriftify</p>
                    </div>
                </div>
            </div>
        </footer>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
    </div>
</body>

</html>
