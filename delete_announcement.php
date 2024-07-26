<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

$mysqli = require __DIR__ . "/db_connection.php";

if (isset($_POST["announcement_id"])) {
    $announcement_id = $_POST["announcement_id"];
    $user_id = $_SESSION["user_id"];
    $user_role = $_POST["role"];

    // Check if the announcement belongs to the current user or if the user is an admin
    $sql = "SELECT * FROM announcements WHERE id = $announcement_id";
    $result = $mysqli->query($sql);
    $announcement = $result->fetch_assoc();


    if ($user_role !== "admin" && $announcement["user_id"] !== $user_id) {
        // The announcement does not belong to the current user and the user is not an admin
        echo "You do not have permission to delete this announcement.";
        exit;
    }

    // Delete the announcement from the database
    $sql = "DELETE FROM announcements WHERE id = $announcement_id";
    if ($mysqli->query($sql)) {
        echo "Announcement deleted successfully.";
        if ($user_role === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: main_page.php");
        }

    } else {
        echo "Error deleting announcement: " . $mysqli->error;
    }
}
?>

