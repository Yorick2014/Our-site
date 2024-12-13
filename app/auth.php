<?php
function checkAccess($requiredRole) {
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
        // Если пользователь не авторизован или его роль не соответствует требуемой
        header('Location: login.php');
        exit;
    }
}
