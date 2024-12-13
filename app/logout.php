<?php
session_start();
session_unset(); // Удалить все переменные сессии
session_destroy(); // Уничтожить сессию
header('Location: login.php'); // Перенаправить на страницу входа
exit;
?>
