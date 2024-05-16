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
    <title>Terms of Use</title>
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
    <div class="container py-4 py-xl-5">
        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 text-center mx-auto w-100">
                <h2>Terms Of Use</h2>
                <p class="w-lg-50">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vitae justo eget magna fermentum iaculis eu non diam phasellus. Rhoncus est pellentesque elit ullamcorper. Leo urna molestie at elementum eu facilisis sed. Tortor posuere ac ut consequat semper viverra. Vitae tortor condimentum lacinia quis vel eros. Quis viverra nibh cras pulvinar mattis nunc sed blandit. In pellentesque massa placerat duis ultricies lacus sed turpis tincidunt. Elit ut aliquam purus sit amet luctus venenatis lectus. Rutrum tellus pellentesque eu tincidunt tortor. Donec ultrices tincidunt arcu non sodales neque sodales ut etiam. Et egestas quis ipsum suspendisse ultrices gravida dictum fusce. Cursus risus at ultrices mi tempus.<br><br>Faucibus vitae aliquet nec ullamcorper sit amet risus nullam. Gravida cum sociis natoque penatibus et magnis. Tristique risus nec feugiat in. Enim tortor at auctor urna nunc id cursus. Risus ultricies tristique nulla aliquet enim tortor at auctor urna. Ac orci phasellus egestas tellus rutrum tellus pellentesque. Morbi leo urna molestie at. Sapien nec sagittis aliquam malesuada bibendum arcu. A cras semper auctor neque. Augue interdum velit euismod in pellentesque massa placerat duis. Sagittis aliquam malesuada bibendum arcu vitae elementum. Sed vulputate mi sit amet mauris commodo quis. Ullamcorper malesuada proin libero nunc. Adipiscing at in tellus integer. Neque volutpat ac tincidunt vitae semper quis. In iaculis nunc sed augue lacus viverra vitae congue eu.<br><br>Purus in massa tempor nec feugiat. Nunc id cursus metus aliquam eleifend mi. Nulla at volutpat diam ut venenatis. Nunc sed blandit libero volutpat. Tortor condimentum lacinia quis vel eros donec ac. Est placerat in egestas erat imperdiet sed. In mollis nunc sed id semper risus in. A iaculis at erat pellentesque adipiscing commodo elit at imperdiet. Dictum non consectetur a erat. Purus semper eget duis at tellus at urna condimentum.<br><br>Ut sem viverra aliquet eget sit. Risus sed vulputate odio ut enim blandit volutpat. Sollicitudin tempor id eu nisl. Ac turpis egestas maecenas pharetra convallis posuere morbi leo urna. Eget dolor morbi non arcu risus. Odio facilisis mauris sit amet. Sed id semper risus in hendrerit. Diam in arcu cursus euismod quis viverra nibh cras. Tellus molestie nunc non blandit massa enim nec dui nunc. Eu ultrices vitae auctor eu. Ut faucibus pulvinar elementum integer enim. Dis parturient montes nascetur ridiculus mus mauris vitae. Egestas diam in arcu cursus euismod quis viverra. Bibendum ut tristique et egestas. Turpis massa sed elementum tempus egestas sed sed risus.<br><br>Laoreet non curabitur gravida arcu ac tortor dignissim convallis. Sem nulla pharetra diam sit amet nisl suscipit adipiscing. Faucibus in ornare quam viverra orci sagittis eu volutpat. Adipiscing elit duis tristique sollicitudin nibh sit amet. Cras semper auctor neque vitae. Eu tincidunt tortor aliquam nulla facilisi cras. Luctus accumsan tortor posuere ac ut consequat semper viverra. Felis bibendum ut tristique et. Id donec ultrices tincidunt arcu. At quis risus sed vulputate odio ut enim. Sed libero enim sed faucibus. Cursus risus at ultrices mi tempus imperdiet. Sit amet commodo nulla facilisi nullam vehicula.<br></p>
            </div>
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
</body>

</html>