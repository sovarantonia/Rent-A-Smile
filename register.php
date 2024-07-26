<?php
if (empty($_POST["firstName"])) {
    die("Name is required");
}
if (empty($_POST["lastName"])) {
    die("Name is required");
}
if (empty($_POST["email"])) {
    die("Email is required");
}
if (empty($_POST["password"])) {
    die("Password is required");
}
if (empty($_POST["confirm-password"])) {
    die("Password is required");
}

if ($_POST["password"] !== $_POST["confirm-password"]) {
    die("Passwords must match");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/db_connection.php";
$sql = "INSERT INTO users (first_name, last_name, email, password, role)
        VALUES (?, ?, ?, ?, 'user')";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss",
    $_POST["firstName"],
    $_POST["lastName"],
    $_POST["email"],
    $password_hash);

if ($stmt->execute()) {

    header("Location: login.html");
    exit;

} else {

    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
