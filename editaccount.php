<?php
include_once('./DBUntil.php');

$dbHelper = new DBUntil();
$errors = [];
$id = $_GET['id'];

// Ensure ID is numeric
if (!is_numeric($id)) {
    die("Invalid ID");
}

// Fetch the user data based on ID
$printValue = $dbHelper->select("SELECT * FROM users WHERE maKh = ?", array($id));
$printValue = $printValue[0];
function isCheckEmail($email, $id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT email FROM users WHERE email = ? AND maKh != ?", [$email, $id]);
    return count($result) > 0;
}

function isCheckUsername($username, $id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT username FROM users WHERE username = ? AND maKh != ?", [$username, $id]);
    return count($result) > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Username is required <br>";
    }
    elseif (isCheckUsername($_POST['username'], $id)) {
        $errors['username'] = "Username is ton tai <br>";
    }
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    elseif(isCheckEmail($_POST['email'], $id)) {
        $errors['email'] = "Invalid email ton tai";
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Password is required <br>";
    } elseif (strlen($_POST['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters long";
    }
    if (!isset($_POST['role']) || empty($_POST['role'])) {
        $errors['role'] = "Role is required ";
    }
    if (!isset($_POST['status']) || empty($_POST['status'])) {
        $errors['status'] = "Status is required <br>";
    }
    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $errors['phone'] = "Phone is required <br>";
    } elseif (!is_numeric($_POST['phone'])) {
        $errors['phone'] = "Phone must be a number <br>";
    } elseif (strlen($_POST['phone']) != 10) {
        $errors['phone'] = "Phone must be 10 digits long<br>";
    }
    if (!isset($_POST['address']) || empty($_POST['address'])) {
        $errors['address'] = "Address is required <br>";
    }

    if (count($errors) === 0) {
        $data = [
            'sdt' => $_POST['phone'],
            'diachi' => $_POST['address'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'role' => $_POST['role'],
            'status' => $_POST['status'],
            'email' => $_POST['email'],
        ];

        $isUpdate = $dbHelper->update('users', $data, "maKh = $id");
        if ($isUpdate) {
            header("Location: account.php");
            exit();
        } else {
            $errors['database'] = "Failed to update user";
        }
    }
}
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
        <section id="form-register mt-5">
            <div class="container">
                <div class="nav-form">
                    <button class="nav-login color-in mt-3" id="btn-register">UPDATE</button>
                </div>
                <hr>
                <div class="flex-center">
                    <div class="all-form-register mt-4">
                        <div class="form-sign-in">
                            <!-- <p class="form-title">Sign-Up With Social</p>
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
                            </div> -->
                            <!-- <p class="form-title">Or Sign-Up With Email</p>
                            <hr class="mb-4"> -->
                            <!-- form -->
                            <form action="editaccount.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
                                <!-- username -->
                                <div class="username mb-3">
                                    <?php $username = ""; ?>
                                    <input type="text" class="inp-value" name="username" id="inp-name" 
                                    placeholder="Your Username" <?php echo $username; ?> value="<?php echo htmlspecialchars($printValue['username']); ?>">
                                    <?php
                                        if(isset($errors['username'])) {
                                            echo "<span class='text-danger'>$errors[username] </span>";
                                        }
                                    ?>
                                </div>
                                <!-- email -->
                                <div class="email mb-3">
                                    <?php $email = ""; ?>
                                    <input type="email" class="inp-value" name="email" id="inp-email-regis"
                                    placeholder="Your Email Address" <?php echo $email; ?> value="<?php echo htmlspecialchars($printValue['email']); ?>">
                                    <?php
                                        if(isset($errors['email'])) {
                                            echo "<span class='text-danger'>$errors[email] </span>";
                                        }
                                    ?>
                                </div>
                                <!-- password -->
                                <div class="password mb-3">
                                    <?php $password=""; ?>
                                    <input type="text" class="inp-value" name="password" id="inp-pass-regis" 
                                    placeholder="Set Your Password" <?php echo $password; ?> value="<?php echo htmlspecialchars($printValue['password']); ?>">
                                    <?php
                                        if(isset($errors['password'])) {
                                            echo "<span class='text-danger'>$errors[password] </span>";
                                        }
                                    ?>                                                              
                                </div>
                                <!-- address -->
                                <div class="address mb-3">
                                    <?php $address = ""; ?>
                                    <input type="text" class="inp-value mb-3" name="address" id="address" 
                                    placeholder="Your Address" <?php echo $address; ?> value="<?php echo htmlspecialchars($printValue['diachi']); ?>">
                                    <?php
                                        if(isset($errors['address'])) {
                                            echo "<span class='text-danger'>$errors[address] </span>";
                                        }
                                    ?>
                                </div>
                                <!-- phone -->
                                <div class="phone mb-3">
                                    <?php $phone=""; ?>
                                    <input type="text" class="inp-value mb-3" name="phone" id="phone" 
                                    placeholder="Your Phone" <?php echo $phone; ?> value="<?php echo htmlspecialchars($printValue['sdt']); ?>">
                                    <?php
                                        if(isset($errors['phone'])) {
                                            echo "<span class='text-danger'>$errors[phone] </span>";
                                        }
                                    ?>
                                </div>
                                <!-- role -->
                                    <div class="role mb-3">
                                    <?php $role = ""; ?>
                                    <select class=" inp-value" name="role" id="role"  <?php echo $role; ?>>
                                        <?php
                                            if ($printValue['role'] == 'admin') {
                                                echo '<option value="' . htmlspecialchars($printValue['role']) . '">'.htmlspecialchars($printValue['role']) .'</option>';
                                                echo '<option value="user">User</option>';
                                            }
                                            else {
                                                echo '<option value="' . htmlspecialchars($printValue['role']) . '">'.htmlspecialchars($printValue['role']).'</option>';
                                                echo '<option value="admin">Admin</option>';
                                            }
                                        ?>
                                    </select>
                                    <?php
                                        if(isset($errors['role'])) {
                                            echo "<span class='text-danger'>$errors[role] </span>";
                                        }
                                    ?>
                                </div>
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
                                <!-- <div class="remmember-forgot mt-4">
                                    <div class="remmeber">
                                        <input type="checkbox" name="" id="remmeber-me">
                                        <label for="">Remember Me</label>
                                    </div>
                                    <div class="forgot-pass">
                                        <a href="#">Forgot Password?</a>
                                    </div>
                                </div> -->
                                <button type="update" class="login mt-4 mb-3">UPDATE</button>
                                <?php if (isset($errors['general'])) echo "<span class='text-danger'>{$errors['general']}</span>; "?>
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