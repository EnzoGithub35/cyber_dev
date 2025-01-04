<?php
session_start();

include("config/db_connect");

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("location: login.php");
    exit;
}

// Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $storyId = $_GET['id'];
} else {

    header("location: heheh.php");
    exit;
}

// Check if the logged-in user is the author of the story with the provided ID
$loggedInUserId = $_SESSION['user_id'];
$sql = "SELECT username FROM stories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $storyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
    $author = $row['username'];
    $stmt->close();
} else {
    header("location: offf.php");
    exit;
}

// If the logged-in user is the author
$sqlDelete = "DELETE FROM stories WHERE id = ?";
$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $storyId);

if ($stmtDelete->execute()) {
    $stmtDelete->close();
    $conn->close();
    header("location: profile.php?uid=$loggedInUserId");
    exit;
} else {
    $stmtDelete->close();
    $conn->close();
    header("location: lol.php");
    exit;
}
