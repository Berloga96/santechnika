<!-- страница создания заказа -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Перенаправление на страницу входа
    exit;
}

$conn = connectToDatabase();
$user_id = $_SESSION['user_id'];

// Получаем товары в корзине
$sql = "SELECT cart.id, cart.quantity, products.name, products.price 
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

$stmt->close();
$conn->close();

include '../includes/header.php';
?>

<div class="content">


<div class="order ">

    <h1 class="main-title">Оформление заказа</h1>

<?php if (!empty($items)) { ?>
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
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['price'] ?> руб.</td>
                    <td><?= $item['price'] * $item['quantity'] ?> руб.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><strong>Итого: <?= $total_price ?> руб.</strong></p>

    <form action="../includes/place_order.php" method="post">
        <label for="address">Адрес доставки:</label>
        <input type="text" id="address" name="address" required>
        <button type="submit">Подтвердить заказ</button>
    </form>
<?php } else { ?>
    <p>Ваша корзина пуста.</p>
<?php } ?>

</div>






</div>



<?php
include '../includes/footer.php';
?>