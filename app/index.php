<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // Если пользователь не авторизован, перенаправляем на login.php
    header('Location: login.php');
    exit;
}

// Подключение к базе данных
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

// Получаем имя пользователя из сессии
$username = htmlspecialchars($_SESSION['username']); // Безопасный вывод имени пользователя

// Получаем роль пользователя из базы данных
$stmt = $pdo->prepare('SELECT role FROM "users" WHERE "username" = :username');
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$role = $user ? $user['role'] : 'неизвестная'; // Если пользователь не найден, роль "неизвестная"
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
