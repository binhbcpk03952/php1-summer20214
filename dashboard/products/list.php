<?php
    $dbHelper = new DBUntil();
    $products = $dbHelper->select("select * from products");
?>
<h1 class="mt-4">Products</h1> 
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
<div class="d-flex justify-content-end">
    <a href="master.php?view=product_created" class="btn btn-primary px-4">Add Product</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>description</th>
            <th>linkImage</th>
            <th>action</th>
        </tr>
    </thead>
    <?php
    foreach ($products as $prd) {
        echo "<tr>";
        echo "<td>$prd[idProduct]</td>";
        echo "<td>$prd[nameProduct]</td>";
        echo "<td>$prd[price]</td>";
        echo "<td>$prd[quantity]</td>";
        echo "<td>$prd[description]</td>";
        echo "<td>$prd[linkImage]</td>";
        echo "<td> <a class='btn btn-danger' href='master.php?view=product_delete&id=$prd[idProduct]'>remove</a>";
        echo "<a class='btn btn-primary mx-3' href='master.php?view=product_update&id=$prd[idProduct]'>edit</a></td>";
        echo "</tr>";
    }
    ?>
    </tr>
</table>