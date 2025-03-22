<!-- выход из аккаунта -->

<?php
session_start();

// Уничтожаем сессию
session_unset();
session_destroy();

// Перенаправляем на главную страницу
header("Location: ../index.php");
exit;
?>