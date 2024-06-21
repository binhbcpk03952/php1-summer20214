<?php
include_once ('./DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("cart", "idCart = $id");
header("location: ./index.php?view=cart_list");