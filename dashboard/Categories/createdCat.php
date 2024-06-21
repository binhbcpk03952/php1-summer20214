
<?php
// include ('../../DBUntil.php');

    $dbHelper = new DBUntil();
    $errors = [];
    function isCheckCate($name) {
        global $dbHelper;
        $result = $dbHelper->select("SELECT nameCategories FROM categories WHERE nameCategories=?", [$name]);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        if(!isset($_POST['name']) || empty($_POST['name'])) {
                $errors['name'] = "Name is required <br>" ;
        }
        elseif (isCheckCate($_POST['name'])) {
            $errors['name'] = "Name is ton tai <br>" ;
        }
        var_dump($_POST);

        if (count($errors) == 0) {
            $lastInsertId = $dbHelper->insert('categories', array('nameCategories' => $_POST['name'],));
            header('Location: master.php?view=category_list');
            unset($_POST['name']);

        }
    }

    $categories = $dbHelper->select("select * from categories");
    // var_dump($categories);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>categories</h2>
        <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>
        <form action="" method="POST">
            <input class="form-control" type="text" name="name" placeholder="Ten Danh Muc">
            <?php
                if(isset($errors['name'])) {
                    echo "<span class='text-danger'>$errors[name] </span>";
                }
            ?>
            <button type="submit" class="btn btn-primary fw-bold  mt-3">Add</button>
        </form>
    </div>

</body>

</html>
