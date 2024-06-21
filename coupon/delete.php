
<?php
include_once('../DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("categories", "id = $id");
header("Location: index.php");
