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
                <li><a class="dropdown-item" href="DashboardPage.php">Dashboard</a></li>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>HomePage</title>
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
    <style>
        .small-img{
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body style="font-family: Bebas Neue;">
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
    <nav class="navbar navbar-light navbar-expand-md py-3 sticky-top" style="z-index: 1; background: #FFFFFF">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-6" style="border-color: transparent;"><span class="visually-hidden" style="border-style: solid;border-color: var(--bs-gray-900);">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-around" id="navcol-6">
                <ul class="navbar-nav mx-auto" style="font-size: 25px;">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#ShopByCoreSection">Cores</a></li>
                    <li class="nav-item"><a class="nav-link" href="#MenFashionSection">Men's Fashion</a></li>
                    <li class="nav-item"><a class="nav-link" href="#WomenFashionSection">Women's Fashion</a></li>
                    <li class="nav-item"><a class="nav-link" href="#OtherSection">Others</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="BannerHeading" class="py-4 py-xl-5">
        <div class="container">
            <div class="text-white bg-dark border rounded border-0 p-4 p-md-5 h-100 w-100" style="background: url(public/groupshotcximenadelvalle646bde6559c0e-1@2x.png) center / cover, transparent;">
                <h3 class="fw-bold text-white mb-3" style="text-align: center;">The Platform For Personal Style<br>Buy, Sell, Discover Authenticated Pieces<br>From The World's Top Brand</h3>
            </div>
        </div>
    </section>
    <section id="ShopByCoreSection">
        <div class="container py-4 py-xl-5" style="margin-bottom: 0px;">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Shop By Cores</h2>
                </div>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-md-6">
                <div class="col">
                    <a href="ArchiveCorePage.php">
                        <div class="position-relative">
                            <img class="rounded img-fluid d-block w-100 small-img" src="public/helmutlangarchivegqstylespring13-1@2x.png">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white shadow-sm">
                                <h1>Archive</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="AvantGardeCorePage.php">
                        <div class="position-relative">
                            <img class="rounded img-fluid d-block w-100 small-img" src="public/avantgardeimageb7682x1024-1@2x.png">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white shadow-sm">
                                <h1>Avant Garde</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="DesignerCorePage.php">
                        <div class="position-relative">
                            <img class="rounded img-fluid d-block w-100 small-img" src="public/rick-rowens-1@2x.png">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white shadow-sm">
                                <h1>Designer</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="GorpCorePage.php">
                        <div class="position-relative">
                            <img class="rounded img-fluid d-block w-100 small-img" src="public/f0c16aa4998fea7abceb0e6699afe5e9-1@2x.png">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white shadow-sm">
                                <h1>Gorp Core</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="VintageCorePage.php">
                        <div class="position-relative">
                            <img class="rounded img-fluid d-block w-100 small-img" src="public/0e4eab82c4e02393f31a69daada02366.jpg">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white shadow-sm">
                                <h1>Vintage</h1>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="Y2KCorePage.php">
                        <div class="position-relative">
                            <img class="rounded img-fluid d-block w-100 small-img" src="public/faa401cd1989cb52419d09f783363501-1@2x.png">
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white shadow-sm">
                                <h1>Y2K</h1>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="border rounded border-0 d-flex flex-column justify-content-center align-items-center p-4 py-5" style="background: url(public/tomfordfw19stevenklein01730x472-1@2x.png) center / cover;height: 500px;"></div>
        </div>
    </section>
    <section id="MenFashionSection">
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Men's Fashion</h2>
                </div>
            </div>
            <?php
            // Fetch the latest 3 listings in the Men's Fashion category
            $menFashionQuery = "SELECT * FROM listings WHERE category = 1 ORDER BY created_at DESC LIMIT 3";
            $menFashionResult = $con->query($menFashionQuery);

            // Check if there are listings
            if ($menFashionResult->num_rows > 0) {
                // Open the row div outside of the while loop
                echo '<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">';

                while ($row = $menFashionResult->fetch_assoc()) {
                    // Display the listing card
                    echo '<div class="col" type="button" onclick="redirectToItemPage(' . $row["listing_id"] . ')">
                            <div class="card">
                                <img class="card-img-top w-100 d-block fit-cover h-100" style="height: 200px;" src="' . $row["image_path"] . '">
                                <div class="card-body p-4">
                                    <p class="text-primary card-text mb-0">PHP ' . $row["product_price"] . '</p>
                                    <h4 class="card-title">' . $row["product_name"] . '</h4>
                                    <p class="card-text">' . $row["product_description"] . '</p>
                                    <div>
                                        <p class="fw-bold mb-0" type="button">' . $row["seller_name"] . '</p>
                                        <p class="text-muted mb-0">' . $row["location"] . '</p>
                                    </div>';
                    echo '<div class="mt-3">
                            <p>Category: <a>' . getCategoryName($row["category"]) . '</a></p>
                            <p>Core: <a>' . getCoreName($row["core"]) . '</a></p>
                        </div>';

                    // Display appropriate buttons based on user login status
                    if (isset($_SESSION["user_id"])) {
                        // User is logged in
                        $isSeller = ($_SESSION["user_name"] == $row["seller_name"]);

                        if ($isSeller) {
                            // If the user is the seller
                            echo '<div class="mt-3">
                                    <a href="edit_listing.php?listing_id=' . $row["listing_id"] . '" class="btn btn-dark">Edit</a>
                                    <a href="delete_listing.php?listing_id=' . $row["listing_id"] . '" class="btn btn-dark" onclick="return confirm(\'Are you sure you want to delete this listing?\')">Delete</a>
                                </div>';
                        } else {
                            // If the user is not the seller
                            echo '<div class="mt-3">
                                    <button class="btn btn-dark me-2" type="button" onclick="addToWishlist(' . $row["listing_id"] . ');">Add to Wishlist</button>
                                </div>';
                        }
                    }

                    echo '</div>
                        </div>
                    </div>';
                }

                // Close the row div after the while loop ends
                echo '</div>';
            } else {
                // If no listings found
                echo '<div class="col-md-8 col-xl-6 text-center mx-auto">
                        <p>Nothing to show here</p>
                    </div>';
            }
            ?>

            <script>
                function redirectToItemPage(listingId) {
                    console.log('Redirecting to ItemPage with listing_id:', listingId);
                    window.location.href = 'ItemPage.php?listing_id=' + listingId;
                }
            </script>


        </div>
        <div class="text-center"><button class="btn btn-primary" data-bss-hover-animate="pulse" type="button" onclick="window.location.href='MenFashionPage.php';" style="background: #1e1e1e;">See More</button></div>
    </section>
    <section id="WomenFashionSection">
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Women's Fashion</h2>
                </div>
            </div>
            <?php
            // Fetch the latest 3 listings in the Women's Fashion category
            $womenFashionQuery = "SELECT * FROM listings WHERE category = 2 ORDER BY created_at DESC LIMIT 3";
            $womenFashionResult = $con->query($womenFashionQuery);

            // Check if there are listings
            if ($womenFashionResult->num_rows > 0) {
                // Open the row div outside of the while loop
                echo '<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">';

                while ($row = $womenFashionResult->fetch_assoc()) {
                    // Display the listing card
                    echo '<div class="col" type="button" onclick="redirectToItemPage(' . $row["listing_id"] . ')">
                            <div class="card">
                                <img class="card-img-top w-100 d-block fit-cover h-100" style="height: 200px;" src="' . $row["image_path"] . '">
                                <div class="card-body p-4">
                                    <p class="text-primary card-text mb-0">PHP ' . $row["product_price"] . '</p>
                                    <h4 class="card-title">' . $row["product_name"] . '</h4>
                                    <p class="card-text">' . $row["product_description"] . '</p>
                                    <div>
                                        <p class="fw-bold mb-0" type="button">' . $row["seller_name"] . '</p>
                                        <p class="text-muted mb-0">' . $row["location"] . '</p>
                                    </div>';
                    echo '<div class="mt-3">
                            <p>Category: <a>' . getCategoryName($row["category"]) . '</a></p>
                            <p>Core: <a>' . getCoreName($row["core"]) . '</a></p>
                        </div>';

                    // Display appropriate buttons based on user login status
                    if (isset($_SESSION["user_id"])) {
                        // User is logged in
                        $isSeller = ($_SESSION["user_name"] == $row["seller_name"]);

                        if ($isSeller) {
                            // If the user is the seller
                            echo '<div class="mt-3">
                                    <a href="edit_listing.php?listing_id=' . $row["listing_id"] . '" class="btn btn-dark">Edit</a>
                                    <a href="delete_listing.php?listing_id=' . $row["listing_id"] . '" class="btn btn-dark" onclick="return confirm(\'Are you sure you want to delete this listing?\')">Delete</a>
                                </div>';
                        } else {
                            // If the user is not the seller
                            echo '<div class="mt-3">
                                    <button class="btn btn-dark me-2" type="button" onclick="addToWishlist(' . $row["listing_id"] . ');">Add to Wishlist</button>
                                </div>';
                        }
                    }

                    echo '</div>
                        </div>
                    </div>';
                }

                // Close the row div after the while loop ends
                echo '</div>';
            } else {
                // If no listings found
                echo '<div class="col-md-8 col-xl-6 text-center mx-auto">
                        <p>Nothing to show here</p>
                    </div>';
            }
            ?>

            <script>
            function redirectToItemPage(listingId) {
                window.location.href = 'ItemPage.php?listing_id=' . listingId;
            }
            </script>

        </div>
        <div class="text-center"><button class="btn btn-primary" data-bss-hover-animate="pulse" type="button" onclick="window.location.href='WomenFashionPage.php';" style="background: #1e1e1e;">See More</button></div>
    </section>
    <section id="OtherSection">
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2>Others</h2>
                </div>
            </div>
            <?php
            // Fetch the latest 3 listings in the Others category
            $othersQuery = "SELECT * FROM listings WHERE category = 3 ORDER BY created_at DESC LIMIT 3";
            $othersResult = $con->query($othersQuery);

            // Check if there are listings
            if ($othersResult->num_rows > 0) {
                // Open the row div outside of the while loop
                echo '<div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">';

                while ($row = $othersResult->fetch_assoc()) {
                    // Display the listing card
                    echo '<div class="col" type="button" onclick="redirectToItemPage(' . $row["listing_id"] . ')">
                            <div class="card">
                                <img class="card-img-top w-100 d-block fit-cover h-100" style="height: 200px;" src="' . $row["image_path"] . '">
                                <div class="card-body p-4">
                                    <p class="text-primary card-text mb-0">PHP ' . $row["product_price"] . '</p>
                                    <h4 class="card-title">' . $row["product_name"] . '</h4>
                                    <p class="card-text">' . $row["product_description"] . '</p>
                                    <div>
                                        <p class="fw-bold mb-0" type="button">' . $row["seller_name"] . '</p>
                                        <p class="text-muted mb-0">' . $row["location"] . '</p>
                                    </div>';
                    echo '<div class="mt-3">
                            <p>Category: <a>' . getCategoryName($row["category"]) . '</a></p>
                            <p>Core: <a>' . getCoreName($row["core"]) . '</a></p>
                        </div>';

                    // Display appropriate buttons based on user login status
                    if (isset($_SESSION["user_id"])) {
                        // User is logged in
                        $isSeller = ($_SESSION["user_name"] == $row["seller_name"]);

                        if ($isSeller) {
                            // If the user is the seller
                            echo '<div class="mt-3">
                                    <a href="edit_listing.php?listing_id=' . $row["listing_id"] . '" class="btn btn-dark">Edit</a>
                                    <a href="delete_listing.php?listing_id=' . $row["listing_id"] . '" class="btn btn-dark" onclick="return confirm(\'Are you sure you want to delete this listing?\')">Delete</a>
                                </div>';
                        } else {
                            // If the user is not the seller
                            echo '<div class="mt-3">
                                    <button class="btn btn-dark me-2" type="button" onclick="addToWishlist(' . $row["listing_id"] . ');">Add to Wishlist</button>
                                </div>';
                        }
                    }

                    echo '</div>
                        </div>
                    </div>';
                }

                // Close the row div after the while loop ends
                echo '</div>';
            } else {
                // If no listings found
                echo '<div class="col-md-8 col-xl-6 text-center mx-auto">
                        <p>Nothing to show here</p>
                    </div>';
            }
            ?>

            <script>
            function redirectToItemPage(listingId) {
                window.location.href = 'ItemPage.php?listing_id=' . listingId;
            }
            </script>
        </div>
        <div class="text-center"><button class="btn btn-primary" data-bss-hover-animate="pulse" type="button" onclick="window.location.href='OthersPage.php';" style="background: #1e1e1e;">See More</button></div>
    </section>
    <section class="py-4 py-xl-5">
        <div class="container">
            <div class="border rounded border-0 d-flex flex-column justify-content-center align-items-center p-4 py-5" style="height: 500px;background: url(public/dior-fall-mens-2020-campaign-6900x687-1@2x.png) center / cover;"></div>
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
    <script>
        function addToWishlist(listingId) {
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
    <script>
    function redirectToItemPage(listingId) {
        console.log('Redirecting to ItemPage with listing_id:', listingId);
        window.location.href = 'ItemPage.php?listing_id=' + listingId;
    }
    </script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>
</html>