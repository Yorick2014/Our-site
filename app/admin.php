<?php
require 'auth.php';
checkAccess('admin'); // Ограничить доступ только для администраторов
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
</head>
<body>
    <h1>Добро пожаловать в Админ-панель!</h1>
</body>
</html>
