<!-- Создание обработчика отзывов -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    die("Доступ запрещен.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $rating = intval($_POST['rating']);
    $comment = $_POST['comment'];

    $conn = connectToDatabase();

    // Проверяем, что пользователь действительно покупал этот товар
    $sql = "SELECT * FROM order_items 
            JOIN orders ON order_items.order_id = orders.id 
            WHERE orders.user_id = ? AND order_items.product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Добавляем отзыв
        $sql = "INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiis', $user_id, $product_id, $rating, $comment);

        if ($stmt->execute()) {
            echo "Отзыв успешно добавлен.";
        } else {
            echo "Ошибка при добавлении отзыва.";
        }
    } else {
        echo "Вы не можете оставить отзыв на этот товар.";
    }

    $stmt->close();
    $conn->close();
}
?>