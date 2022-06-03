<?php
session_start();
require 'config.php';

// Добавить товары в корзину таблица
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pcode = $_POST['pcode'];
    $pqty = $_POST['pqty'];
    $total_price = $pprice * $pqty;

    $stmt = $conn->prepare('SELECT product_code FROM cart WHERE product_code=?');
    $stmt->bind_param('s', $pcode);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_assoc();
    $code = $r['product_code'] ?? '';

    if (!$code) {
        $query = $conn->prepare('INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)');
        $query->bind_param('ssssss', $pname, $pprice, $pimage, $pqty, $total_price, $pcode);
        $query->execute();

        echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Товар добавлен в вашу корзину!</strong>
						</div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Товар уже добавлен в вашу корзину!</strong>
						</div>';
    }
}

// Получить количество товаров, доступных в таблице корзины
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
    $stmt = $conn->prepare('SELECT * FROM cart');
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    echo $rows;
}

// Удаление отдельных товаров из корзины
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Товар удален из корзины!';
    header('location:cart.php');
}

// Удалить все товары сразу из корзины
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare('DELETE FROM cart');
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Все товары удалены из корзины!';
    header('location:cart.php');
}

// Установить общую цену товара в таблице корзины
if (isset($_POST['qty'])) {
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $tprice = $qty * $pprice;

    $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
    $stmt->bind_param('isi', $qty, $tprice, $pid);
    $stmt->execute();
}

// Оформить заказ и сохранить информацию о клиенте в таблице заказов
if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $grand_total = $_POST['grand_total'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];

    $data = '';

    $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssss', $name, $email, $phone, $address, $pmode, $products, $grand_total);
    $stmt->execute();
    $stmt2 = $conn->prepare('DELETE FROM cart');
    $stmt2->execute();
    $data .= '<div class="text-center">
								<h1 class="display-4 mt-2 text-danger">Спасибо!</h1>
								<h2 class="text-success">Ваша заявка успешно оформлена!</h2>
								<h4 class="bg-danger text-light rounded p-2">Товары в заявке: ' . $products . '</h4>
								<h4>Имя : ' . $name . '</h4>
								<h4>E-mail : ' . $email . '</h4>
								<h4>Телефон : ' . $phone . '</h4>
								<h4>Общая выплаченная сумма : ' . number_format($grand_total, 2) . '</h4>
								<h4>Способ оплаты : ' . $pmode . '</h4>
						  </div>';
    echo $data;
}
