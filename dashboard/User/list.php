<?php 
    $dbHelper = new DBUntil();
    $users = $dbHelper->select("SELECT * FROM users");
?>
<div class="d-flex justify-content-between align-items-center mt-4">
    <h1 class>User</h1>
    <a href="master.php?view=user_created" class="btn btn-primary px-4 mx-4">Add User</a>
</div>
<?php //var_dump($selectRole['role']); ?>
<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>password</th>
            <th>email</th>
            <th>role</th>
            <th>status</th>
            <th>sdt</th>
            <th>dia chi</th>
            <th>action</th>
            <th>edit</th>
        </tr>
    </thead>

    <?php
    foreach ($users as $us) {
    echo "<tr>";
        echo "<td>$us[maKh]</td>";
        echo "<td>$us[username]</td>";
        echo "<td>$us[password]</td>";
        echo "<td>$us[email]</td>";
        echo "<td>$us[role]</td>";
        echo "<td>$us[status]</td>";
        echo "<td>$us[sdt]</td>";
        echo "<td>$us[diachi]</td>";
        // echo "<td><img src='./User/upload/$us[avatar]' alt='image' width='100px'></td>";
        echo "<td> <a class='btn btn-danger'
                href='master.php?view=user_delete&id=$us[maKh]'>remove</a></td>";
        echo "<td> <a class='btn btn-primary'
                href='master.php?view=user_update&id=$us[maKh]'>edit</a></td>";
    echo "</tr>";
    }
    ?>
</table>