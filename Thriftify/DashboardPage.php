<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "database";

$con = new mysqli($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

function isUserLoggedIn() {
    return isset($_SESSION["user_id"]);
}

$userQuery = $con->query("SELECT * FROM users");
$listingQuery = $con->query("SELECT * FROM listings");

$totalUsers = $userQuery->num_rows;
$totalListings = $listingQuery->num_rows;

$userId = $_SESSION["user_id"];
$userListingQuery = $con->query("SELECT * FROM listings WHERE user_id = $userId");
$totalUserListings = $userListingQuery->num_rows;

$totalRevenue = 0;
while ($row = $listingQuery->fetch_assoc()) {
    $totalRevenue += $row['product_price'];
}

$userRevenue = 0;
while ($row = $userListingQuery->fetch_assoc()) {
    $userRevenue += $row['product_price'];
}

function renderUserDropdown() {
    if (isset($_SESSION["user_name"])) {
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
    <title>Dashboard</title>
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
        .seller-picture {
            width: 250px;
            height: 250px;
            object-fit: cover;
        }
    </style>
</head>
<body style="font-family: Bebas Neue;">

<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" style="background: #1e1e1e;border-color: #1e1e1e; border-top-color: #1e1e1e; border-left-color: #1e1e1e;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="DashboardPage.php"><span class="fs-1">Thriftify</span></a>
        <div class="btn-group" role="group">
            <?php if (isUserLoggedIn()): ?>
                <?php renderUserDropdown(); ?>
                
                <?php
                    $currentPage = basename($_SERVER['PHP_SELF']);
                    if ($currentPage == 'DashboardPage.php') {
                        echo '<a href="NewListing.php" class="btn btn-primary btn-lg ms-md-2" role="button" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">New Listing</a>';
                    }
                ?>
                
            <?php else: ?>
                <?php renderGuestButtons(); ?>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h1>Thriftify Dashboard</h1>
    <section class="container mt-5">
    <h2>Seller Profile</h2>
    <div class="row">
        <div class="col-md-3">
            <img src="public/blank-profile-picture_663cf32d51d83.png" alt="Seller Picture" class="img-fluid rounded-circle seller-picture">
        </div>
        <div class="col-md-9">
            <h3><?php echo $_SESSION["user_name"] ?></h3>
            <div class="mb-3">
                <span class="fw-bold">Ratings:</span>
                <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            </div>
            <div>
                <h4>Reviews:</h4>
                <p>Great seller! Fast shipping and excellent communication.</p>
                <p>Highly recommended. Will buy again from this seller.</p>
            </div>
        </div>
    </div>
</section>

    <div class="row mt-4">
        <h2>Insights</h2>
        <div class="col-md-4">
        <a href="AllUsers.php" style="text-decoration: none; text-color: #1e1e1e;">
            <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #1E1E1E;">Total Users</h5>
                        <p class="card-text" style="color: #1E1E1E;"><?php echo $totalUsers; ?></p>
                    </div>
            </div>
        </a>
        </div>
        <div class="col-md-4">
            <a href="TotalListings.php" style="text-decoration: none; text-color: #1e1e1e;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #1E1E1E;">Total Listings</h5>
                        <p class="card-text" style="color: #1E1E1E;"><?php echo $totalUserListings; ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">PHP <?php echo $userRevenue; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Average Revenue per Listing</h5>
                    <p class="card-text">PHP <?php echo $totalListings > 0 ? round($userRevenue / $totalUserListings, 2) : 0; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Average Listings per User</h5>
                    <p class="card-text"><?php echo $totalUsers > 0 ? round($totalUserListings / $totalUsers, 2) : 0; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-4 py-xl-5">
    <div class="container">
        <h2>Analytics</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <canvas id="analyticsChart" style="max-width: 100%;"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="engagementChart" style="max-width: 100%;"></canvas>
            </div>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function fetchAnalyticsData() {
        var analyticsData = {
            labels: ['Jan','Feb','Mar','Apr','May'],
            datasets: [{
                label: 'Number of Listings',
                data: [15, 13, 16, 8, <?php echo $totalUserListings; ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        renderAnalyticsChart(analyticsData);
    }

    function renderAnalyticsChart(data) {
        var ctx = document.getElementById('analyticsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'x', 
                aspectRatio: 5, 
                responsive: true,
                maintainAspectRatio: true, 
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchAnalyticsData();
    });
</script>
<script>
    function fetchEngagementData() {
        var engagementData = {
            labels: ['Jan','Feb','Mar','Apr','May'],
            datasets: [{
                label: 'Engagements',
                data: [50, 30, 60, 18, 10], 
                fill: false,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        };

        renderEngagementChart(engagementData);
    }

    function renderEngagementChart(data) {
        var ctx = document.getElementById('engagementChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                aspectRatio: 5,
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchEngagementData();
    });
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
<script src="assets/js/Simple-Slider.js"></script>
</body>
</html>