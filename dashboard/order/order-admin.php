<?php
    $dbHelper = new DBUntil();
    $orders = $dbHelper->select("select * from orders");
?>
<h1 class="mt-4">Quản lí đơn hàng</h1> 
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Order</li>
</ol>
<div class="d-flex justify-content-end">
    <a href="master.php?view=product_created" class="btn btn-primary px-4">Add Product</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>totalPrice</th>
            <th>Khach Mua</th>
            <th>Dia chi</th>
            <th>Thoi gian</th>
            <th>Note</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <?php
        /**
         * 1. dat hang thanh cong
         * 2. dat hang va da thanh toan
         * 3. shop da xac nhan
         * 4. dang van chuyen
         * 5. thanh cong
         * 6. that bai
         * 7. da huy don     
        */
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>$order[idOrder]</td>";
        echo "<td>$$order[allPrice]</td>";
        echo "<td>$order[maKh]</td>";
        echo "<td>$order[address]</td>";
        echo "<td>$order[orderDate]</td>";
        echo "<td>$order[noteOrder]</td>";
        if ($order['statusOrder'] == 1) {
            echo "<td>Chờ xác nhận</td>";
            echo "<td> <a class='btn btn-danger' href='master.php?view=update_order&id=$order[idOrder]'>Xac Nhan</a>";
            echo "<a class='btn btn-primary mx-3' href='master.php?view=refuse_order&id=$order[idOrder]'>Tu choi</a></td>";
        } elseif ($order['statusOrder'] == 3) {
            echo "<td>Chuẩn bị hàng</td>";
            echo "<td> <a class='btn btn-primary' href='master.php?view=update_order&id=$order[idOrder]'>Chuan bi hang</a>";
        } elseif($order['statusOrder'] == 7) {
            echo "<td>Tu choi</td>";
            echo "<td> <a class='btn btn-danger' href=''>Tu choi</a>";
        }
        echo "</tr>";
    }
    ?>
    </tr>
</table>