<?php
session_start();

// Подключение конфигурации и функций
require_once '../includes/functions.php';

// Подключение шапки сайта
include '../includes/header.php';
?>




    

<div class="wrapper ">
<div class="about-me">
    <div class="photo-container">
        <img src="/images/my.jpg" alt="Мое фото" class="profile-photo">
    </div>
    <div class="description">
        <h2 style="font-size: 32px;">Обо мне</h2>
        <p>
            Привет! Меня зовут Александр, и я разработал этот сайт с нуля. 
            В процессе я использовал современные технологии, такие как <strong>PHP</strong> для серверной части, 
            <strong>JavaScript</strong> для интерактивности и <strong>HTML/CSS</strong> для стильной верстки. 
            Я всегда стремлюсь к созданию удобных и красивых интерфейсов, которые радуют пользователей.
        </p>
        <p>
            Кроме того, я увлекаюсь разработкой дизайн систем, лендингов и интернет магазинов. Изучаю новые технологии, например такие как искуственный интелект, новые тренды в дизайне. 
            Этот проект — ещё один шаг в моём стремлении к совершенству!
        </p>
    </div>
</div>

<div class="mail">
    <a href="mailto:alexes1242@gmail.com" class="contact-button">Связаться со мной</a>
</div>


    
    
</div>
<div style="min-height:auto" class="content">
<h2 style="text-align: center; margin: 40px;">Также вы можете перейти в мои соц сети</h2>

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