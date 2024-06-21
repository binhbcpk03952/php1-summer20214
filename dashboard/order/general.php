
<?php    
    // include_once('../../DBUntil.php');
    $dbHelper = new DBUntil();
    $orders = $dbHelper->select("select * from orders");
    $products = $dbHelper->select("select * from products");
    $users = $dbHelper->select("select * from users");
    $salesInDate =  $dbHelper->select("SELECT DATE(orderDate) AS order_day, SUM(allPrice) AS total_revenue
                                       FROM orders
                                       WHERE statusOrder = '3' -- Giả sử chỉ tính các đơn hàng đã hoàn thành
                                       GROUP BY DATE(order_day)
                                       ORDER BY order_day");
    $salesCharts = $dbHelper->select("SELECT DATE(orderDate) AS day, COUNT(idOrder) AS total_orders, SUM(allPrice) AS total_sales FROM orders GROUP BY day ORDER BY day");
    // var_dump($salesCharts);
    $labels = [];
    $totalOrders = [];
    $totalSales = [];

    foreach ($salesCharts as $row) {
        $labels[] = $row['day'];
        $totalOrders[] = $row['total_orders'];
        $totalSales[] = $row['total_sales'];
    }

    $labelsJson = json_encode($labels);
    $totalOrdersJson = json_encode($totalOrders);
    $totalSalesJson = json_encode($totalSales);
?>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
</style>
<h1 class="mt-4">Thống kê</h1> 
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">General</li>
</ol>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="quantiy_product d-flex align-items-center">
                <h5>Số lượng sản phẩm:  </h5>
                <p class="mb-1 mx-2 fw-bold"><?php echo count($products); ?></p>
            </div>
    
            <div class="quantity-user d-flex align-items-center">
                <h5>Số lượng người dùng:</h5>
                <p class="mb-1 mx-2 fw-bold"><?php echo count($users); ?></p>
            </div>
            <div class="quatity-order d-flex align-items-center">
                <h5>Số lượng đơn hàng:</h5>
                <p class="mb-1 mx-2 fw-bold"><?php echo count($orders);?></p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tình trạng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><?php echo $order['idOrder'] ?></td>
                                <td>
                                    <?php if ($order['statusOrder'] == 7) {
                                        echo "Đã hủy đơn.";
                                    } elseif($order['statusOrder'] == 6) {
                                        echo "Giao hàng thất bại.";
                                    } elseif($order['statusOrder'] == 5) {
                                        echo "Giao hàng thành công.";
                                    } else {
                                        echo "Đơn hàng đang được xử lí.";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <div class="warning-products">
                <h4 class="text-warning">Cảnh báo:</h4>
                <?php foreach ($products as $product) { ?>
                    <?php if ($product['quantity'] < 3) { 
                        echo "<p>Sản phẩm  <b>". $product['nameProduct'] . "</b> sắp hết hàng</p>";
                    }?>
                    
                <?php } ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="total-revenue">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Danh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($salesCharts as $sale) { ?>
                            <tr>
                                <td><?php echo $sale['day'] ?></td>
                                <td>$<?php echo $sale['total_sales'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <canvas id="myChart"></canvas>
        </div>        
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>        
<script>
        // Nhận dữ liệu từ PHP
        var labels = <?php echo $labelsJson; ?>;
        var totalOrders = <?php echo $totalOrdersJson; ?>;
        var totalSales = <?php echo $totalSalesJson; ?>;

        // Tạo biểu đồ
        var ctx = document.getElementById('myChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Orders',
                    data: totalOrders,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Total Sales',
                    data: totalSales,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>