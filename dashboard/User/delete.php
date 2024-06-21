<?php
// include_once ('../../DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("users", "maKh = $id");
header("master.php?view=user_list");