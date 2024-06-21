<?php
session_start();
include_once './DBUntil.php';

$dbHelper = new DBUntil();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-to-cart'])) {
    $idProduct = $_POST['idProduct']; 
    $idUser = $_SESSION['id'];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $isCheck = $dbHelper->select('SELECT * FROM cart WHERE maKh = :maKh AND idProduct = :id', ['maKh' => $idUser, 'id' => $idProduct]);

    if ($isCheck) {
        $quantity = $isCheck[0]['quantityCart'] + 1;
        $condition = "maKh = $idUser AND idProduct = $idProduct";
        $updateCart = $dbHelper->update('cart', ['quantityCart' => $quantity], $condition);
    } else {
        $data = [
            'maKh' => $idUser,
            'idProduct' => $idProduct,
            'quantityCart' => 1,
        ];
        $addCart = $dbHelper->insert('cart', $data);
    }

    header("Location: index.php?view=cart_list");
    exit();
}
?>
