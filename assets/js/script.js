// фильтрация товаров

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const products = document.querySelectorAll('.product');

    function filterProducts() {
        const searchText = searchInput.value.toLowerCase();
        const selectedCategory = categorySelect.value;

        products.forEach(product => {
            const productName = product.querySelector('h3').textContent.toLowerCase();
            const productCategory = product.getAttribute('data-category');

            const matchesSearch = productName.includes(searchText);
            const matchesCategory = selectedCategory === '' || productCategory === selectedCategory;

            if (matchesSearch && matchesCategory) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterProducts);
    categorySelect.addEventListener('change', filterProducts);
});


// обработка формы 

document.addEventListener('DOMContentLoaded', function () {
    // Находим все формы добавления в корзину
    const forms = document.querySelectorAll('form[id^="addToCartForm"]');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Отменяем стандартное поведение формы

            const formData = new FormData(form);

            // Отправляем данные на сервер с помощью Fetch API
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Товар успешно добавлен в корзину!');
                // Можно обновить количество товаров в корзине в шапке сайта
                updateCartCounter();
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при добавлении товара в корзину.');
            });
        });
    });

    // Функция для обновления счетчика товаров в корзине
    function updateCartCounter() {
        fetch('../includes/get_cart_count.php')
            .then(response => response.text())
            .then(count => {
                const cartCounter = document.getElementById('cartCounter');
                if (cartCounter) {
                    cartCounter.textContent = count;
                }
            })
            .catch(error => {
                console.error('Ошибка при обновлении счетчика корзины:', error);
            });
    }

    // Обновляем счетчик при загрузке страницы
    updateCartCounter();
});


