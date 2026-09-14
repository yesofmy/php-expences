<?php session_start(); ?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Авторизація</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Вхід у систему</h2>
  <form action="login.php" method="post">
    <input type="text" name="username" placeholder="Логін" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Увійти</button>
  </form>

  <hr>
  <h3>Реєстрація нового користувача</h3>
  <form action="register.php" method="post">
    <input type="text" name="username" placeholder="Новий логін" required>
    <input type="password" name="password" placeholder="Новий пароль" required>
    <button type="submit">Зареєструватися</button>
  </form>
</div>
</body>
</html>
