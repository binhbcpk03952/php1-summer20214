<?php
    session_start();
    include_once('./DBUntil.php');
    $dbHelper = new DBUntil(); 
    include_once('./StatusOrder.php');
    $status = new Status(); 


    $details = $dbHelper->select("SELECT * FROM orders
                                 WHERE maKh = $_SESSION[id]");
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
                <h2>Order</h2>
                <nav class="breadcrumb">
                    <a href="index.html" class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Order</span>
                </nav>
            </div>
        </section>

        <section class="historyOrder">
            <div class="container mt-5">
                <h1>YOUR ORDER</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date Time</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Order Detail</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $order): ?>
                        <tr>
                            <td><?php echo $order['orderDate']; ?></td>
                            <td><?php echo $order['allPrice']; ?></td>
                            <td><?php $status->status($order['statusOrder']) ?></td>
                            <td>
                                <a href="order_details.php?id=<?php echo $order['idOrder']; ?>" class="text-decoration-none">Xem chi tiết</a>
                            </td>
                            <td>
                                <?php 
                                    if ($order['statusOrder'] == 1 || $order['statusOrder'] == 2 || $order['statusOrder'] == 3) {
                                        echo "<a class='btn btn-danger' href='http://localhost/AsignmentPHP/refuse.php?id=$order[idOrder]'>Huy don</a>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        
        <!-- footer  -->
        <?php include_once('./include/footer.php') ?>
    </body>
</html>