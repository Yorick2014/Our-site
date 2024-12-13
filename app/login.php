<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    } catch (PDOException $e) {
        die('Ошибка подключения: ' . $e->getMessage());
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Поиск пользователя по имени
    $stmt = $pdo->prepare('SELECT * FROM "users" WHERE "username" = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit; // Завершаем скрипт после редиректа
    } else {
        $error = 'Неверное имя пользователя или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма авторизации</title>
</head>
<body>
    <form action="" method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Войти</button>
    </form>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</body>
</html>
