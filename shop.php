<?php
    include_once('./DBUntil.php');

    $dbHelper = new DBUntil();
    $products = $dbHelper->select('SELECT * FROM products');
 
    if (isset($_GET['search_query'])) {
        $searchQuery = htmlspecialchars($_GET['search_query']);
        echo "Search Query: " . $searchQuery;
        // You can now handle the search query as needed, e.g., querying a database
        $products = $dbHelper->select("SELECT * FROM products WHERE nameProduct LIKE '%$searchQuery%' ");
    }
?>


<!DOCTYPE html>
<html lang="en">
    <?php include_once('./include/head.php') ?>
    <body>
        <style>
            aside {
                position: sticky;
            }
        </style>
        <?php include_once('./include/header.php'); ?>
        
        <section class="banner-contact">
            <div class="container banner-items">
                <h2>Shop</h2>
                <nav class="breadcrumb">
                    <a href="index.html"
                        class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Shop</span>
                </nav>
            </div>
        </section>  
        <!-- main -->
        <div class="container mt-5">
            <div class="row">
            <?php include_once('./include/side-bar.php') ?>
                <main class="col-md-9">
                    <div class="filter-shop d-md-flex justify-content-between align-items-center">
                        <div class="showing-product mt-3">
                            <p>Showing 1–9 of 55 results</p>
                        </div>
                        <div class="sort-by">
                            <select name="" id="">
                                <option value="">Default sorting</option>
                                <option value="">Name (A - Z)</option>
                                <option value="">Name (Z - A)</option>
                                <option value="">Price (Low-High)</option>
                                <option value="">Price (High-Low)</option>
                                <option value="">Rating (Highest)</option>
                                <option value="">Rating (Lowest)</option>
                                <option value="">Model (A - Z)</option>
                                <option value="">Model (Z - A)</option>
                            </select>
                        </div>
                    </div>
                    <div class="product-items row">
                        <?php
                        
                        include_once('./Message.php');
                        $view = isset($_GET['view']) ? $_GET['view'] : 'index'; 
                        switch ($view) {
                            case 'all_products':
                                $products = $dbHelper->select('SELECT * FROM products');
                                break;
                            case 'Dog_products':
                                $products = $dbHelper->select('SELECT * FROM products WHERE idCategories = 23');
                                break;
                            case 'Food_products':
                                $products = $dbHelper->select('SELECT * FROM products WHERE idCategories = 33');
                                break;
                            case 'Cat_products':
                                $products = $dbHelper->select('SELECT * FROM products WHERE idCategories = 31');
                                break;
                            case 'Bird_products':
                                $products = $dbHelper->select('SELECT * FROM products WHERE idCategories = 32');
                                break;
                            case 'less_than10':
                                $products = $dbHelper->select('SELECT * FROM products WHERE price < 10');
                                break;
                            case '10_20':
                                $products = $dbHelper->select('SELECT * FROM products WHERE price >= 10 and price < 20' );
                                break;
                            case '20_30':
                                $products = $dbHelper->select('SELECT * FROM products WHERE price >= 20 and price < 30');
                                break;
                            case '30_40':
                                $products = $dbHelper->select('SELECT * FROM products WHERE price >= 30 and price < 40');
                                break;
                            case '40_50':
                                $products = $dbHelper->select('SELECT * FROM products WHERE price >= 40 and price < 50');
                                break;
                        }
                        ?>

                        <?php foreach ($products as $product) { ?>
                            <div class="col-md-4">
                                    <div class="card_image">
                                        <a href="detail.php?id=<?php echo htmlspecialchars($product['idProduct'])?>" class="positon-relative">
                                            <img
                                                src="http://localhost/AsignmentPHP/dashboard/products/image/<?php echo htmlspecialchars($product['linkImage'])?>"
                                                alt>
                                                <?php if($product["quantity"] == 0) {
                                                    echo '<span class="out-of-stock-badge">Hết hàng</span>';
                                                } ?>
                                        </a>
                                    </div>
                                    <div class="card-content">
                                        <a href="detail.php?id=<?php echo htmlspecialchars($product['idProduct'])?>">
                                            <h3><?php echo htmlspecialchars($product['nameProduct'])?></h3>
                                        </a>
                                        <div class="card_content--text">
                                            <span>
                                                <i class="fa-regular fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                <i class="fa-regular fa-star"></i>
                                                5.0
                                            </span>
                                            <h3><?php echo htmlspecialchars($product['price'])?></h3>
                                            <div class="d-flex">
                                                <form method="POST" action="<?php if($product['quantity'] > 0) {echo 'add-to-cart.php';} ?>"> 
                                                    <input type="hidden" name="idProduct" value="<?php echo htmlspecialchars($product['idProduct'])?>">
                                                    <button type="submit" name="add-to-cart" class="add-tocart">ADD TO CART</button>
                                                </form>
                                                <button class="add-favourites">
                                                    <i class="fa-solid fa-heart"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }?>
                    </div>
                </main>
            </div>     
        </div>


        
        <!-- footer  -->
        <?php include_once('./include/footer.php') ?>
    </body>
</html>