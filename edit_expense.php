<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM expenses WHERE id=$id");
$row = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $comment = $_POST['comment'];
    $conn->query("UPDATE expenses SET amount='$amount', category='$category', date='$date', comment='$comment' WHERE id=$id");
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Редагування</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Редагувати витрату</h2>
<form method="post">
  <input type="number" name="amount" value="<?= $row['amount'] ?>" required>
  <select name="category">
    <?php
    $cats = ["Їжа","Одяг","Транспорт","Відпочинок","Лікування","Спорт"];
    foreach ($cats as $c) {
        $sel = $c == $row['category'] ? "selected" : "";
        echo "<option $sel>$c</option>";
    }
    ?>
  </select>
  <input type="date" name="date" value="<?= $row['date'] ?>" required>
  <input type="text" name="comment" value="<?= htmlspecialchars($row['comment']) ?>">
  <button type="submit">Зберегти</button>
</form>
</div>
</body>
</html>
