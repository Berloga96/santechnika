

<?php

//Реализация изменения статуса заказа

session_start();
require_once '../includes/functions.php';

// Проверяем, является ли пользователь администратором
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещен.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];


    // Проверяем, что статус имеет допустимое значение
    $allowed_statuses = ['processing', 'shipped', 'delivered'];
    if (!in_array($status, $allowed_statuses)) {
        die("Недопустимый статус заказа.");
    }


    $conn = connectToDatabase();

    // Обновляем статус заказа
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $order_id);

    if ($stmt->execute()) {
        // Отправляем уведомление пользователю
        sendStatusUpdateNotification($order_id, $status);
        echo "Статус заказа успешно обновлен.";
    } else {
        echo "Ошибка: Не удалось обновить статус заказа. Пожалуйста, попробуйте снова.";
    }

    $stmt->close();
    $conn->close();
}

function sendStatusUpdateNotification($order_id, $status) {
    $conn = connectToDatabase();

    // Получаем email пользователя и данные заказа
    $sql = "SELECT users.email, orders.total_price, orders.address 
            FROM orders 
            JOIN users ON orders.user_id = users.id 
            WHERE orders.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    if ($order) {
        $email = $order['email'];
        $subject = "Статус вашего заказа №$order_id изменен";
        $message = "Статус вашего заказа №$order_id изменен на: $status.\n\n";
        $message .= "Сумма заказа: {$order['total_price']} руб.\n";
        $message .= "Адрес доставки: {$order['address']}\n\n";
        $message .= "Спасибо за покупку!";


        // Указываем заголовок "From"
        $headers = "From: alexes1242@gmail.com\r\n";
        $headers .= "Reply-To: alexes1242@gmail.com\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

        mail($email, $subject, $message, $headers);
    }
}
?>