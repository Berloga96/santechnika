<!-- обработка удаления из корзины -->



<!-- добавить возврат после удаления из корзины на страницу через кнопку на главную или ??? -->

<?php
session_start();
require_once '../includes/functions.php';

include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "Пожалуйста, войдите в систему, чтобы удалить товар из корзины.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);

    $conn = connectToDatabase();

    $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $cart_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "Товар успешно удален из корзины!";
    } else {
        echo "Ошибка при удалении товара из корзины.";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="thank-you-buttons">
    <a href="/index.php" class="btn">
        <i class="fas fa-home"> </i>Перейти на главную</a> 

    <a href="/pages/catalog.php" class="btn">
        <i class="fas fa-shopping-cart"> </i>Продолжить покупки</a>
</div>

<?php
include '../includes/footer.php';
?>