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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = $con->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Use password_verify to check the password
        if (password_verify($password, $row["password"])) {
            // Password is correct, set session variables and redirect
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["user_name"] = $row["name"];
            header("Location: DashboardPage.php"); // Redirect to the homepage or wherever you want to go after login
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }
}

$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Log In</title>
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
    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" style="border-color: #1e1e1e;border-top-color: rgb(33,;border-right-color: 37,;border-bottom-color: 41);border-left-color: 37,;">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="HomePage.php"><span class="fs-1">Thriftify</span></a></div>
    </nav>
    <div class="row login-form" style="margin: 10px;">
        <div class="col-md-4 offset-md-4">
            <h2 class="text-center form-heading" style="color: #1e1e1e;">Login Form</h2>
            <form class="custom-form" style="border-top-color: #1e1e1e;" action="login.php" method="POST">
                <?php
                if (isset($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }
                ?>
                <div class="form-group mb-3">
                    <input class="form-control" type="email" placeholder="Email" name="email">
                </div>
                <div class="form-group mb-3">
                    <input class="form-control" type="password" placeholder="Password" name="password">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="formCheck-2" name="remember">
                    <label class="form-check-label" for="formCheck-2">Remember me</label>
                </div>
                <button class="btn btn-light d-block submit-button w-100" type="submit" name="login" style="background: #1e1e1e;">Log In</button>
                <a href="RegisterForm.html">Don't have an account?</a>
            </form>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>
</html>
