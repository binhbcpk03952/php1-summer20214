<?php
    $carts = $dbHelper->select("SELECT * FROM cart CA INNER JOIN products PR ON CA.idProduct = PR.idProduct");
?>

<header>
    <div class="container ">
        <div class="row heading_start">
            <div class="col-sm-3 logo-img">
                <div class="logo">
                    <a href="index.html">
                        <img
                            src="https://demo.templatesjungle.com/waggy/images/logo.png"
                            alt>
                    </a>
                </div>
            </div>
            <div class="col-sm-5 header-justify">
                <div class="search">
                    <input type="text" class="inp-search"
                        placeholder="Search For More Than 10,000 Products">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 
                                    1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"></path>
                    </svg>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="flex-item header-justify">
                    <div class="phone">
                        <span class="flex-item-span">Phone</span>
                        <h5>+980-34984089</h5>
                    </div>
                    <div class="email">
                        <span class="flex-item-span">Email</span>
                        <h5>Waggy@Gmail.Com</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <hr class="m-0">
    </div>
    <div class="container">
        <nav class="navigation">
            <div class="nav-flex-center">
                <select class="select">
                    <option value>Shop by Category</option>
                    <option value>Clothes</option>
                    <option value>Food</option>
                    <option value>Toy</option>
                </select>
            </div>
            <div class="nav-flex-center">
                <ul class="header-menu">
                    <li><a href="index.php"
                            class="link-regular">Home</a></li>
                    <li><a href="#" class="link-regular">Pages</a></li>
                    <li><a href="index.php?view=shop_list" class="link-regular">Shop</a></li>
                    <li><a href="blog.html" class="link-regular">Blog</a></li>
                    <li><a href="contact.html"
                            class="link-regular">Contact</a></li>
                    <li><a href="#" class="link-regular">Other</a></li>
                    <li><a href="#" class="link-bold">GET PRO</a></li>
                </ul>

            </div>

            <div class="item-end nav-flex-center">
                <ul class="navigation">
                    <li class="nav-item dropdown d-md-flex align-items-center">
                        <a class="nav-link dropdown-toggle" href="#"
                            id="navbarDropdown"
                            role="button">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <ul class="dropdown-menu d-none" id="dropdown-menu">
                            <div class="d-md-flex flex-column w-100">
                                <li class="d-block">
                                    <a class="dropdown-item"
                                        href="account.php">Account
                                        information</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="logout.php">
                                        <i
                                            class="fa-solid fa-right-from-bracket"></i>
                                        Log Out
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="order.php">
                                        <i class="fa-solid fa-chart-simple"></i>
                                            Order
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="order-history.php">
                                        <i class="fa-solid fa-chart-simple"></i>
                                            Order history
                                    </a>
                                </li>
                                <?php  
                                    $id = $_SESSION['id'];
                                    $selectRole = $dbHelper->select("SELECT role FROM users WHERE maKh = ?", [$id])[0];
                                    // var_dump($selectRole);
                                    if ($selectRole['role'] == "admin") {
                                        echo '
                                            <li>
                                                <a class="dropdown-item" href="./dashboard/master.php?view=user_list">
                                                    <i class="fa-solid fa-list-check"></i>
                                                        Dashboard
                                                </a>
                                            </li>
                                        ';
                                    }
                                ?>
                            </div>
                        </ul>
                    </li>
                    <li class="nav-item d-md-flex align-items-center">
                        <a class="nav-link" href="wishlish.html"><i
                                class="fa-solid fa-heart"></i></a>
                    </li>
                    <li class="nav-item d-md-flex align-items-center">
                        <a class="nav-link" href="index.php?view=cart_list">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="position-absolute top-5 start-99 translate-middle badge 
                            rounded-pill text-bg-warning"><?php echo count($carts); ?> <span class="visually-hidden">unread messages</span>
                            </span>
                    
                        </a>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</header>