<?php
    $dbHelper = new DBUntil();
    $errors = [];
    $id = $_GET['id'];
    $data = [
        'statusOrder' => 3,
    ]; 
    $isUpdate = $dbHelper->update('orders', $data, "idOrder = $id");
        if ($isUpdate) {
            header("Location: master.php?view=order_list");
            exit();
        } else {
            $errors['database'] = "Failed to update user";
        }
?>