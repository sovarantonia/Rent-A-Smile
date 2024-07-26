<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$mysqli = require __DIR__ . "/db_connection.php";
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
    // display the first 3 announcements
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT a.date, a.content, u.first_name, u.last_name 
            FROM announcements a 
            INNER JOIN users u ON a.user_id=u.id 
            WHERE a.user_id != $user_id
            ORDER BY a.date DESC LIMIT 2";
    $result = $mysqli->query($sql);
    while ($announcement = $result->fetch_assoc()) {
        echo "<li>";
        echo "<span>" . $announcement["first_name"] . " " . $announcement["last_name"] . " - " . $announcement["date"] . "</span><br>";
        echo $announcement["content"];
        echo "</li>";
    }
    ?>
</ul>
<div class="load-more-container">
    <button id="load-more-button">Load More</button>
</div>
<script>
    const loadMoreButton = document.getElementById("load-more-button");
    let offset = 2; // start fetching from the 4th announcement

    const fetchAnnouncements = () => {
        fetch(`load_more.php?offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                const secondList = document.querySelector(".second-list");
                data.forEach(announcement => {
                    const li = document.createElement("li");
                    li.innerHTML = `<span>${announcement.first_name} ${announcement.last_name} - ${announcement.date}</span><br>${announcement.content}`;
                    secondList.appendChild(li);
                });
                offset += 3; // increment the offset by 2 for the next fetch
            })
            .catch(error => console.error(error));
    };

    loadMoreButton.addEventListener("click", fetchAnnouncements);
</script>
<script src="js/color-hover-menu.js"></script>
</body>
</html>