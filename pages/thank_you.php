<!-- страница благодарности -->

<?php
session_start();
require_once '../includes/functions.php';

include '../includes/header.php';
?>


<div class="content">


    <h1 class="main-title">Спасибо за ваш заказ!</h1>
<p class="main-descr">Мы свяжемся с вами для уточнения деталей.</p>

<div class="thank-you-buttons">
    <a href="/index.php" class="btn">
        <i class="fas fa-home"> </i>Перейти на главную</a> 

    <a href="/pages/catalog.php" class="btn">
        <i class="fas fa-shopping-cart"> </i>Продолжить покупки</a>
</div>


</div>

<?php
include '../includes/footer.php';
?>