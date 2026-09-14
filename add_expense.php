<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$amount = $_POST['amount'];
$category = $_POST['category'];
$date = $_POST['date'];
$comment = $_POST['comment'];

$sql = "INSERT INTO expenses (user_id, amount, category, date, comment)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("idsss", $user_id, $amount, $category, $date, $comment);
$stmt->execute();

header("Location: dashboard.php");
?>
