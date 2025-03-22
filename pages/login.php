

<?php
// страница входа/регистрации
// сделал хештрованый пароль
//echo password_hash('admin', PASSWORD_DEFAULT);
//echo '<br>';
// позже сдесь удалить

session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = connectToDatabase();

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        //отладочные сообщения чтобы понять, что происходит
        //echo "Хэш пароля из базы: " . $user['password'] . "<br>";
        //echo "Введенный пароль: " . $password . "<br>";
        //echo "Результат проверки пароля: " . (password_verify($password, $user['password']) ? "true" : "false") . "<br>";
        // закрыть после отладки

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name']; // Сохраняем имя пользователя
            $_SESSION['role'] = $user['role']; // Сохраняем роль пользователя в сессии

            // Перенаправляем администратора на панель управления
            if ($user['role'] === 'admin') {
                header("Location: ../admin/index_adm.php");
            } else {
                // Перенаправляем обычного пользователя на главную страницу
                header("Location: ../index.php");
            }
            exit;
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь не найден.";
    }

    $stmt->close();
    $conn->close();
}

include '../includes/header.php';
?>

<div class="content">

    <div class="main_login">
    <h1 class="main-title" style="text-align: center">Вход</h1>
    <p class="main-descr">Для использования услуг сайта, необходимо войти</p>
    <br>
    <br>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <p style="padding-top: 40px;">Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a>.</p>

</div>

</div>





<?php
include '../includes/footer.php';
?>

