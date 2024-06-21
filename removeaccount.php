<?php
include_once ('./DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("users", "maKh = $id");
header("Location: index.php?view=cart_list");  