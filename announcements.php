<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title> Create an announcement </title>
    <link rel="stylesheet" type="text/css" href="../html2.0/css/announcements.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">
</head>

<body>
<ul class="first-list">
    <li> <a href="main_page.php"> Home page </a> </li>
    <li> <a href="announcements.php"> Announcements </a> </li>
    <li> <a href="my_announcements.php">My announcements </a> </li>
	<li> <a href="places.php"> My places </a></li>
    <li> <a href="logout.php">Logout </a> </li>
</ul>

<form method="post" action="create_announcement.php">

    <label for="createAnnouncement"> Create an announcement </label><br>


    <textarea id="createAnnouncement" name="createAnnouncement" rows="4" cols="50"
              placeholder="Enter your text here"></textarea>
    <input type="submit" value="Submit" class="submit-button">
</form>
<script src="js/color-hover-menu.js"></script>
</body>
</html>