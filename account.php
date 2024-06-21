<?php
    include_once ('./DBUntil.php');
    session_start();
    // echo $_SESSION['id'];
    $dbHelper = new DBUntil();
    $id = $_SESSION['id'];
    var_dump($id);
    $query = $dbHelper->select('SELECT * FROM users WHERE maKh = ?', [$id]);
    var_dump($query);
    $query = $query[0];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Waggy - Free eCommerce Pet Shop HTML Website Template</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <link
            href="https://fonts.googleapis.com/css2?family=Chilanka&amp;family=Montserrat:wght@300;400;500&amp;display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/account.css">
        <style>
            .inp-value {
                font-size: 1rem;
                font-family: 'Montserrat', sans-serif;
            }
        </style>
    </head>
    <body>
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
                            <li><a href="index.html"
                                    class="link-regular">Home</a></li>
                            <li><a href="#" class="link-regular">Pages</a></li>
                            <li><a href="#" class="link-regular">Shop</a></li>
                            <li><a href="blog.html"
                                    class="link-regular">Blog</a></li>
                            <li><a href="#"
                                    class="link-regular">Contact</a></li>
                            <li><a href="#" class="link-regular">Other</a></li>
                            <li><a href="#" class="link-bold">GET PRO</a></li>
                        </ul>

                    </div>

                    <div class="item-end nav-flex-center">
                        <ul>
                            <li><a href="account.html">
                                    <i class="fa-solid fa-user"></i>
                                </a></li>
                            <li><a href="#">
                                    <i class="fa-solid fa-heart"></i>
                                </a></li>
                            <li><a href="#">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <section class="banner-contact">
            <div class="container banner-items">
                <h2>Account</h2>
                <nav class="breadcrumb">
                    <a href="index.html"
                        class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Contact</span>
                </nav>
            </div>
        </section>
        <!-- main -->
        <section id="form-register">
            <div class="container">
                <div class="nav-form">
                    <button class="nav-login color-in" id="btn-register">ACCOUNT</button>
                </div>
                <hr>
                <div class="flex-center">
                    <div class="all-form-register mt-5">
                        <div class="form-sign-in">
                            <!-- <p class="form-title">Sign-Up With Social</p>
                            <hr class="mb-3">
                            <div class="log-in-with">
                                <button class="with-google">
                                    <i class="fa-brands fa-google"></i>
                                    GOOGLE
                                </button>
                                <button class="with-facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                    FACEBOOK
                                </button>
                            </div> -->
                            <p class="form-title mt-2">Or Sign-Up With Email</p>
                            <hr class="mb-4">
                            <!-- form -->
                            <form action="register.php" method="POST">
                                <!-- username -->
                                <div class="username mb-3">
                                    <label for="" class="form-check-label fs-6 fw-bold">Username</label>
                                    <input type="text" class="inp-value" name="username" id="inp-name" 
                                    placeholder="Your Username" value="<?php echo $query['username'] ?>" disabled>
                                </div>
                                <!-- email -->
                                <div class="email mb-3">
                                    <label for="" class="form-check-label fs-6 fw-bold">Email</label>
                                    <input type="email" class="inp-value" name="email" id="inp-email-regis"
                                    placeholder="Your Email Address" value="<?php echo $query['email'];?>" disabled>
                                </div>
                                <!-- password -->
                                <div class="password  mb-3">
                                    <label for="" class="form-check-label fs-6 fw-bold">Password</label>
                                    <input type="text" class="inp-value" name="password" id="inp-pass-regis" 
                                    placeholder="Set Your Password" value="<?php echo $query['password'];?>" disabled>
                                </div>
                                <!-- address -->
                                <div class="address mb-3">
                                    <label for="" class="form-check-label fs-6 fw-bold">Address</label>
                                    <?php $address = ""; ?>
                                    <input type="text" class="inp-value" name="address" id="address" 
                                    placeholder="Your Address" value="<?php echo $query['diachi'];?>" disabled>                                    
                                </div>
                                <!-- phone -->
                                <div class="phone mb-3">
                                    <label for="" class="form-check-label fs-6 fw-bold">Phone</label>
                                    <?php $phone=""; ?>
                                    <input type="text" class="inp-value" name="phone" id="phone" 
                                    placeholder="Your Phone" value="<?php echo $query['sdt'];?>" disabled>
                                </div>
                                <!-- role -->
                                <div class="role">
                                    <label for="" class="form-check-label fs-6 fw-bold">Role</label>
                                    <select class=" inp-value" name="role" id="role"  <?php echo $role; ?> disabled>
                                        <option value="<?php echo $query['role'];?>"><?php echo $query['role'];?></option>
                                    </select>
                                    <div class="mb-3">
                                        <label class="form-check-label mt-3 fs-5 fw-bold">Account Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="1" id="status1" checked>
                                            <label class="form-check-label fs-6" for="status1">
                                                Allow activity
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="0" id="status2">
                                            <label class="form-check-label fs-6" for="flexRadioDefault2">
                                                Lock account
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php $role = ""; ?>
                                <!--  -->
                                <div class="row">
                                    <div class="col-lg-6"><a href='removeaccount.php?id=<?php echo $query['maKh'];?>' class="btn btn-danger w-100">REMOVE</a></div>
                                    <div class="col-lg-6"><a href='editaccount.php?id=<?php echo $query['maKh'];?>' class="btn btn-primary w-100">EDIT</a></div>
                                </div>
                                <!-- <button class="login mt-4">REGISTER</button> -->
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </section>
    
        <!-- footer -->

        <section class="insta">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 instagram-item">
                        <div class="icon-hover">
                            <i data-lucide="instagram"></i>
                        </div>
                        <a href="#">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/insta1.jpg"
                                alt>
                        </a>
                    </div>
                    <div class="col-md-2 instagram-item">
                        <div class="icon-hover">
                            <i data-lucide="instagram"></i>
                        </div>
                        <a href="#">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/insta2.jpg"
                                alt>
                        </a>
                    </div>
                    <div class="col-md-2 instagram-item">
                        <div class="icon-hover">
                            <i data-lucide="instagram"></i>
                        </div>
                        <a href="#">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/insta3.jpg"
                                alt>
                        </a>
                    </div>
                    <div class="col-md-2 instagram-item">
                        <div class="icon-hover">
                            <i data-lucide="instagram"></i>
                        </div>
                        <a href="#">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/insta4.jpg"
                                alt>
                        </a>
                    </div>
                    <div class="col-md-2 instagram-item">
                        <div class="icon-hover">
                            <i data-lucide="instagram"></i>
                        </div>
                        <a href="#">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/insta5.jpg"
                                alt>
                        </a>
                    </div>
                    <div class="col-md-2 instagram-item">
                        <div class="icon-hover">
                            <i data-lucide="instagram"></i>
                        </div>
                        <a href="#">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/insta6.jpg"
                                alt>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="footer-menu">
                            <img
                                src="https://demo.templatesjungle.com/waggy/images/logo.png"
                                alt>
                            <p class="card-text">Subscribe to our newsletter to
                                get updates about
                                our grand offers.</p>
                            <div class="social-link">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i
                                                class="fa-brands fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i
                                                class="fa-brands fa-pinterest"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i
                                                class="fa-brands fa-instagram"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa-brands fa-youtube"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-menu">
                            <h3>Quick Links</h3>
                            <ul class="footer-link">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Offer</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-menu">
                            <h3>Help Center</h3>
                            <ul class="footer-link">
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">Payment</a></li>
                                <li><a href="#">Return & Refunds</a></li>
                                <li><a href="#">Checkout</a></li>
                                <li><a href="#">Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-menu">
                            <h3>Our Newsletter</h3>
                            <p class="card-text">Subscribe to our newsletter to
                                get updates about
                                our grand offers.</p>
                            <div class="search-end">
                                <form class="coment">
                                    <input type="text"
                                        placeholder="Enter Your Email Here">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="1em" height="1em"
                                            viewBox="0 0 24 24"><path
                                                fill="currentColor"
                                                d="M20.891 2.006L20.997 2l.13.008l.09.016l.123.035l.107.046l.1.057l.09.067l.082.075l.052.059l.082.116l.052.096q.07.15.09.316l.005.106q0
                                                 .113-.024.22l-.035.123l-6.532 18.077A1.55 1.55 0
                                                  0 1 14 22.32a1.55 1.55 0 0 1-1.329-.747l-.065-.127l-3.352-6.702l-6.67-3.336a1.55 1.55 
                                                  0 0 1-.898-1.259L1.68 10c0-.56.301-1.072.841-1.37l.14-.07l18.017-6.506l.106-.03l.108-.018z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="https://kit.fontawesome.com/121f50087c.js"
            crossorigin="anonymous"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
              lucide.createIcons();
            </script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/validateForm.js"></script>
    </body>
</html>