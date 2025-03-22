<?php


session_start();

// Подключение конфигурации и функций
require_once '../includes/functions.php';

// Подключение шапки сайта
include '../includes/header.php';

// Подключение к базе данных
$conn = connectToDatabase();

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
} else {
    echo "Подключение к базе данных успешно!";
}
?>


<div class="content">


<div class="wrapper">
    <main>

<h1 class="main-title-catalog">Каталог товаров</h1>

<div class="filters">
    <input type="text" id="search" placeholder="Поиск товаров...">
    <select id="category">
        <option value="">Все категории</option>
        <?php
        // Запрос для получения категорий
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>
</div>

<div class="products">
<?php
    // Запрос для получения товаров
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product' data-category='{$row['category_id']}'>
                    <img src='{$row['image']}' alt='{$row['name']}'>
                    <h3>{$row['name']}</h3>
                    <p>{$row['description']}</p>
                    <p class='price'>{$row['price']} руб.</p>
                    <form action='../includes/add_to_cart.php' method='post' id='addToCartForm-{$row['id']}'>
                        <input type='hidden' name='product_id' value='{$row['id']}'>
                        <input type='number' name='quantity' value='1' min='1' style='width: 50px;'>
                        <button type='submit'>Добавить в корзину</button>
                    </form>
                </div>";
        }
    } else {
        echo "<p>Товары не найдены.</p>";
    }
    ?>
    <!-- Что делает этот код:
Форма (<form>):
У каждой карточки товара есть форма, которая отправляет данные на сервер при нажатии кнопки.
Атрибут action указывает на файл add_to_cart.php, который обрабатывает добавление товара в корзину.
Атрибут method установлен на post, чтобы данные передавались безопасно.
Скрытое поле (<input type='hidden'>):
Поле product_id содержит идентификатор товара. Оно скрыто от пользователя, но передается на сервер.
Поле для количества (<input type='number'>):
Позволяет пользователю указать количество товара.
Установлено минимальное значение 1 (атрибут min='1').
Кнопка (<button type='submit'>):
При нажатии на кнопку форма отправляет данные на сервер. -->

<!-- Добавьте атрибут id к каждой форме. Чтобы id были уникальными, можно использовать идентификатор товара. -->
</div>


    </main>








</div>


</div>














<?php
// Закрытие соединения с базой данных
$conn->close();
?>

<?php


while ($row = $result->fetch_assoc()) {
    echo "<div class='product' data-category='{$row['category_id']}'>
            <img src='{$row['image']}' alt='{$row['name']}'>
            <h3>{$row['name']}</h3>
            <p>{$row['description']}</p>
            <p class='price'>{$row['price']} руб.</p>";

    // Получаем отзывы о товаре
    $sql_reviews = "SELECT reviews.rating, reviews.comment, users.name 
                    FROM reviews 
                    JOIN users ON reviews.user_id = users.id 
                    WHERE reviews.product_id = ?";
    $stmt_reviews = $conn->prepare($sql_reviews);
    $stmt_reviews->bind_param('i', $row['id']);
    $stmt_reviews->execute();
    $reviews = $stmt_reviews->get_result();

    if ($reviews->num_rows > 0) {
        echo "<div class='reviews'>";
        while ($review = $reviews->fetch_assoc()) {
            echo "<div class='review'>
                    <strong>{$review['name']}</strong> ({$review['rating']} звезд):
                    <p>{$review['comment']}</p>
                </div>";
        }
        echo "</div>";
    }

    echo "</div>";
}
?>











<?php
// Подключение подвала сайта
include '../includes/footer.php';
?>

