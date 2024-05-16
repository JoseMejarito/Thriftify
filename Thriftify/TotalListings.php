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

function getUserListings($con, $userId) {
    $listings = array();

    $query = "SELECT * FROM listings WHERE user_id = $userId";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add status column to the $row array
            $row['status'] = $row['Sold'] ? 'Sold' : 'Available';
            $listings[] = $row;
        }
    }

    return $listings;
}

function renderUserDropdown() {
    if (isset($_SESSION["user_name"])) {
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
}

function renderGuestButtons() {
    echo '<a class="btn btn-primary btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="login.php" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Sign In</a>
          <a class="btn btn-primary btn-lg ms-md-2" role="button" data-bss-hover-animate="pulse" href="RegisterForm.html" style="background: #1e1e1e;border-color: var(--bs-white);font-size: 24px;">Register</a>';
}

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["user_id"];

$userListings = getUserListings($con, $userId);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings</title>
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
<body style="font-family: Bebas Neue;">

    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" style="background: #1e1e1e;border-color: #1e1e1e; border-top-color: #1e1e1e; border-left-color: #1e1e1e;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="DashboardPage.php"><span class="fs-1">Thriftify</span></a>
            <div class="btn-group" role="group">
                <?php if (isset($_SESSION["user_name"])): ?>
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

    <div class="container mt-4">
        <h2><?php echo $_SESSION["user_name"]; ?>'s Listings</h2>
            <div class="mb-3">
                <label for="sortSelect" class="form-label">Sort By:</label>
                <select id="sortSelect" class="form-select" onchange="sortTable()">
                    <option value="name">Name</option>
                    <option value="category">Category</option>
                    <option value="core">Core</option>
                    <option value="price">Price</option>
                    <option value="location">Location</option>
                    <option value="popularity">Popularity</option>
                </select>
                <label for="orderBySelect" class="form-label">Order By:</label>
                <select id="orderBySelect" class="form-select" onchange="sortTable()">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
        <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names..">
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Core</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Popularity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userListings as $listing): ?>
                    <tr>
                        <td><?php echo $listing['product_name']; ?></td>
                        <td><?php echo getCategoryName($listing['category']); ?></td>
                        <td><?php echo getCoreName($listing['core']); ?></td>
                        <td><?php echo $listing['product_price']; ?></td>
                        <td><?php echo $listing['location']; ?></td>
                        <td><?php echo $listing['status']; ?></td>
                        <td><?php echo $listing['popularity_score']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            // Set the sorting direction based on the selected option:
            dir = document.getElementById("orderBySelect").value;
            // Find the header index based on the selected option:
            var headerIndex;
            var sortBy = document.getElementById("sortSelect").value;
            switch (sortBy) {
                case "name":
                    headerIndex = 0;
                    break;
                case "category":
                    headerIndex = 1;
                    break;
                case "core":
                    headerIndex = 2;
                    break;
                case "price":
                    headerIndex = 3;
                    break;
                case "location":
                    headerIndex = 4;
                    break;
                case "popularity":
                    headerIndex = 5;
                    break;
            }
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                // Loop through all table rows (except the first, which contains table headers):
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    // Get the two elements you want to compare, one from the current row and one from the next:
                    x = rows[i].getElementsByTagName("td")[headerIndex];
                    y = rows[i + 1].getElementsByTagName("td")[headerIndex];
                    // Check if the two rows should switch place, based on the direction (asc or desc):
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    // If a switch has been marked, make the switch and mark that a switch has been done:
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    // If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again:
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>
</html>
