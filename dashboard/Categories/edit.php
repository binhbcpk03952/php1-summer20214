<?php
// include_once('../../DBUntil.php');

$dbHelper = new DBUntil();
$errors = [];
$id = $_GET['id'];
function isCheckCate($categories, $id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT nameCategories FROM categories WHERE nameCategories = ? AND idCategories != ?", [$categories, $id]);
    return count($result) > 0;
}

// Fetch the user data based on ID
$detail = $dbHelper->select("SELECT * FROM categories WHERE idCategories = ?", array($id))[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["name"]) || empty($_POST["name"])) {
        $errors['name'] = "Tên danh mục không được để trống";
        
    }
    elseif(isCheckCate($_POST['name'], $id)) {
        $errors['name'] = "Tên danh mục đã tồn tại";
    }
    if (count ($errors) == 0) {
        $isUpdate = $dbHelper->update('categories', array('nameCategories' => $_POST['name']), "idCategories = $id");
        if ($isUpdate) {
            header("Location: master.php?view=category_list");

            exit();
            
        } 
        else {
            $errors['database'] = "Failed to update user";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Categories</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Edit Categories</h2>
        <form action="" method="post">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" 
                value="<?php echo htmlspecialchars($detail['nameCategories']); ?>" placeholder="Tên danh mục">
                <?php
                    if (isset($errors['name'])) {
                        echo "<span class='text-danger'>{$errors['name']}</span>";
                    }   
                ?>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-warning" value="Cập nhật">
            </div>
        </form>
    </div>

</body>

</html>