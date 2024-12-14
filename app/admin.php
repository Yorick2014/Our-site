<?php
require 'auth.php';
checkAccess('admin'); // Ограничить доступ только для администраторов

// Подключение к базе данных PostgreSQL
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

// Запрос записей из таблицы sensordata
$query = "SELECT id, sensorname, value, timestamp FROM sensordata ORDER BY id DESC";
$stmt = $pdo->query($query);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Добро пожаловать в Админ-панель!</h1>

    <h2>Записи из таблицы sensordata</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sensor Name</th>
                <th>Value</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['sensorname']) ?></td>
                        <td><?= htmlspecialchars($row['value']) ?></td>
                        <td><?= htmlspecialchars($row['timestamp']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Нет записей</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
