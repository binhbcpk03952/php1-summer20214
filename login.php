<?php
include_once ("./DBUntil.php");
$dbHelper = new DBUntil();
session_start();
$errors = [];
$username = "";
$password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Username is required.";
    } else {
        $username = $_POST['username'];
    }

    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($_POST['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    } else {
        $password = $_POST['password'];
    }

    if (count($errors) == 0) {
        $query = $dbHelper->select("SELECT maKh, username, password  FROM users");
        // var_dump($query);
        if (count($query) > 0) {
            foreach ($query as $query) {
                if ($query['username'] == $username && $query['password'] == $password) {
                    // Redirect user after successful login
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $query['maKh'];
                    echo $_SESSION['id'];
                    header('Location: index.php');
                    exit();
                } else {
                    $errors['login'] = "Invalid username or password.";
                }
            }
        }
         else {
            $errors['login'] = "Invalid username or password.";
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

        <section id="form-register" class="mb-5 mt-3">
            <div class="container">
                <div class="nav-form">
                    <button class="nav-login color-in" id="btn-login">LOG IN</button>
                </div>
                <hr>
                <div class="flex-center">
                    <div class="all-form-login mt-3">
                        <div class="form-log-in">
                            <p class="form-title">Log-In With Social</p>
                            <hr>
                            <div class="log-in-with mt-3 mb-5">
                                <button class="with-google">
                                    <i class="fa-brands fa-google"></i>
                                    GOOGLE
                                </button>
                                <button class="with-facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                    FACEBOOK
                                </button>
                            </div>
                            <p class="form-title">Log-In With Email</p>
                            <hr class="mb-4">
                            <form action="login.php" method="POST">
                                <div class="username mb-3">
                                    <input type="text" class="inp-value" name="username" id="inp-email" 
                                    placeholder="Enter Your Username">
                                    <?php
                                        if (isset($errors['username'])) {
                                            echo "<span class='text-danger'>{$errors['username']}</span>";
                                        }
                                    ?>
                                </div>
                                <div class="password  mb-3">
                                    <input type="password" class="inp-value"  name="password" id="inp-pass" 
                                    placeholder="Enter Password">
                                    <?php
                                        if (isset($errors['password'])) {
                                            echo "<span class='text-danger'>{$errors['password']}</span>";
                                        }
                                    ?>
                                </div>
                                <div class="remmember-forgot mt-4">
                                    <div class="remmeber">
                                        <input type="checkbox" name="" id="remmeber-me">
                                        <label for="">Remember Me</label>
                                    </div>
                                    <div class="forgot-pass">
                                        <a href="register.php">Sign in?</a>
                                    </div>
                                </div>
                                <?php
                                    if (isset($errors['login'])) {
                                        echo "<span class='text-danger'>{$errors['login']}</span>";
                                    }
                                ?>
                                <button class="login mt-4">LOGIN</button>
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