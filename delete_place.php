<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$mysqli = require __DIR__ . "/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the place ID from the form
    $id = $_POST["id"];

    // Delete the place from the database
    $sql = "DELETE FROM places WHERE id = '$id'";
    $mysqli->query($sql);

    // Redirect back to the places.php page after deletion
    header("Location: places.php");
    exit;
}
?>