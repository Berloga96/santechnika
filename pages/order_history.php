
<!-- страница истории заказов -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Перенаправление на страницу входа
    exit;
}

$conn = connectToDatabase();
$user_id = $_SESSION['user_id'];

// Получаем заказы пользователя
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
$conn->close();

include '../includes/header.php';
?>


<div class="content">

            <h1 class="main-title" style="text-align: center; padding: 20px 0px">История заказов</h1>


    <div class="content_center">

    


<?php if (!empty($orders)) { ?>
    <table>
        <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                    <td><?= $order['total_price'] ?> руб.</td>
                    <td><?= $order['status'] ?></td>
                    <td>
                        <a href="order_details.php?id=<?= $order['id'] ?>">Подробнее</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>У вас пока нет заказов.</p>
<?php } ?>
</div>

    </div>

    






<?php
include '../includes/footer.php';
?>