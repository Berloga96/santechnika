<?php
session_start();
// страница галереи
// Подключение конфигурации и функций
require_once '../includes/functions.php';

// Подключение шапки сайта
include '../includes/header.php';

?>

<div class="content_galery">


    <div class="gallery">
    <h1 class="main-title" style="text-align: center; padding: 20px 0px">Галерея</h1>
    <!-- Контейнер для слайдера -->
    <div class="swiper-container">
        <!-- Обертка для слайдов -->
        <div class="swiper-wrapper">
            <!-- Слайды -->
            <div class="swiper-slide">
                <img src="/images/mario2.png" alt="Изображение 1">
            </div>
            <div class="swiper-slide">
                <img src="/images/crane.png" alt="Изображение 2">
            </div>
            <div class="swiper-slide">
                <img src="/images/shell-white.png" alt="Изображение 3">
            </div>

            <div class="swiper-slide">
                <img src="/images/shell.png" alt="Изображение 3">
            </div>
            <div class="swiper-slide">
                <img src="/images/shell-black.png" alt="Изображение 3">
            </div>
            <div class="swiper-slide">
                <img src="/images/mixer.png" alt="Изображение 3">
            </div>
            <div class="swiper-slide">
                <img src="/images/gas-kettle.png" alt="Изображение 3">
            </div>
            <div class="swiper-slide">
                <img src="/images/water-heater.png" alt="Изображение 3">
            </div>

            <div class="swiper-slide">
                <img src="/images/shower.jpg" alt="Изображение 3">
            </div><div class="swiper-slide">
                <img src="/images/mario.png" alt="Изображение 3">
            </div><div class="swiper-slide">
                <img src="/images/toilet.jpg" alt="Изображение 3">
            
            <!-- Добавить больше слайдов по мере необходимости -->
        </div>

        

        
        </div>




    </div>

        

        <!-- Кнопки навигации (стрелочки) -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Пагинация (точки) -->
        <div class="swiper-pagination"></div>
</div>
</div>









<!-- Подключение Swiper JS -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
    // Инициализация Swiper
    
    let swiper = new Swiper('.swiper-container', {
        // Настройки слайдера


        slidesPerView: 4, // Количество видимых слайдов
        spaceBetween: 10, // Расстояние между слайдами (в пикселях)
        loop: true, // Бесконечный цикл слайдов

        pagination: {
            el: '.swiper-pagination', // Контейнер для пагинации
            clickable: true, // Возможность переключать слайды по клику на точки
        },

        navigation: {
            nextEl: '.swiper-button-prev', // Кнопка "Вперед"
            prevEl: '.swiper-button-next', // Кнопка "Назад"
        },
        autoplay: {
            delay: 3000, // Автопрокрутка каждые 3 секунды
        },
        // breakpoints: {
        //     // Настройки для экранов меньше 768px
        //     768: {
        //         slidesPerView: 2, // Два слайда на экранах меньше 768px
        //     },
        //     // Настройки для экранов меньше 480px
        //     480: {
        //         slidesPerView: 1, // Один слайд на экранах меньше 480px
        //     },
        // },
    });
</script>

<!-- <script> -->
    <!-- // пагинация в галерее
    // let swiper = new Swiper('.swiper-container', {
    //     slidesPerView: 3,
    //     spaceBetween: 10,
    //     loop: true,
    //     pagination: {
    //         el: '.swiper-pagination', // Контейнер для пагинации
    //         clickable: true, // Возможность переключать слайды по клику на точки
    //     },
    // }); -->
<!-- </script> -->

<?php
include '../includes/footer.php';
?>