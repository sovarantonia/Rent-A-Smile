<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$mysqli = require __DIR__ . "/db_connection.php";
// Check if user has admin role
$user_id = $_SESSION["user_id"];
$sql = "SELECT role FROM users WHERE id = $user_id";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// If user does not have admin role, redirect to main page or display an error message
if ($user["role"] !== "admin") {
    $error = "Access denied. You need admin privileges to access this page.";
    header("Location: main_page.php?error=" . urlencode($error));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Home page </title>
    <link rel="stylesheet" type="text/css" href="../html2.0/css/main_page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">
</head>
<body>
<ul class="first-list">
    <li><a href="admin.php"> Home page </a></li>
    <li><a href="manage_accounts.php">Manage accounts </a></li>
    <li><a href="manage_announcements.php">Manage announcements </a></li>
    <li><a href="logout.php">Logout </a></li>

</ul>
<ul class="second-list">
    <?php
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT a.id, a.date, a.content, u.first_name, u.last_name, u.role 
FROM announcements a 
    INNER JOIN users u ON a.user_id = u.id 
ORDER BY a.date desc";
    $result = $mysqli->query($sql);

    // display each announcement as a list item
    while ($announcement = $result->fetch_assoc()) {
        echo "<li>";
        echo "<span>" . $announcement["first_name"] . " " . $announcement["last_name"] . " - " . $announcement["date"] . "</span><br>";
        echo $announcement["content"];
        echo "<form method='post' action='delete_announcement.php'>";
        echo "<input type='hidden' name='announcement_id' value='" . $announcement["id"] . "'>";
        echo "<input type='hidden' name='role' value='" . $user["role"] . "'>";
        echo "<input type='submit' value='Delete' class='delete-button'>";
        echo "</form>";
        echo "</li>";
    }
    ?>
</ul>
<script src="js/color-hover-menu.js"></script>
</body>
</html>