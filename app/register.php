<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных окружения
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    try {
        // Подключение к базе данных PostgreSQL
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Чтение данных из формы
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Вставка нового пользователя
        $stmt = $pdo->prepare('INSERT INTO "users" ("username", "password") VALUES (:username, :password)');
        $stmt->execute(['username' => $username, 'password' => $password]);

        // Переход на страницу входа
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        // Логирование и обработка ошибок
        $error = 'Ошибка: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Вход</a></p>
</body>
</html>
