<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$mysqli = require __DIR__ . "/db_connection.php";

if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
    $offset = (int)$_GET["offset"];
} else {
    $offset = 0;
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT a.date, a.content, u.first_name, u.last_name 
    FROM announcements a 
    INNER JOIN users u ON a.user_id = u.id 
    WHERE a.user_id != $user_id
    ORDER BY a.date DESC
    LIMIT 3 OFFSET $offset";

$role = "select role from users where id=$user_id";

if($role === "admin"){
    $sql = "SELECT a.date, a.content, u.first_name, u.last_name 
    FROM announcements a 
    INNER JOIN users u ON a.user_id = u.id  ORDER BY a.date DESC
    LIMIT 3 OFFSET $offset";
}
$result = $mysqli->query($sql);

$announcements = [];
while ($announcement = $result->fetch_assoc()) {
    $announcements[] = [
        "first_name" => $announcement["first_name"],
        "last_name" => $announcement["last_name"],
        "date" => $announcement["date"],
        "content" => $announcement["content"]
    ];
}

header("Content-Type: application/json");
echo json_encode($announcements);
?>