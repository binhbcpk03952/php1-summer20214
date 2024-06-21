<?php
    session_start();
    include_once('./DBUntil.php');
    $dbHelper = new DBUntil();
    if(!isset($_SESSION['username'])) {
        header('location: login.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
    <?php include_once('./include/head.php') ?>
    <body>
        <!-- header -->
        <?php include_once('./include/header.php') ?>
        <!-- main -->
        <?php   
            include_once('./Message.php');
            $view = isset($_GET['view']) ? $_GET['view'] : 'index';
            // var_dump($view);
            switch ($view) {
                case 'shop_list':
                    include_once('./shop.php');
                break;
                case 'cart_list':
                    include_once('./cart.php');
                break;
                case 'order_list':
                    include_once('./order.php');
                break;
                case 'dashboard':
                    include_once('./dashboard/master.php');
                break;
            }
        
        ?>

        <?php include_once('./include/main-index.php') ?>
        <!-- footer  -->
        <?php include_once('./include/footer.php') ?>
    </body>
</html>