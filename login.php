<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/db_connection.php";

    $sql = sprintf("SELECT * FROM users
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {

        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            // Check if the user has 'admin' role
            if ($user["role"] === 'admin') {
                // User has 'admin' role, perform admin-specific actions
                // For example, redirect to the admin page
                header("Location: admin.php");
                exit;
            } else {
                // User does not have 'admin' role, redirect to the regular main page
                header("Location: main_page.php");
                exit;
            }
        }
    }

    $is_invalid = true;
}

?>

