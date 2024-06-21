<?php
    session_start();
    include_once('./DBUntil.php');
    $dbHelper = new DBUntil();
    $isOrder = $_GET['id'];
    echo $isOrder;

    $details = $dbHelper->select("SELECT * FROM orders OD
                                 INNER JOIN detailOrder DO ON OD.idOrder = DO.idOrder
                                 INNER JOIN products PR ON DO.idProduct = PR.idProduct 
                                 WHERE OD.idOrder = $isOrder");
    // var_dump($details);
?>

<!DOCTYPE html>
<html lang="en">
    <?php include_once('./include/head.php') ?>
    <style>
        .historyOrder {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
    <body>
        <!-- header -->
        <?php include_once('./include/header.php') ?>
        <!-- main -->
        <section class="banner-contact">
            <div class="container banner-items">
                <h2>Order Detail</h2>
                <nav class="breadcrumb">
                    <a href="index.html" class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Order Detail</span>
                </nav>
            </div>
        </section>

        <section class="mt-5">
            <div class="container">
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="align-middle">PRODUCT</th>
                                <th class="align-middle">QUANTITY</th>
                                <th class="align-middle">SUBTUTAL</th>
                                <th class="align-middle">TRANG THAI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $detail) { ?>
                                <tr>
                                    <td class="py-4 align-middle">
                                        <div class="cart-info d-md-flex flex-wrap align-items-center">
                                            <div class="col-lg-3">
                                                <div class="cart-image">
                                                    <img src="http://localhost/AsignmentPHP/dashboard/products/image/<?php echo htmlspecialchars($detail['linkImage']) ?>" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="cart-detail">
                                                    <h5 class="cart-title">
                                                        <a href="./detail.php?id=<?php echo htmlspecialchars($detail['idProduct'])?>" class="text-decoration-none"><?php echo htmlspecialchars($detail['nameProduct'])?></a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 align-middle">
                                        <div class="cart-quantity d-md-flex align-items-center">
                                          <?php echo htmlspecialchars($detail['quantityOrder']) ?>
                                        </div>
                                    </td>
                                    <td class="py-4 align-middle replace-font">
                                        $<?php echo htmlspecialchars($detail['price'] * $detail['quantityOrder']) ?>
                                    </td>
                                    <td class="py-4 align-middle">
                                        <?php if($detail['statusOrder'] == 1) {
                                                echo "Dang cho xac nhan";
                                            } elseif ($detail['statusOrder'] == 3) {
                                                echo "<span class='fw-bold fs-6'>Shop dang chuan bi hang</span>";
                                            } elseif ($detail['statusOrder'] == 7) {
                                                echo "<span class='text-danger fs-5'>Don hang cua ban da bi huy</span>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 

                                        ?>
                                    </td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        
        <!-- footer  -->
        <?php include_once('./include/footer.php') ?>
    </body>
</html>