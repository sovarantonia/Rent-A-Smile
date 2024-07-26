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
    <li><a href="manage_accounts.php">Manage accounts </a> </li>
    <li><a href="manage_announcements.php">Manage announcements </a> </li>
    <li><a href="logout.php">Logout </a></li>

</ul>
<ul class="second-list">
    <?php
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT * from users where role != 'admin'";
    $result = $mysqli->query($sql);

    // display each announcement as a list item
    while ($user = $result->fetch_assoc()) {
        echo "<li>";
        echo "<span>" . $user["first_name"] . " " . $user["last_name"] .  " " . $user["email"] . " </span><br>";

        // Prevent delete button for admin account
        if ($user["role"] !== "admin") {
            echo "<form method='post' action='delete_account.php'>";
            echo "<input type='hidden' name='user_id' value='" . $user["id"] . "'>";
            echo "<input type='submit' value='Delete' class='delete-button' data-user-id='" . $user["id"] . "'>";
            echo "</form>";
        } else {
            echo "<span class='admin-account'>Admin account</span>";
        }

        echo "</li>";
    }
    ?>
</ul>
<script>
    const deleteButtons = document.querySelectorAll(".delete-button");
    deleteButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            event.preventDefault();
            const confirmDelete = confirm("Are you sure you want to delete this user account?");
            if (confirmDelete) {
                const userId = button.getAttribute("data-user-id");
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_account.php";
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "user_id";
                input.value = userId;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
<script src="js/color-hover-menu.js"></script>
</body>
</html>