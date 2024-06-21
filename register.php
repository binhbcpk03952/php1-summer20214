
<?php
    include_once ('./DBUntil.php');
    
    $dbHelper = new DBUntil();
    $errors = [];
    $searchTerm = '';
    function ischeckmail($email) {
        $dbHelper = new DBUntil();
        $email =  $dbHelper->select("SELECT email FROM users WHERE email = ?", [$email]);
        if (count($email) > 0) {
            return true;
        }
        return false;
    }

    function isCheckUsername ($isUser) {
        $dbHelper = new DBUntil();
        $isUser = $dbHelper->select("SELECT username FROM users WHERE username = ?", [$isUser]);
        if (count($isUser) > 0) {
            return true;
        }
        return false;
    }
    // if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    //     $searchQuery = $_GET['search'];
    //     $users = $dbHelper->select("SELECT * FROM users WHERE username LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%'");
    //     foreach ($users as $us) {
    //             echo "<tr>";
    //             echo "<td>$us[maKh]</td>";
    //             echo "<td>$us[username]</td>";
    //             echo "<td>$us[password]</td>";
    //             echo "<td>$us[email]</td>";
    //             echo "<td>$us[role]</td>";
    //             echo "<td>$us[status]</td>";
    //             echo "<td>$us[sdt]</td>";
    //             echo "<td>$us[diachi]</td>";
    //             echo "<td> <a href='delete.php?id=$us[maKh]'>remove</a></td>";
    //             echo "<td> <a href='edit.php?id=$us[maKh]'>edit</a></td>";
    //             echo "</tr>";
    //         }
    // } else {
    //     $users = $dbHelper->select("SELECT * FROM users");
    // }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['username'])) {
            if(empty($_POST['username'])) {
                $errors['username'] = "username is required <br>";
            }
            elseif(isCheckUsername($_POST['username'])) {
                $errors['username'] = "username da ton tai";
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
                    if (ischeckmail($_POST["email"])) {
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
    
        if (count($errors) == 0) {
            $users = $dbHelper->select("SELECT * FROM users");
            $data = [
                'sdt' => $_POST['phone'],
                'diachi' => $_POST['address'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'role' => $_POST['role'],
                'status' => $_POST['status'],
                'email' => $_POST['email'],
            ];
            $isProduct = $dbHelper->insert('users', $data);
            unset($_POST);
            echo '<script>alert("Tài khoản đã được đăng ký thành công!");</script>';
            header('Location: login.php');
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Waggy - Free eCommerce Pet Shop HTML Website Template</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <link
            href="https://fonts.googleapis.com/css2?family=Chilanka&amp;family=Montserrat:wght@300;400;500&amp;display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/account.css">
    </head>
    <body>
        
        <!-- main -->
        <section id="form-register">
            <div class="container">
                <div class="nav-form">
                    <button class="nav-login color-in" id="btn-register">REGISTER</button>
                </div>
                <hr>
                <div class="flex-center">
                    <div class="all-form-register mt-5">
                        <div class="form-sign-in">
                            <p class="form-title">Sign-Up With Social</p>
                            <hr class="mb-3">
                            <div class="log-in-with">
                                <button class="with-google">
                                    <i class="fa-brands fa-google"></i>
                                    GOOGLE
                                </button>
                                <button class="with-facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                    FACEBOOK
                                </button>
                            </div>
                            <p class="form-title mt-5">Or Sign-Up With Email</p>
                            <hr class="mb-4">
                            <!-- form -->
                            <form action="register.php" method="POST">
                                <!-- username -->
                                <div class="username">
                                    <?php $username = ""; ?>
                                    <input type="text" class="inp-value mb-3" name="username" id="inp-name" 
                                    placeholder="Your Username" <?php echo $username; ?>>
                                    <?php
                                        if(isset($errors['username'])) {
                                            echo "<span class='text-danger'>$errors[username] </span>";
                                        }
                                    ?>
                                </div>
                                <!-- email -->
                                <div class="email">
                                    <?php $email = ""; ?>
                                    <input type="email" class="inp-value mb-3" name="email" id="inp-email-regis"
                                    placeholder="Your Email Address" <?php echo $email; ?>>
                                    <?php
                                        if(isset($errors['email'])) {
                                            echo "<span class='text-danger'>$errors[email] </span>";
                                        }
                                    ?>
                                </div>
                                <!-- password -->
                                <?php $password=""; ?>
                                <input type="password" class="inp-value mb-3" name="password" id="inp-pass-regis" 
                                placeholder="Set Your Password" <?php echo $password; ?>>
                                <?php
                                    if(isset($errors['password'])) {
                                        echo "<span class='text-danger'>$errors[password] </span>";
                                    }
                                ?>
                                <!-- address -->
                                <?php $address = ""; ?>
                                <input type="text" class="inp-value mb-3" name="address" id="address" 
                                placeholder="Your Address" <?php echo $address; ?>>
                                <?php
                                    if(isset($errors['address'])) {
                                        echo "<span class='text-danger'>$errors[address] </span>";
                                    }
                                ?>
                                <!-- phone -->
                                <?php $phone=""; ?>
                                <input type="text" class="inp-value mb-3" name="phone" id="phone" 
                                placeholder="Your Phone" <?php echo $phone; ?>>
                                <?php
                                    if(isset($errors['phone'])) {
                                        echo "<span class='text-danger'>$errors[phone] </span>";
                                    }
                                ?>
                                <!-- role -->
                                <?php $role = ""; ?>
                                <select class=" inp-value" name="role" id="role"  <?php echo $role; ?>>
                                    <option value="">Select role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <?php
                                    if(isset($errors['role'])) {
                                        echo "<span class='text-danger'>$errors[role] </span>";
                                    }
                                ?>
                                <div class="mb-3">
                                    <label class="form-check-label mt-3 fs-5 fw-bold"> Account Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="1" id="status1" checked>
                                        <label class="form-check-label fs-5" for="status1">
                                            Allow activity
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="0" id="status2">
                                        <label class="form-check-label fs-5" for="flexRadioDefault2">
                                            Lock account
                                        </label>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="remmember-forgot mt-4">
                                    <div class="remmeber">
                                        <input type="checkbox" name="" id="remmeber-me">
                                        <label for="">Remember Me</label>
                                    </div>
                                    <div class="forgot-pass">
                                        <a href="#">Forgot Password?</a>
                                    </div>
                                </div>
                                <button class="login mt-4 mb-5">REGISTER</button>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </section>

        <!-- footer -->

        
        <script src="https://kit.fontawesome.com/121f50087c.js"
            crossorigin="anonymous"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
              lucide.createIcons();
            </script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="js/validateForm.js"></script> -->
    </body>
</html>