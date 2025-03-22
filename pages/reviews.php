<!--  страница для отзывов -->

<?php
session_start();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = connectToDatabase();
$user_id = $_SESSION['user_id'];

// Получаем список заказов пользователя
$sql = "SELECT DISTINCT products.id, products.name 
        FROM order_items 
        JOIN products ON order_items.product_id = products.id 
        JOIN orders ON order_items.order_id = orders.id 
        WHERE orders.user_id = ?";

        //DISTINCT гарантирует, что каждый товар будет показан только один раз, даже если пользователь заказывал его несколько раз.

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Отладка
//echo "<pre>";
//print_r($products);
//echo "</pre>";
// конец

$stmt->close();
$conn->close();

include '../includes/header.php';
?>


<div class="content">

    <div class="wrapper ">

        <h1 class="main-title">Оставить отзыв</h1>

<?php if (!empty($products)) { ?>
    <form action="../includes/submit_review.php" method="post">
        <label for="product_id">Выберите товар:</label>
        <select name="product_id" id="product_id" required>
            <?php foreach ($products as $product) { ?>
                <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
            <?php } ?>
        </select>

        <label for="rating">Оценка:</label>
        <select name="rating" id="rating" required>
            <option value="1">1 звезда</option>
            <option value="2">2 звезды</option>
            <option value="3">3 звезды</option>
            <option value="4">4 звезды</option>
            <option value="5">5 звезд</option>
        </select>

        <label for="comment">Комментарий:</label>
        <textarea name="comment" id="comment" rows="5" required></textarea>

        <button type="submit">Отправить отзыв</button>
    </form>
<?php } else { ?>
    <p class="main-descr">У вас пока нет заказов, чтобы оставить отзыв.</p>
<?php } ?>

    </div>

    
</div>






<?php
include '../includes/footer.php';
?>