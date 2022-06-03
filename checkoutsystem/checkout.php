<?php
require 'config.php';

$grand_total = 0;
$allItems = '';
$items = [];

$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(', <br/>', $items);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Sahil Kumar">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Checkout</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php"><i class="fas fa-user"></i>&nbsp;&nbsp;Рабочее место продавца бытовой техники</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-mobile-alt mr-2"></i>Товары</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="checkout.php"><i class="fas fa-money-check-alt mr-2"></i>Офрмление заявки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 pb-4" id="order">
                <h4 class="text-center text-info p-2">Завершите свой заказ!</h4>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Товар(ы) : </b><?= $allItems; ?></h6>
                    <h6 class="lead"><b>Стоимость доставки: </b>бесплатно</h6>
                    <h5><b>Общая суммаe : </b><?= $grand_total . ' руб.'; ?></h5>
                </div>
                <form action="" method="post" id="placeOrder">
                    <input type="hidden" name="products" value="<?= $allItems; ?>">
                    <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Введите имя" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Введите E-Mail" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Введите телефон" required>
                    </div>
                    <div class="form-group">
                        <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Введите адрес доставки здесь..."></textarea>
                    </div><br/>
                    <h6 class="text-center lead">Выберите Способ Оплаты</h6>
                    <div class="form-group">
                        <select name="pmode" class="form-control">
                            <option value="" selected disabled>-- Выберите Способ Оплаты --</option>
                            <option value="cod">Наложенный платеж при доставке</option>
                            <option value="netbanking">Онлайн</option>
                            <option value="cards">Дебетовая/Кредитная карта</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Офрмить заявку" class="btn btn-danger btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Отправка данных формы на сервер
            $("#placeOrder").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: $('form').serialize() + "&action=order",
                    success: function(response) {
                        $("#order").html(response);
                    }
                });
            });

            //Загрузить общее количество товаров, добавленных в корзину, и отобразить на панели навигации
            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        cartItem: "cart_item"
                    },
                    success: function(response) {
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>
</body>

</html>