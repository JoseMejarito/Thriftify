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

// Check if item ID is provided in the URL
if (isset($_GET['listing_id'])) {
    $item_id = $_GET['listing_id'];

    // Fetch item details from the database based on the item ID
    $query = "SELECT * FROM listings WHERE listing_id = $item_id";
    $result = $con->query($query);

    // Check if the item exists
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        // Redirect to a 404 page or handle the case when the item doesn't exist
        header("Location: 404.php");
        exit();
    }
} else {
    // Redirect to a 404 page or handle the case when no item ID is provided
    header("Location: 404.php");
    exit();
}

function getCategoryName($category) {
    switch ($category) {
        case 1:
            return 'Men';
        case 2:
            return 'Women';
        case 3:
            return 'Others';
        default:
            return 'Unknown';
    }
}

function getCoreName($core) {
    switch ($core) {
        case 1:
            return 'Archive';
        case 2:
            return 'Avant Garde';
        case 3:
            return 'Designer';
        case 4:
            return 'Gorp Core';
        case 5:
            return 'Vintage';
        case 6:
            return 'Y2K';
        case 7:
            return 'Others';
        default:
            return 'Unknown';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $item['product_name']; ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-Dark.css">
    <link rel="stylesheet" href="assets/css/Pretty-Login-Form.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="assets/css/Product-Details.css">
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
                <button class="btn btn-dark dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px; z-index: 2;"> 
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
        echo '<a class="btn btn-dark btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="login.php" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Sign In</a>
            <a class="btn btn-dark btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="RegisterForm.html" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Register</a>';
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
    <!-- Header Section -->
    <header class="py-4 py-xl-5">
        <div class="container">
            <!-- You can customize the header section based on your needs -->
            <h1><?php echo $item['product_name']; ?></h1>
            <!-- Display other item details as needed -->
        </div>
    </header>

    <!-- Main Section -->
    <section class="py-4 py-xl-5">
        <div class="container">
            <!-- You can customize the main section based on your needs -->
            <div class="row">
                <div class="col-md-6">
                    <img src="<?php echo $item['image_path']; ?>" alt="<?php echo $item['product_name']; ?>" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <!-- Display other item details, such as description, price, etc. -->
                    <p>Description: <?php echo $item['product_description']; ?></p>
                    <p>Price: PHP <?php echo $item['product_price']; ?></p>
                    <p>Seller: <a href="ProfilePage.php?user_id=<?php echo $item['user_id']; ?>"><?php echo $item['seller_name']; ?></a></p>
                    <p>Location: <?php echo $item['location']; ?></p>
                    <p>Category: <?php echo getCategoryName($item['category']); ?></p>
                    <p>Core: <?php echo getCoreName($item['core']); ?></p>
                    <!-- Add more details as needed -->

                    <!-- Button groups based on user status -->
                    <?php if (isUserLoggedIn()): ?>
                        <?php if ($_SESSION["user_id"] != $item['user_id']): ?>
                            <!-- User is logged in but not the seller -->
                            <div class="btn-group mt-3" role="group">
                                <button class="btn btn-dark me-2" type="button" onclick="addToWishlist(<?php echo $item['listing_id']; ?>);">Add to Wishlist</button>
                                <a href="send_message.php?user_id=<?php echo $item['user_id']; ?>" class="btn btn-dark">Message Seller</a>
                            </div>
                        <?php elseif ($_SESSION["user_id"] == $item['user_id']): ?>
                            <!-- User is the seller -->
                            <div class="btn-group mt-3" role="group">
                                <a href="edit_listing.php?listing_id=<?php echo $item['listing_id']; ?>" class="btn btn-dark">Edit</a>
                                <a href="delete_listing.php?listing_id=<?php echo $item['listing_id']; ?>" class="btn btn-dark" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>




    <!-- Footer Section -->
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

    <!-- Scripts -->
    <script>
        function addToWishlist(listingId) {
            // AJAX request to add the listing to the wishlist
            $.ajax({
                type: "POST",
                url: "add_to_wishlist.php",
                data: {
                    listing_id: listingId
                },
                success: function (response) {
                    if (response === "success") {
                        alert("Listing added to wishlist!");
                    } else if (response === "already_added") {
                        alert("Listing is already in your wishlist!");
                    } else {
                        alert("Error adding to wishlist. Please try again.");
                    }
                },
                error: function () {
                    alert("Error adding to wishlist. Please try again.");
                }
            });
        }
    </script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>
</html>