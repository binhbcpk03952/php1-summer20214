


<?php
    // include_once ('../../DBUntil.php');
    
    $dbHelper = new DBUntil();
    $errors = [];
    $searchTerm = '';
    function isCheckEmail($email) {
        global $dbHelper;
        $result = $dbHelper->select("SELECT email FROM users WHERE email = ?", [$email]);
        return count($result) > 0;
    }
    
    function isCheckUsername($username) {
        global $dbHelper;
        $result = $dbHelper->select("SELECT username FROM users WHERE username = ?", [$username]);
        return count($result) > 0;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
        $searchQuery = $_GET['search'];
        $users = $dbHelper->select("SELECT * FROM users WHERE username LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%'");
        foreach ($users as $us) {
                echo "<tr>";
                echo "<td>$us[maKh]</td>";
                echo "<td>$us[username]</td>";
                echo "<td>$us[password]</td>";
                echo "<td>$us[email]</td>";
                echo "<td>$us[role]</td>";
                echo "<td>$us[status]</td>";
                echo "<td>$us[sdt]</td>";
                echo "<td>$us[diachi]</td>";
                echo "<td> <a href='delete.php?id=$us[maKh]'>remove</a></td>";
                echo "<td> <a href='edit.php?id=$us[maKh]'>edit</a></td>";
                echo "</tr>";
            }
    } else {
        $users = $dbHelper->select("SELECT * FROM users");
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['username'])) {
            if(empty($_POST['username'])) {
                $errors['username'] = "username is required <br>";
            }
            elseif (isCheckUsername($_POST['username'])) {
                $errors['username'] = "username is ton tai <br>";
            }
        }
        if (isset($_POST['email'])) {
            if (empty($_POST['email'])) {
                $errors['email'] = "email is required";
            }
            else {
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = "Invalid email format";
                } else {
                    if (isCheckEmail($_POST["email"])) {
                        $errors['email'] = "email da ton tai";
                    } else {
                        $email = $_POST['email'];
                    }
                }
            }
        }
        if(isset($_POST['password'])) {
            if(empty($_POST['password'])) {
                $errors['password'] = "password is required <br>";
            }
            else {
                if(strlen($_POST['password']) < 6) {
                    $errors['password'] = "Password must be at least 6 characters long";
                }
            }
            if (isset($_POST['passwordconfirm'])) {
                if (empty($_POST['passwordconfirm'])) {
                    $errors['passwordconfirm'] = "password confirm is required";
                }
                else {
                    if ($_POST['passwordconfirm'] != $_POST['password']) {
                        $errors['passconfirm'] = "password confirm not the same password";
                    }
                }
            }
        }
        if (isset($_POST['role'])) {
            if (empty($_POST['role'])) {
                $errors['role'] = "role is required ";
            }
        }
        if(isset($_POST['status'])) {
            if(empty($_POST['status'])) {
                $errors['status'] = "status is required <br>";
            }
        }
        if(isset($_POST['phone'])) {
            if(empty($_POST['phone'])) {
                $errors['phone'] = "phone is required <br>";
            }
            elseif( !is_numeric($_POST['phone'])) {
                $errors['phone'] = "phone isn't number <br>";
            }
            elseif(strlen($_POST['phone']) != 10) {
                $errors['phone'] = "phone is null<br>";
            }
        }
        if(isset($_POST['address'])) {
            if(empty($_POST['address'])) {
                $errors['address'] = "address is required <br>";
            }
        }
        if (isset($_FILES['avatar']) && !$_FILES['avatar']['error'] > UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/upload/";
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
    
        if (count($errors) == 0) {
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
                'sdt' => $_POST['phone'],
                'diachi' => $_POST['address'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'role' => $_POST['role'],
                'status' => $_POST['status'],
                'email' => $_POST['email'],
                'avatar' => $avatar,
            ];
            $isProduct = $dbHelper->insert('users', $data);
            unset($_POST);
            header('location: master.php?view=user_list');
        }
    }


    if (!empty($searchTerm)) {
        $users = $dbHelper->select("SELECT * FROM users WHERE username LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'");
        var_dump($user);
    } else {
        $users = $dbHelper->select("SELECT * FROM users");
    }
    // var_dump($_POST);   
    // $users = $dbHelper->select("select * from users");
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
        <h2>User</h2>
        <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>
        <form class="mb-3" action="index.php" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by username or email" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>
               
       <form class="user" action="created.php" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <?php 
                    $username = "";
                    // var_dump($errors);
                ?>
                    <input type="text" class="form-control form-control-user"
                        id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Username" name="username"
                        <?php echo $username; ?>>
                    <?php
                        if(isset($errors['username'])) {
                            echo "<span class='text-danger'>$errors[username] </span>";
                        }
                    ?>
                </div>
            <div class="form-group mb-3">
                <?php 
                    $avatar = "";
                    // var_dump($errors);
                ?>
                <input type="file" class="form-control form-control-user"
                    id="exampleInputEmail" aria-describedby="emailHelp"
                    placeholder="Username" name="avatar"
                    <?php echo $avatar; ?>>
                <?php
                    if(isset($errors['avatar'])) {
                        echo "<span  class='text-danger'>$errors[avatar] </span>";
                    }
                ?>
            </div>
            <div class="form-group mb-3">
                <?php 
                    $email = "";
                ?>
                <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Email Address" name="email" <?php echo $email; ?>>
                    <?php
                        if(isset($errors['email'])) {
                            echo "<span class='text-danger'>$errors[email] </span>";
                        }
                    ?>
            </div>
            <div class="form-group row mb-3">
                <div class="col-sm-6 mb-3 mb-sm-0">
                <?php 
                    $password = "";
                ?>
                    <input type="password" class="form-control form-control-user"
                        id="exampleInputPassword" placeholder="Password" name="password" <?php echo $password; ?>>
                        <?php
                            if(isset($errors['password'])) {
                                echo "<span class='text-danger'>$errors[password] </span>";
                            }
                        ?>
                </div>
                <div class="col-sm-6">
                <?php 
                        $passwordconfirm = "";
                    ?>
                    <input type="password" class="form-control form-control-user"
                        id="exampleRepeatPassword" placeholder="Repeat Password" name="passwordconfirm" <?php echo $passwordconfirm; ?>>
                        <?php
                            if(isset($errors['passwordconfirm'])) {
                                echo "<span class='text-danger'>$errors[passwordconfirm] </span>";
                            }
                        ?>
                </div>
            </div>
            <div class="form-group mb-3">
                <?php 
                    $address = "";
                ?>
                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="diachi" name="address" <?php echo $address; ?>>
                    <?php
                        if(isset($errors['address'])) {
                            echo "<span class='text-danger'>$errors[address] </span>";
                        }
                    ?>
            </div>
            <div class="form-group mb-3">
                <?php 
                    $phone = "";
                ?>
                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Phone" name="phone" <?php echo $phone; ?>>
                    <?php
                        if(isset($errors['phone'])) {
                            echo "<span class='text-danger'>$errors[phone] </span>";
                        }
                    ?>
            </div>
            <div class="">
                <?php $role = ""; ?>
                <select class="mb-3 form-select" name="role" id=""  <?php echo $role; ?>>
                    <option value="">Chọn quyền</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <?php
                    if(isset($errors['role'])) {
                        echo "<span class='text-danger'>$errors[role]<br> </span>";
                    }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-check-label mt-3">Trạng thái tài khoản:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="1" id="status1" checked>
                    <label class="form-check-label" for="status1">
                        cho phép hoạt động
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="0" id="status2">
                    <label class="form-check-label" for="flexRadioDefault2">
                        khóa tài khoản
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Register Account
            </button>
        </form>
    </div>

</body>

</html>
