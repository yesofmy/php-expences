<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

$user_id = $_SESSION['user_id'];
$category = $_GET['category'] ?? '';

$query = "SELECT * FROM expenses WHERE user_id=$user_id";
if ($category) $query .= " AND category='$category'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Фільтрація</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Фільтрація за категорією</h2>
<form method="get">
  <select name="category">
    <option value="">Усі</option>
    <option>Їжа</option><option>Одяг</option>
    <option>Транспорт</option><option>Відпочинок</option>
    <option>Лікування</option><option>Спорт</option>
  </select>
  <button type="submit">Показати</button>
</form>

<table>
<tr><th>Сума</th><th>Категорія</th><th>Дата</th><th>Коментар</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr><td><?= $row['amount'] ?></td><td><?= $row['category'] ?></td><td><?= $row['date'] ?></td><td><?= $row['comment'] ?></td></tr>
<?php endwhile; ?>
</table>
<a href="dashboard.php">⬅ Повернутись</a>
</div>
</body>
</html>
