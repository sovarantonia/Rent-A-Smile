<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Form has been submitted

        // Get the announcement text from the form
        $announcement_text = $_POST["createAnnouncement"];

        // Connect to the database
        $mysqli = require __DIR__ . "/db_connection.php";

        // Prepare the SQL statement
        $sql = sprintf("insert into announcements (date, content, user_id) values (CURRENT_DATE, '%s', %d)",

            $mysqli->real_escape_string($announcement_text),
            $mysqli->real_escape_string($_SESSION["user_id"])
        );


        // Execute the SQL statement
        $result = $mysqli->query($sql);

        if ($result) {
            // Announcement has been created successfully
            echo '<script>alert("Announcement added successfully!")</script>';
            header("Location: my_announcements.php");
            exit;
        } else {
            // Error creating announcement
            $error_message = "Error creating announcement.";
        }
    }
} else {
    // User is not logged in
    header("Location: login.html");
    exit;
}

