<?php
require 'auth.php';
checkAccess('admin'); // Доступ только для администратора

session_start();

// Подключение к базе данных
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Обновление роли пользователя
    $stmt = $pdo->prepare('UPDATE "users" SET "role" = :role WHERE "username" = :username');
    $stmt->execute(['role' => $role, 'username' => $username]);

    $message = "Роль пользователя $username успешно обновлена на $role.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление ролями</title>
</head>
<body>
    <h1>Управление ролями пользователей</h1>
    <?php if (isset($message)): ?>
        <p style="color: green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="role">Роль:</label>
        <select id="role" name="role" required>
            <option value="user">user</option>
            <option value="admin">admin</option>
        </select>
        <br>
        <button type="submit">Обновить роль</button>
    </form>
    <a href="index.php">На главную</a>
</body>
</html>
