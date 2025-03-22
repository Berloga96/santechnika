<!-- страницы деталей заказа -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Перенаправление на страницу входа
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: order_history.php"); // Перенаправление, если нет ID заказа
    exit;
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$conn = connectToDatabase();

// Получаем информацию о заказе
$sql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: order_history.php"); // Перенаправление, если заказ не найден
    exit;
}

$order = $result->fetch_assoc();

// Получаем товары в заказе
$sql = "SELECT order_items.quantity, products.name, products.price 
        FROM order_items 
        JOIN products ON order_items.product_id = products.id 
        WHERE order_items.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$items = $stmt->get_result();

$stmt->close();
$conn->close();

include '../includes/header.php';
?>

<h1>Детали заказа №<?= $order['id'] ?></h1>

<p><strong>Дата заказа:</strong> <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></p>
<p><strong>Адрес доставки:</strong> <?= $order['address'] ?></p>
<p><strong>Статус:</strong> <?= $order['status'] ?></p>

<h2>Товары в заказе:</h2>
<table>
    <thead>
        <tr>
            <th>Товар</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $items->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['price'] ?> руб.</td>
                <td><?= $row['price'] * $row['quantity'] ?> руб.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><strong>Итого:</strong> <?= $order['total_price'] ?> руб.</p>

<a href="order_history.php">Вернуться к истории заказов</a>

<?php
include '../includes/footer.php';
?>