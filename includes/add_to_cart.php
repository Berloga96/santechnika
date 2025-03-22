<!-- добавить в корзину -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправляем на страницу входа
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['user_id'];

    $conn = connectToDatabase();

    // Проверяем, есть ли товар уже в корзине
    $sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Если товар уже в корзине, обновляем количество
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $new_quantity, $row['id']);
    } else {
        // Если товара нет в корзине, добавляем его
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $user_id, $product_id, $quantity);
    }

    if ($stmt->execute()) {
        // Товар успешно добавлен, возвращаем успешный ответ
        echo "success";
    } else {
        // Ошибка при добавлении товара
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>