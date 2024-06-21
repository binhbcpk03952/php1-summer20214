<?php
// include_once('../../DBUntil.php');

$dbHelper = new DBUntil();
$errors = [];
$id = $_GET['id'];
$id = (int)$id;

// Fetch the user data based on ID
$detail = $dbHelper->select("SELECT * FROM products WHERE idProduct = ?", array($id));
$detail = $detail[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['name'] = "Name is required <br>";
    }

    if (!isset($_POST['price']) || empty($_POST['price'])) {
        $errors['price'] = "Price is required <br>";
    }

    if (!isset($_POST['quantity']) || empty($_POST['quantity'])) {
        $errors['quantity'] = "Quantity is required <br>";
    }

    if (!isset($_POST['decription']) || empty($_POST['decription'])) {
        $errors['decription'] = "Description is required <br>";
    }

    if (!isset($_FILES['linkImage']) || $_FILES['linkImage']['error'] !== UPLOAD_ERR_OK) {
        $errors['linkImage'] = "Image upload is required <br>";
    }

    if (count($errors) === 0) {
        // Handle the file upload
        $targetDir = "";
        $fileName = basename($_FILES["linkImage"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["linkImage"]["tmp_name"], $targetFilePath)) {
                $data = [
                    'nameProduct' => $_POST['name'],
                    'price' => $_POST['price'],
                    'quantity' => $_POST['quantity'],
                    'description' => $_POST['decription'],
                    'linkImage' => $targetFilePath,
                ];

                $isUpdate = $dbHelper->update('products', $data, "idProduct = $id");
                if ($isUpdate) {
                    header("Location: master.php?view=product_list");
                    exit();
                } else {
                    $errors['database'] = "Failed to update user";
                }
            } else {
                $errors['linkImage'] = "Sorry, there was an error uploading your file.";
            }
        } else {
            $errors['linkImage'] = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-3">
        <h2>Edit Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="">Name Product</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($detail['nameProduct']); ?>">
                <?php if (isset($errors['name'])) { echo "<span class='text-danger'>$errors[name] </span>"; } ?>
            </div>
            <div>
                <label for="">Price</label>
                <input type="text" name="price" class="form-control" value="<?php echo htmlspecialchars($detail['price']); ?>">
                <?php if (isset($errors['price'])) { echo "<span class='text-danger'>$errors[price] </span>"; } ?>
            </div>
            <div>
                <label for="">Quantity</label>
                <input type="text" name="quantity" class="form-control" value="<?php echo htmlspecialchars($detail['quantity']); ?>">
                <?php if (isset($errors['quantity'])) { echo "<span class='text-danger'>$errors[quantity] </span>"; } ?>
            </div>
            <div>
                <label for="">Description</label>
                <input type="text" name="decription" class="form-control" value="<?php echo htmlspecialchars($detail['description']); ?>">
                <?php if (isset($errors['decription'])) { echo "<span class='text-danger'>$errors[decription] </span>"; } ?>
            </div>
            <div>
                <label for="">Link Image</label>
                <input type="file" name="linkImage" class="form-control">
                <?php if (isset($errors['linkImage'])) { echo "<span class='text-danger'>$errors[linkImage] </span>"; } ?>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Product</button>
        </form>
    </div>
</body>
</html>