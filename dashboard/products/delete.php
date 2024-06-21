<?php
// include_once ('../../DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("products", "idProduct = $id");
header("Location: master.php?view=product_list");