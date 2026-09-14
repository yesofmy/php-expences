<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$id = $_GET['id'];
$conn->query("DELETE FROM expenses WHERE id=$id");
header("Location: dashboard.php");
?>
