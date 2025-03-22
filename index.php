<?php
session_start();

// Подключение конфигурации и функций
require_once 'includes/functions.php';

// Подключение шапки сайта
include 'includes/header.php';
?>


<div class="content">

<div class="wrapper ">

        <h1 class="main-title">Добро пожаловать на сайт!</h1>
        <p class="main-descr">Здесь вы можете заказать сантехнику и услуги монтажа.</p>

        <!-- основной блок -->

        <main>
        <div class="serv">
                <a href="/pages/catalog.php" class="btn">
        <i class="fas fa-shopping-cart"> </i>Заказать сантехнику</a> 

                <a href="/pages/services.php" class="btn">
        <i class="fas fa-wrench"> </i>Заказать услуги монтажа</a>

                <a href="/pages/gallery.php" class="btn">
        <i class="fas fa-home"> </i>Посмотреть галлерею</a>
        </div>




                <div class="man">

        
                </div>


        </main>  
        
        </div>

</div>





<?php
// Подключение подвала сайта
include 'includes/footer.php';
?>