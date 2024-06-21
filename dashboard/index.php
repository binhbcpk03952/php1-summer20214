<?php
    include_once ('../DBUntil.php');
    $dbHelper = new DBUntil();
    session_start();
    $username = $_SESSION['username'];
    $selectRole = $dbHelper->select("SELECT role FROM users WHERE username = ?", [$username])[0];
    if(!isset($_SESSION['username'])) {
        header("Location:  http://localhost/php1-summer-2024/block1-sum2024/AsignmentPHP/login.php");
        exit();
    }
    if ($selectRole['role'] != 'admin') {
        header("Location:  http://localhost/php1-summer-2024/block1-sum2024/AsignmentPHP/index.php");
        exit();
    }
    $users = $dbHelper->select("SELECT * FROM users");
?>
<?php
    include "./includes/header.php"
?>




    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" 
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <?php include "./includes/nav.php"; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <h1 class="">User</h1>
                            <a href="./User/created.php" class="btn btn-primary px-4 mx-4">Add User</a>
                        </div>
                        <!-- <?php var_dump($selectRole['role']); ?> -->
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
                                    echo "<td> <a class='btn btn-danger' href='./User/delete.php?id=$us[maKh]'>remove</a></td>";
                                    echo "<td> <a class='btn btn-primary' href='./User/edit.php?id=$us[maKh]'>edit</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
