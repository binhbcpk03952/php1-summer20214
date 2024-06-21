
<?php
    // include_once ('../../DBUntil.php');

    $dbHelper = new DBUntil();
    $errors = [];
    function validateUrl(string $url): bool {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        if(!isset($_POST['name']) || empty($_POST['name'])) {
                $errors['name'] = "Name is required <br>" ;
        }
        
        if(!isset($_POST['price']) || empty($_POST['price'])) {
            $errors['price'] = "price is required <br>" ;
        }
        elseif ($_POST['price'] < 1) {
            $errors['price'] = "price is smaller 0. <br>" ;
        }
    
        if(!isset($_POST['quantity']) || empty($_POST['quantity'])) {
            $errors['quantity'] = "quantity is required <br>" ;
        }
        elseif ($_POST['quantity'] < 1) {
            $errors['quantity'] = "quantity is smaller 0. <br>" ;
        }

        if(!isset($_POST['decription']) || empty($_POST['decription'])) {
            $errors['decription'] = "decription is required <br>" ;
        }
        if(!isset($_POST['idCategory']) || empty($_POST['idCategory'])) {
            $errors['idCategory'] = "idCategory is required <br>" ;
        }

        if (isset($_FILES['avatar']) && !$_FILES['avatar']['error'] > UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/image/";
            $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $IMAGE_TYPES = array('jpg', 'jpeg', 'png');
    
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $errors['avatar'] = "folder upload not found";
            }
    
            if (!in_array($imageFileType, $IMAGE_TYPES)) {  
                $errors['avatar'] = "avatar type must is image format";
            }
    
            if (
                $_FILES['avatar']["size"] > 1000000
            ) {
                $errors['avatar'] = "avatar too large";
            }
            // check type
    
            var_dump($imageFileType);
            /**
             *  type file allow image [jpeg, png, jpg]
             *  type size: 5M
             */
        } else {
            $avatar = null;
        }

        if (count($errors) === 0) {
            $avatar = null;
            // upload image to server
            if (isset($_FILES['avatar']) && !$_FILES['avatar']['error'] > UPLOAD_ERR_OK) {
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    $avatar = htmlspecialchars(basename($_FILES["avatar"]["name"]));
                    echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            $data = [
                'nameProduct' => $_POST['name'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
                'description' => $_POST['decription'],
                'linkImage' => $avatar,
                'idCategories' => $_POST['idCategory'],
            ];
            $isProduct = $dbHelper->insert('products', $data);
            header("Location: master.php?view=product_list");
        }
    }

    $products = $dbHelper->select("select * from products");
    $category = $dbHelper->select("SELECT * FROM categories");
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
        <h2>Products</h2>
        <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>
        <?php
            /**
             * crud product
             * id 
             * name
             * quantity
             * price
             * description
             * link image
             * idCategories
             */
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="">Name product</label>
                <input type="text" name="name" id=""
                class="form-control">
                <?php
                    if(isset($errors['name'])) {
                        echo "<span class='text-danger'>$errors[name] </span>";
                    }
                ?>
            </div>
            <div>
                <label for="">Price</label>
                <input type="text" name="price" id=""
                class="form-control">
                <?php
                    if(isset($errors['price'])) {
                        echo "<span class='text-danger'>$errors[price] </span>";
                    }
                ?>
            </div>
            <div>
                <label for="">Quantity</label>
                <input type="text" name="quantity" id=""
                class="form-control">
                <?php
                    if(isset($errors['quantity'])) {
                        echo "<span class='text-danger'>$errors[quantity] </span>";
                    }
                ?>
            </div>
            <div>
                <label for="">Description</label>
                <input type="text" name="decription" id=""
                class="form-control">
                <?php
                    if(isset($errors['decription'])) {
                        echo "<span class='text-danger'>$errors[decription] </span>";
                    }
                ?>
            </div>
            <div class="mt-3">
            <input type="file" class="form-control form-control-user"
                    id="exampleInputEmail" aria-describedby="emailHelp"
                    placeholder="Username" name="avatar"
                    >
                <?php
                    if(isset($errors['avatar'])) {
                        echo "<span  class='text-danger'>$errors[avatar] </span>";
                    }
                ?>
            </div>
            <div class="mt-3">
                <select name="idCategory" id="" class="form-select">
                    <option value="">Danh muc</option>
                    <?php
                        foreach ($category as $cat) {
                            echo 
                            '
                                <option value="'.htmlspecialchars($cat['idCategories']).'">'.htmlspecialchars($cat['nameCategories']).'</option>
                            ';
                        }
                    ?>
                </select>
                <?php
                    if(isset($errors['idCategory'])) {
                        echo "<span  class='text-danger'>$errors[idCategory] </span>";
                    }
                ?>
            </div>
            <button type="addproduct" class="btn btn-primary mt-3">ADD PRODUCT</button>
        </form>
    </div>

</body>

</html>
