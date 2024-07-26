<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$mysqli = require __DIR__ . "/db_connection.php";
$user_id = $_SESSION["user_id"];
$sql = "SELECT role FROM users WHERE id = $user_id";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Home page </title>
    <link rel="stylesheet" type="text/css" href="../html2.0/css/main_page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
<ul class="first-list">
     <li> <a href="main_page.php"> Home page </a> </li>
    <li> <a href="announcements.php"> Announcements </a> </li>
    <li> <a href="my_announcements.php">My announcements </a> </li>
    <li> <a href="places.php"> My places </a></li>
    <li> <a href="logout.php">Logout </a> </li>

</ul>
<header>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search...">
    </div>
</header>
<ul class="second-list">
    <?php
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT a.id, a.date, a.content, u.first_name, u.last_name 
FROM announcements a 
    inner join users u on a.user_id=u.id 
WHERE a.user_id = $user_id
order by a.date desc";
    $result = $mysqli->query($sql);

    // display each announcement as a list item
    while ($announcement = $result->fetch_assoc()) {
        echo "<li>";
        echo "<span>" . $announcement["first_name"] . " " . $announcement["last_name"] . " - " . $announcement["date"] . "</span><br>";
        echo $announcement["content"];

        // add a delete button for this announcement
        echo "<form class='delete-form' method='POST' action='delete_announcement.php'>";
        echo "<input type='hidden' name='announcement_id' value='" . $announcement["id"] . "'/>";
		echo "<input type='hidden' name='role' value='" . $user["role"] . "'>";
        echo "<button type='submit' class='delete-button' id='delete-button'>Delete</button>";
        echo "</form>";

        echo "</li>";
    }
    ?>


</ul>
<script src="js/delete-announcement.js"></script>
<script src="js/color-hover-menu.js"></script>
</body>
</html>
