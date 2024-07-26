<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_POST["user_id"];
    $mysqli = require __DIR__ . "/db_connection.php";
    $sql = sprintf("DELETE FROM users WHERE id = '%s'",
        $mysqli->real_escape_string($userId));
    $result = $mysqli->query($sql);
    if ($result) {
        // Deletion was successful
        echo '<script>alert("User deleted successfully!")</script>';
        header("Location: admin.php");
        exit;
    }
    else{
        echo 'Error deleting user';
    }
}