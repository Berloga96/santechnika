<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хэшируем пароль
    $role = 'user'; // По умолчанию регистрируем как обычного пользователя

    $conn = connectToDatabase();

    // Проверяем, есть ли пользователь с таким email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Пользователь с таким email уже существует.";
    } else {
        // Добавляем нового пользователя
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $email, $password, $role);

        if ($stmt->execute()) {
            echo "Регистрация прошла успешно! Теперь вы можете войти.";
            header("Location: login.php"); // Перенаправляем на страницу входа
            exit;
        } else {
            echo "Ошибка при регистрации.";
        }
    }

    $stmt->close();
    $conn->close();
}

include '../includes/header.php';
?>

<div class="content">
    <div class="main_registr">

    <h1 class="main-title" style="text-align: center; padding-bottom: 40px">Регистрация</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <p style="padding-top: 40px;">Уже есть аккаунт? <a href="login.php">Войдите</a>.</p>



    </div>
    <!-- <h1 class="main-title" style="text-align: center">Вход</h1>
    <p class="main-descr">Для использования услуг сайта, необходимо войти</p> -->

</div>






<?php
include '../includes/footer.php';
?>