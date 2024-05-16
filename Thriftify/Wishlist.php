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

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    // Fetch wishlist items based on the user's ID
    $wishlistQuery = "SELECT w.*, l.product_name, l.product_description, l.product_price, l.location, l.image_path, l.seller_name,l.category,l.core
                      FROM wishlist w
                      INNER JOIN listings l ON w.listing_id = l.listing_id
                      WHERE w.user_id = '$user_id'";
    $wishlistResult = $con->query($wishlistQuery);

    if ($wishlistResult) {
        $wishlistItems = $wishlistResult->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Error: " . $wishlistQuery . "<br>" . $con->error;
    }
} else {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
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
    <title>Wishlist</title>
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
    <section>
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Wishlist</h2>
                </div>
            </div>

            <!-- Check if wishlist is empty -->
            <?php if (empty($wishlistItems)) : ?>
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p>Nothing to show here</p>
                </div>
            <?php else : ?>
                <!-- Loop through wishlist items -->
                <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                <?php foreach ($wishlistItems as $wishlistItem) : ?>
                    <div class="col" onclick="redirectToItemPage(<?= $wishlistItem['listing_id'] ?>)">
                        <div class="card">
                            <img class="card-img-top w-100 d-block fit-cover h-100" style="height: 200px;" src="<?= $wishlistItem['image_path'] ?>">
                            <div class="card-body p-4">
                                <p class="text-primary card-text mb-0">PHP <?= $wishlistItem['product_price'] ?></p>
                                <h4 class="card-title"><?= $wishlistItem['product_name'] ?></h4>
                                <p class="card-text"><?= $wishlistItem['product_description'] ?></p>
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-bold mb-0"><?= $wishlistItem['seller_name'] ?></p>
                                        <p class="text-muted mb-0"><?= $wishlistItem['location'] ?></p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p>Category: <a><?= getCategoryName($wishlistItem["category"]) ?></a></p>
                                    <p>Core: <a><?= getCoreName($wishlistItem["core"]) ?></a></p>
                                </div>
                                <!-- Add the "Remove from Wishlist" button -->
                                <div class="mt-3">
                                    <button class="btn btn-dark" type="button" onclick="removeFromWishlist(<?= $wishlistItem['listing_id'] ?>);">Remove from Wishlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <script>
                function redirectToItemPage(listingId) {
                    window.location.href = 'ItemPage.php?listing_id=' + listingId;
                }
            </script>
            <?php endif; ?>
        </div>
    </section>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    function removeFromWishlist(listingId) {
        // Send an asynchronous request to remove_from_wishlist.php
        $.ajax({
            type: "POST",
            url: "remove_from_wishlist.php",
            data: { listing_id: listingId },
            success: function(response) {
                if (response === "success") {
                    // The item was successfully removed
                    alert("Item removed from wishlist!");
                    // Reload the page to reflect the removal
                    location.reload();
                } else {
                    // Something went wrong
                    alert("Failed to remove item from wishlist.");
                }
            },
            error: function() {
                // Error handling
                alert("Error during AJAX request");
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