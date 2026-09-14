<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$result = $conn->query("SELECT * FROM expenses WHERE user_id=$user_id ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Мої витрати</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Вітаю, <?php echo htmlspecialchars($username); ?>!</h2>
  <a class="logout" href="logout.php">Вихід</a>

  <h3>Додати витрату</h3>
  <form action="add_expense.php" method="post">
    <input type="number" name="amount" step="0.01" placeholder="Сума" required>
    <select name="category">
      <option>Їжа</option>
      <option>Одяг</option>
      <option>Транспорт</option>
      <option>Відпочинок</option>
      <option>Лікування</option>
      <option>Спорт</option>
    </select>
    <input type="date" name="date" required>
    <input type="text" name="comment" placeholder="Коментар">
    <button type="submit">Додати</button>
  </form>

  <h3>Мої витрати</h3>
  <table>
    <tr><th>Сума</th><th>Категорія</th><th>Дата</th><th>Коментар</th><th>Дії</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr class="cat-<?= strtolower($row['category']) ?>">
        <td><?= $row['amount'] ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= $row['date'] ?></td>
        <td><?= htmlspecialchars($row['comment']) ?></td>
        <td>
          <a href="edit_expense.php?id=<?= $row['id'] ?>">✏️</a>
          <a href="delete_expense.php?id=<?= $row['id'] ?>" onclick="return confirm('Видалити запис?')">🗑️</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

  <p><a href="filter_expenses.php">🔍 Фільтрація</a> |
     <a href="statistics.php">📊 Статистика</a></p>
</div>
</body>
</html>
