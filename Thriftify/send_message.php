<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "database";

$con = new MySQLi($host, $username, $password, $database);

// Additional check for user authentication
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Check if the user clicked on a user to start a chat
if (isset($_GET["user_id"])) {
    $recipientId = $_GET["user_id"];
} else {
    // Redirect to the contact list if no user is selected
    header("Location: messages.php");
    exit();
}

// Check if the recipient exists in the database
$stmt = $con->prepare("SELECT name FROM users WHERE user_id = ?");
$stmt->bind_param("i", $recipientId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Redirect to the contact list if the recipient doesn't exist
    header("Location: messages.php");
    exit();
}

// Function to get messages between the current user and the recipient
function getMessages($con, $userId, $recipientId) {
    $query = "SELECT * FROM messages WHERE (user_id = $userId AND seller_id = $recipientId) OR (user_id = $recipientId AND seller_id = $userId) ORDER BY timestamp ASC";
    $result = $con->query($query);

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}

// Function to send a message with image attachment
function sendMessage($con, $userId, $recipientId, $message, $image) {
    $message = $con->real_escape_string($message);

    // Check if there is an image attachment
    if (!empty($image["name"])) {
        $targetDirectory = "public/"; // Specify your upload directory for images
        $targetFile = $targetDirectory . basename($image["name"]);

        // Move the uploaded image to the specified directory
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;

            // Insert the message with image attachment into the database
            $query = "INSERT INTO messages (user_id, seller_id, message, image_path) VALUES ($userId, $recipientId, '$message', '$imagePath')";
            $result = $con->query($query);

            return $result;
        } else {
            // Handle image upload error
            echo "Sorry, there was an error uploading your image.";
            return false;
        }
    } else {
        // Insert the message without image attachment into the database
        $query = "INSERT INTO messages (user_id, seller_id, message) VALUES ($userId, $recipientId, '$message')";
        $result = $con->query($query);

        return $result;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
    $userId = $_SESSION["user_id"];
    $message = $_POST["message"];
    $image = $_FILES["image"]; // Image attachment from the form

    // Call the sendMessage function to save the message with image attachment
    sendMessage($con, $userId, $recipientId, $message, $image);
}

// Get the recipient's name
$stmt->bind_result($recipientName);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Send Message</title>
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
    function isUserLoggedIn()
    {
        return isset($_SESSION["user_id"]);
    }

    function renderUserDropdown()
    {
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

    function renderGuestButtons()
    {
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

    <div class="container mt-5">
        <h3 class="mb-4">Chatting with <?php echo $recipientName; ?></h3>
        <div class="chat-container border p-3 bg-white">
            <?php
            // Display messages
            $messages = getMessages($con, $_SESSION["user_id"], $recipientId);
            foreach ($messages as $message) {
                $sender = ($message["user_id"] == $_SESSION["user_id"]) ? "You" : $recipientName;
                $imageLink = (!empty($message["image_path"])) ? '<img src="' . $message["image_path"] . '" alt="Attached Image" style="max-width:100%; max-height:100%;">' : '';
                echo '<div class="card bg-light mb-3">
                        <div class="card-body">
                            <p class="card-text"><strong>' . $sender . ':</strong> ' . $message["message"] . '</p>
                            ' . $imageLink . '
                        </div>
                    </div>';
            }
            ?>
        </div>
        <form action="send_message.php?user_id=<?php echo $recipientId; ?>" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Type your message here" required>
                <!-- Replace file input with an image input -->
                <div class="input-group">
                    <label class="btn text-white" style="background: #1e1e1e">
                        Attach Image
                        <input type="file" name="image" accept="image/*" style="display: none;" onchange="displayFileName(this)">
                    </label>
                </div>
                <!-- Add a span to display the selected image name -->
                <span id="file-name"></span>
                <button class="btn text-white" type="submit" style="background: #1e1e1e">Send</button>
            </div>
        </form>
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
    <script>
    // Function to display the selected image name
    function displayFileName(input) {
        const fileName = input.files[0].name;
        document.getElementById("file-name").innerText = fileName;
    }
    </script>
</body>
</html>