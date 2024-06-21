<?php
    $dbHelper = new DBUntil();
    $errors = [];
    $id = $_GET['id'];
    $data = [
        'statusOrder' => 7,
    ]; 
    $isUpdate = $dbHelper->update('orders', $data, "idOrder = $id");

        $urlBack = $_SERVER['HTTP_REFERER'];
        echo $urlBack;
        if ($isUpdate) {
            if ($urlBack == "http://localhost/AsignmentPHP/order.php") {
                header("Location: http://localhost/AsignmentPHP/order.php");
                exit();
            }
            else {
                header("Location: master.php?view=order_list");
                exit();
            }           
        } else {
            $errors['database'] = "Failed to update user";
        }
        // die();
?>