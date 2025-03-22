<!--  вывод отображения корзины -->

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
$sql = "SELECT cart.id, cart.quantity, products.name, products.price, products.image
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

    //$img_adr = $row[image];
}

$stmt->close();
$conn->close();

include '../includes/header.php';
?>

<div class="content">

<div class="wrapper_cart">
<h1 class="main-title">Корзина</h1>
<p> </p>

<?php if (!empty($items)) { ?>
    <table class="tabl">
        <thead>
            <tr>
                

                <th>Товар</th>
                <th>Описание</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Сумма</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>

                <td>
                        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" style="width: 50px;">
                        <?= $item['name'] ?>
                    </td>

                    <td><?= $item['name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['price'] ?> руб.</td>
                    <td><?= $item['price'] * $item['quantity'] ?> руб.</td>
                    <td>
                        <form action="../includes/remove_from_cart.php" method="post">
                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                            <button type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><strong>Итого: <?= $total_price ?> руб.</strong></p>

    <!-- Кнопка "Оформить заказ" -->
    <a href="checkout.php" class="checkout-button">Оформить заказ</a>
<?php } else { ?>
    <p class="page">Ваша корзина пуста.</p>
<?php } ?>

</div>

</div>




<?php
include '../includes/footer.php';
?>