<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
$mysqli = require __DIR__ . "/db_connection.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $type = $_POST["type"];
	$user_id = $_SESSION["user_id"];

    // Insert new place into the database
    $sql = "INSERT INTO places (name, type, user_id) VALUES ('$name', '$type', '$user_id')";
    $mysqli->query($sql);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title> My places </title>
    <link rel="stylesheet" type="text/css" href="../html2.0/css/places.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">
</head>

<body>
<ul class="first-list">
    <<li> <a href="main_page.php"> Home page </a> </li>
    <li> <a href="announcements.php"> Announcements </a> </li>
    <li> <a href="my_announcements.php">My announcements </a> </li>
    <li> <a href="places.php"> My places </a></li>
    <li> <a href="logout.php">Logout </a> </li>
</ul>

<table>
    <tr>
        <th>Name</th>
        <th>Type</th>
    </tr>
    <?php
    $sql = "SELECT * FROM places";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td><form method='post' class='delete-button' action='delete_place.php'><input type='hidden' name='id' value='" . $row['id'] . "'><input type='submit' value='Delete'></form></td>";
    echo "</tr>";
}
        }
    } else {
        echo "<tr><td colspan='2'>No records found.</td></tr>";
    }
    ?>
    <tr>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <td><input type="text" name="name" placeholder="Enter name" required></td>
            <td>
                <select name="type" id="type" required>
                    <option value="">Select type</option>
                    <option value="Cabana">Cabana</option>
                    <option value="Casa pe plaja">Casa pe plaja</option>
                    <option value="Sala de evenimente">Sala de evenimente</option>
					<option value="Apartament">Apartament</option>
                </select>
            </td>
            <td><input type="submit" value="Add"></td>
        </form>
    </tr>
</table>
<script src="js/color-hover-menu.js"></script>
</body>
</html>