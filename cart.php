<?php 
    // session_start();
    include_once('./DBUntil.php');

    $dbHelper = new DBUntil();
    $errors = [];
    $carts = $dbHelper->select("SELECT * FROM cart CA INNER JOIN products PR ON CA.idProduct = PR.idProduct");
    // var_dump($carts);
    function getTotal()
    {
        global $dbHelper;
        $carts = $dbHelper->select("SELECT * FROM cart CA INNER JOIN products PR ON CA.idProduct = PR.idProduct");
        $sum = 0;
        foreach ($carts as $cart) {
            $sum += $cart['price'] * $cart['quantityCart'];
        }
        return $sum;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
            $code = $_POST['code'];
            $dateArray = getdate();
            $currentDate = sprintf('%04d-%02d-%02d', $dateArray['year'], $dateArray['mon'], $dateArray['mday']);

            $coupon = $dbHelper->select("SELECT * FROM coupons");
            $discount = 0;
            $isDiscount = 0;
            foreach ($coupon as $cou) {
                echo $cou['endDate'];
                if ($code == $cou['code'] && $currentDate < $cou['endDate']) {
                    $discount = $cou['discount'];
                }
                else {
                    $errors['code'] = "Discount is null or end time";
                }
            }
            $isDiscount = getTotal() * ($discount / 100 );
            
    }
    global $isDiscount;
    $total = getTotal() - $isDiscount;
    $_SESSION['totalPrice'] = $total;
?>

<!DOCTYPE html>
<html lang="en">
    <?php include ('./include/head.php') ?>
    <body>
        <!-- <?php include ('./include/header.php') ?> -->
        <section class="banner-contact">
            <div class="container banner-items">
                <h2>Cart</h2>
                <nav class="breadcrumb">
                    <a href="index.html"
                        class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Cart</span>
                </nav>
            </div>
        </section>
        <!-- main -->

        <section id="cart">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8 custom-padding">
                        <table class="table p-3">
                            <thead>
                                <tr>
                                    <th class="align-middle">PRODUCT</th>
                                    <th class="align-middle">QUANTITY</th>
                                    <th class="align-middle">SUBTUTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($carts as $cart) {
                                        echo 
                                        '
                                            <tr>
                                                <td class="py-4 align-middle">
                                                    <div class="cart-info d-md-flex flex-wrap align-items-center">
                                                        <div class="col-lg-3">
                                                            <div class="cart-image">
                                                                <img src="http://localhost/AsignmentPHP/dashboard/products/image/'. htmlspecialchars($cart['linkImage']).'" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <div class="cart-detail">
                                                                <h5 class="cart-title">
                                                                    <a href="./detail.php?id='.htmlspecialchars($cart['idProduct']).'" class="text-decoration-none">'.htmlspecialchars($cart['nameProduct']).'</a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 align-middle">
                                                    <div class="cart-quantity d-md-flex align-items-center">
                                                        <input type="number" name="" class="cart-quantity" value="'.htmlspecialchars($cart['quantityCart']) .'">
                                                    </div>
                                                </td>
                                                <td class="py-4 align-middle replace-font">
                                                    $'.htmlspecialchars($cart['price']).'
                                                </td>
                                                <td class="py-4 align-middle">
                                                    <a href="delete-cart.php?id='.htmlspecialchars($cart['idCart']).'" class="cart-remove text-danger">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        ';
                                    }
                                ?>
                                <!-- 1 -->
                                
                                <!-- 2 -->
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 custom-padding">
                        <div class="cart-total">
                            <h2 class="pb-4">Cart Total</h2>
                            <form class="coupon-form" action="" method="POST">
                                <input name="code" class="form-control form-control-sm" type="text" placeholder="Coupon code" required="">
                                <button class="btn btn-outline-primary btn-sm" name="action" value="checkCode" type="submit">Apply
                                    Coupon
                                </button>
                                <?php if (isset($errors['code'])){
                                    echo "<span>{$errors['code']}</span>";
                                } else {
                                    global $discount;
                                    echo ($discount)."%";
                                } ?>
                            </form>

                            <div class="total-price pb-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td>
                                                <span class="subtotal-price"><?php echo getTotal(); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>DISCOUNT</th>
                                            <td>
                                                <span class="total-price"><?php global $discount; 
                                                                                global $isDiscount; 
                                                                                echo $isDiscount; ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td>
                                                <span class="total-price"><?php global $total; echo $total;?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <form action="checkout.php" method="POST" class="col-md-12 mt-1">
                                    <input type="hidden" name="total" id="" value="<?php echo $_SESSION['totalPrice']; ?>">
                                    <button class="btn check-out text-uppercase p-3 w-100">Proceed to checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- end -->
        
        <?php include ('./include/footer.php') ?>
    </body>
</html>