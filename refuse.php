<?php
    include_once('./DBUntil.php');
    $dbHelper = new DBUntil();
    $errors = [];
    $id = $_GET['id'];
    $data = [
        'statusOrder' => 7,
    ]; 
    $isUpdate = $dbHelper->update('orders', $data, "idOrder = $id");
        if ($isUpdate) {
           
                header("Location: ./order.php");
                exit();
        } else {
            $errors['database'] = "Failed to update user";
        }
?>