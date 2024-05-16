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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Create a new Listing</title>
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

<body style="font-family: 'Bebas Neue', serif;">
<?php
    function isUserLoggedIn() {
        return isset($_SESSION["user_id"]);
    }

    function renderUserDropdown() {
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
    }

    function renderGuestButtons() {
        echo '<a class="btn btn-primary btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="login.php" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Sign In</a>
            <a class="btn btn-primary btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="RegisterForm.html" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Register</a>';
    }
    ?>

    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" style="border-color: #1e1e1e; border-top-color: rgb(33,37,41); border-left-color: 37;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="HomePage.php"><span class="fs-1">Thriftify</span></a>
            <div class="btn-group" role="group">
                <?php if (isUserLoggedIn()): ?>
                    <?php renderUserDropdown(); ?>
                <?php else: ?>
                    <?php renderGuestButtons(); ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <section id="NewListingSection">
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Create a New Listing</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <form action="process_new_listing.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Product Description</label>
                            <textarea class="form-control" id="productDescription" name="productDescription" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Product Price (PHP)</label>
                            <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" selected disabled>Select Category</option>
                                <option value="1">Men</option>
                                <option value="2">Women</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="core" class="form-label">Core</label>
                            <select class="form-select" id="core" name="core" required>
                                <option value="" selected disabled>Select Core</option>
                                <option value="1">Archive</option>
                                <option value="2">Avant Garde</option>
                                <option value="3">Designer</option>
                                <option value="4">Gorp Core</option>
                                <option value="5">Vintage</option>
                                <option value="6">Y2K</option>
                                <option value="7">Others</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Upload Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
                        </div>
                        <button type="submit" class="btn text-white" data-bss-hover-animate="pulse" style="background-color: #1e1e1e;">Create Listing</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>
</html>