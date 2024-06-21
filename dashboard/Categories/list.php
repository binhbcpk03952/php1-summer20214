<?php
    $dbHelper = new DBUntil();
    $categories = $dbHelper->select("select * from categories");
?>
<h1 class="mt-4">Categories</h1> 
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Categories</li>
</ol>
<div class="d-flex justify-content-end">
    <a href="master.php?view=category_created" class="btn btn-primary px-4">Add Categories</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>action</th>
        </tr>
    </thead>

        <?php
            foreach ($categories as $cat) {
                echo "<tr>";
                echo "<td>$cat[idCategories]</td>";
                echo "<td>$cat[nameCategories]</td>";
                echo "<td> <a class='btn btn-danger' href='master.php?view=category_delete&id=$cat[idCategories]'>remove</a>";
                echo "  <a class='btn btn-primary  mx-3' href='master.php?view=category_update&id=$cat[idCategories]'>edit</a></td>";
                echo "</tr>";
            }
        ?>
</table>