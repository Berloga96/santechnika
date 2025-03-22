<?php
session_start();

// Подключение конфигурации и функций
require_once '../includes/functions.php';

// Подключение шапки сайта
include '../includes/header.php';
?>

<img class="news-img" >


    

<div class="wrapper ">
    <div class="services">

    <div class="serv-h1">
        <h1 class="main-title">Наши новости</h1>
    </div>
    
    

    
    



        </div>

    <h2 class="serv-h2">На этой страничке будут опубликовываться новости.</h2>



    
    
</div>
<div style="min-height:auto" class="content">
<h2 style="text-align: center; margin: 40px;">Также вы можете перейти в наши соц сети</h2>

<div class="social-container">
    <a href="https://wa.me/ваш_номер" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="https://t.me/ваш_ник" target="_blank">
        <i class="fab fa-telegram"></i>
    </a>
    <a href="https://vk.com/ваш_ид" target="_blank">
        <i class="fab fa-vk"></i>
    </a>
</div>

</div>




<?php
// Подключение подвала сайта
include '../includes/footer.php';
?>