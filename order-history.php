<?php
    session_start();
    include_once('./DBUntil.php');
    $dbHelper = new DBUntil();
    
    $idUser = $_SESSION['id'];
    
    // Lấy danh sách đơn hàng của khách hàng hiện tại
    $orders = $dbHelper->select("SELECT * FROM orders WHERE maKh = ?", [$idUser]);
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
                <h2>Order History</h2>
                <nav class="breadcrumb">
                    <a href="index.html" class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Order History</span>
                </nav>
            </div>
        </section>

        <section class="historyOrder">
            <div class="container mt-5">
                <h1>Lịch sử đơn hàng của bạn</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Giá tổng</th>
                            <th>Trạng thái</th>
                            <th>Địa chỉ</th>
                            <th>Ghi chú</th>
                            <th>Chi tiết đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['idOrder']; ?></td>
                            <td><?php echo $order['orderDate']; ?></td>
                            <td><?php echo $order['allPrice']; ?></td>
                            <td><?php echo $order['statusOrder']; ?></td>
                            <td><?php echo $order['address']; ?></td>
                            <td><?php echo $order['noteOrder']; ?></td>
                            <td>
                                <a href="order_details.php?id=<?php echo $order['idOrder']; ?>" class="text-decoration-none">Xem chi tiết</a>
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