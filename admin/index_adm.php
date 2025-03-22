<!--  Создание интерфейса для администратора -->

<?php
session_start();
require_once '../includes/functions.php';

// Проверяем, является ли пользователь администратором
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php"); // Перенаправление на страницу входа
    exit;
}

$conn = connectToDatabase();

// Получаем все заказы
$sql = "SELECT orders.id, orders.user_id, orders.total_price, orders.address, orders.status, orders.created_at, users.name as user_name 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        ORDER BY orders.created_at DESC";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();

include '../includes/header.php';
?>


<div class="content">

    <div class="wrapper ">
        <h1 class="main-title" style="text-align: center; padding: 20px 0px">Панель администратора</h1>
        <h2 style="text-align: center; padding: 20px 0px">Список заказов</h2>

            <div class="content_center">

                <table>
    <thead>
        <tr>
            <th>Номер заказа</th>
            <th>Пользователь</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Адрес</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order) { ?>
            <tr id="order-<?= $order['id'] ?>">
                <td><?= $order['id'] ?></td>
                <td><?= $order['user_name'] ?></td>
                <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                <td><?= $order['total_price'] ?> руб.</td>
                <td><?= $order['address'] ?></td>
                <td class="status"><?= $order['status'] ?></td>
                <td>
                    <form onsubmit="updateOrderStatus(event, <?= $order['id'] ?>)">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status">
                            <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>В обработке</option>
                            <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Отправлен</option>
                            <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Доставлен</option>
                        </select>
                        <button type="submit">Обновить</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

            </div>




    </div>


    

</div>







<script>

// применение AJAX 

function updateOrderStatus(event, orderId) {
    event.preventDefault(); // Отменяем стандартное поведение формы

    const form = event.target;
    const formData = new FormData(form);
    const status = formData.get('status');
    //модалка
    const button = form.querySelector('button[type="submit"]');

    // Отключаем кнопку
    button.disabled = true;
    button.textContent = "Обновление...";
    button.classList.add('updating');


    fetch('change_order_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {

        // Убираем лишние пробелы и символы
        data = data.trim();



        if (data === "Статус заказа успешно обновлен.") {
            // Обновляем статус на странице
            const statusCell = document.querySelector(`#order-${orderId} .status`);
            if (statusCell) {
                statusCell.textContent = status;


                // Добавляем анимацию
                statusCell.classList.add('blink');

                // Убираем анимацию через 2 секунды
                setTimeout(() => {
                    statusCell.classList.remove('blink');
                }, 2000);


            }
            showNotification(data); // Показываем уведомление об успешном обновлении (стало для модалки)
            //alert(data); // Показываем сообщение об успешном обновлении (было)
        } else {
            
            showNotification("Ошибка: " + data, true); // Показываем уведомление об ошибке (стало для модалки)
            //alert("Ошибка: " + data); // Показываем сообщение об ошибке (было)
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        // стало для модалки
        showNotification("Произошла ошибка при обновлении статуса. Пожалуйста, попробуйте снова.", true);
    })
    .finally(() => {
        // Включаем кнопку обратно
        button.disabled = false;
        button.textContent = "Обновить";
        button.classList.remove('updating');
    });
}





        //alert("Произошла ошибка при обновлении статуса. Пожалуйста, попробуйте снова."); (было)
    //});

    //  отладка перед отправкой запроса:
    console.log("Отправляемые данные:", {
    order_id: formData.get('order_id'),
    status: formData.get('status')
    // после отладки скрыть

});
//}

//модальное окно

// Функция для отображения уведомлений
function showNotification(message, isError = false) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notification-message');
    const notificationClose = document.getElementById('notification-close');

    // Устанавливаем сообщение и стиль
    notificationMessage.textContent = message;
    notification.classList.remove('hidden');
    notification.classList.toggle('error', isError);

    // Закрытие уведомления по кнопке
    notificationClose.onclick = () => {
        notification.classList.add('hidden');
    };

    // Автоматическое закрытие через 5 секунд
    setTimeout(() => {
        notification.classList.add('hidden');
    }, 5000);
}
</script>

<?php
include '../includes/footer.php';
?>