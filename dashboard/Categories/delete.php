<?php
include_once ('../../DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("categories", "idCategories = $id");
header("Location:  master.php?view=category_list");