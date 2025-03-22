<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт сантехники</title>

    <!-- Подключение Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- фавикон -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
</head>

    <header class="site-header">
        <div class="header-container">

            <!-- Логотип -->
            <div class="logo">
            <img src="/images/logo.png" alt="Логотип сайта">
            </div>


            <!-- Название сайта -->
            <div class="site-name">
            <h1>Интернет магазин</h1>
            </div>



            <!-- отображение Никнейма -->
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) { ?> 

            <div class="logo-user">
                <div class="sp">
            
                    <span>Привет, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                    </div>


                    
                <?php } ?>

                

                <div <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name'])) {?>
                    style="visibility: hidden;" <?php } ?>
                class="logo-out">

                <a class="logo-out-a" href="../includes/logout.php">Выйти</a> <!-- Кнопка выхода -->
                </div>

            </div>
            </div>
        


        
        <nav class="nav-container">
            <ul>

                    <li><a href="/index.php">Главная</a></li>
                    <li><a href="/pages/catalog.php">Каталог</a></li>
                    <li><a href="/pages/cart.php">Корзина (<span id="cartCounter">0</span>)</a> </li>
                    <li><a href="/pages/order_history.php">Мои заказы</a></li> <!-- Новая ссылка -->
                    <!-- <li><a href="/pages/reviews.php">Оставить отзыв</a></li> -->
                    <li><a href="/pages/services.php">Услуги</a></li>
                    <li><a href="/pages/gallery.php">Галерея</a></li>
                    <li><a href="/pages/news.php">Новости</a></li>
                    <li><a href="/pages/about.php">О нас</a></li>
                    <li><a href="/pages/login.php">Зарегистрироваться</a></li>


                
            </ul>

                

        

<?php // отладка сессии
//session_start();
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>"; // позже закоментить
?>

            

            

        </nav>
    </header>

    <body>
        

    





        <!-- модальное окно -->
        <div id="notification" class="notification hidden">
            <span id="notification-message"></span>
            <button id="notification-close">&times;</button>
        </div>

    </body>
    <script src="/assets/js/script.js"></script>


<!--Добавлен счетчик товаров в корзине <a href="pages/cart.php">Корзина (<span id="cartCounter">0</span>)</a> -->