<!-- подтверждение заказа -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    echo "Пожалуйста, войдите в систему, чтобы оформить заказ.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];

    $conn = connectToDatabase();

    // Получаем товары из корзины
    //cart.product_id,
    $sql = "SELECT  cart.quantity, products.price 
            FROM cart 
            JOIN products ON cart.product_id = products.id 
            WHERE cart.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_price = 0;
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
        $total_price += $row['price'] * $row['quantity'];
    }

    // Добавляем заказ в таблицу orders
    $sql = "INSERT INTO orders (user_id, total_price, address, status) VALUES (?, ?, ?, 'processing')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ids', $user_id, $total_price, $address);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Сохраняем товары в таблицу order_items
    // foreach ($items as $item) {
    //     $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
    //         VALUES (?, ?, ?, ?)";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param('iiid', $order_id, $item['product_id'], $item['quantity'], $item['price']);
    //     $stmt->execute();
    //     }

    // Очищаем корзину
    $sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Отправляем уведомления
    sendOrderConfirmation($user_id, $order_id, $total_price, $address);

    echo "Заказ успешно оформлен!";
    header("Location: ../pages/thank_you.php"); // Перенаправление на страницу благодарности
    exit;
}

function sendOrderConfirmation($user_id, $order_id, $total_price, $address) {
    // Получаем email пользователя
    $conn = connectToDatabase();
    $sql = "SELECT email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $email = $user['email'];
    $stmt->close();
    $conn->close();

    // Отправляем email клиенту
    $subject = "Ваш заказ №$order_id оформлен";
    $message = "Спасибо за ваш заказ!\n\n";
    $message .= "Номер заказа: $order_id\n";
    $message .= "Сумма заказа: $total_price руб.\n";
    $message .= "Адрес доставки: $address\n\n";
    $message .= "Мы свяжемся с вами для уточнения деталей.";

    mail($email, $subject, $message);

    // Отправляем email вам
    $admin_email = "alexes1242@gmail.com"; // Замените на ваш email
    $subject_admin = "Новый заказ №$order_id";
    $message_admin = "Поступил новый заказ:\n\n";
    $message_admin .= "Номер заказа: $order_id\n";
    $message_admin .= "Сумма заказа: $total_price руб.\n";
    $message_admin .= "Адрес доставки: $address\n";

    mail($admin_email, $subject_admin, $message_admin);
}


?>