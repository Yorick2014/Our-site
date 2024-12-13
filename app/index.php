<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // Если пользователь не авторизован, перенаправляем на login.php
    header('Location: login.php');
    exit;
}

$username = htmlspecialchars($_SESSION['username']); // Безопасный вывод имени пользователя
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>
<body>
    <h1>Добро пожаловать на НАШ сайт, <?= $username ?>!</h1>
    <p>Ваша роль: <?= $role ?></p>

    <?php if ($role === 'admin'): ?>
        <a href="admin.php">Админ-панель</a>
    <?php endif; ?>


    <a href="logout.php">Выйти</a> <!-- Ссылка для выхода -->
</body>
</html>
