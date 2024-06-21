<?php
    session_start();
    include('./DBUntil.php');
    $dbHelper = new DBUntil();

    $id = $_GET['id'];
    $products = $dbHelper->select('SELECT * FROM products WHERE idProduct = ?', [$id])[0];
    // var_dump($products);
    // echo $id;
?>

<!DOCTYPE html>
<html lang="en">
    <?php include("./include/head.php") ?>
    <body>
        <?php include("./include/header.php") ?>
        <section class="banner-contact">
            <div class="container banner-items">
                <h2>Single <span class="color-in">Product</span></h2>
                <nav class="breadcrumb">
                    <a href="index.html"
                        class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Single-Product</span>
                </nav>
            </div>
        </section>
        <!-- main  -->

        <section id="singleProduct">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 px-3 mt-5">
                        <div class="row">
                            <div class="image-large col-lg-12 px-1">
                                <img width="100%" src="http://localhost/AsignmentPHP/dashboard/products/image/<?php echo htmlspecialchars($products['linkImage']) ?>" alt>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 px-3 mt-5">
                        <div class="info-product">
                            <div class="title-product card_content--text">
                                <h2 class="fs-1"><?php echo htmlspecialchars($products['nameProduct']) ?></h2>
                                <span>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    5.0
                                </span>
                            </div>
                            <div class="price mt-3">
                                <span
                                    class="current-price fs-1 fw-bold color-in">$<?php echo htmlspecialchars($products['price']); ?></span>
                                <span
                                    class="original-price text-decoration-line-through">$24.00</span>
                            </div>
                            <p class="description lh-lg">
                            <?php echo htmlspecialchars($products['description']); ?>
                            </p>
                            <div class="cart_size mt-4">
                                <div class="color-product">
                                    <h6 class="fw-bold">
                                        Color:
                                    </h6>
                                    <div class="btn-color">
                                        <button
                                            class="btn bg-secondary mx-2">Gray</button>
                                        <button
                                            class="btn bg-light mx-2">Black</button>
                                        <button
                                            class="btn bg-light mx-2">Blue</button>
                                        <button
                                            class="btn bg-light mx-2">Red</button>
                                    </div>
                                </div>
                                <div class="size-product mt-4">
                                    <h6 class="fw-bold">
                                        Size:
                                    </h6>
                                    <div class="btn-color">
                                        <button
                                            class="btn bg-light mx-2">XL</button>
                                        <button
                                            class="btn bg-light mx-2">L</button>
                                        <button
                                            class="btn bg-light mx-2">M</button>
                                        <button
                                            class="btn bg-light mx-2">S</button>
                                    </div>
                                </div>
                                <div class="quantity-product mt-3">
                                    <div class="stock">
                                        <em>
                                            <span id="quatity" class="<?php if($products['quantity'] == 0) { echo 'text-danger fw-bold fs-4';} ?>"><?php echo htmlspecialchars($products['quantity']); ?></span>
                                            in stock
                                        </em>
                                    </div>                                    
                                        <div class="cart-quantity d-md-flex align-items-center">
                                            <button>-</button>
                                            <input type="text" name="" id="cart-quantity" value="1">
                                            <button>+</button>
                                        </div>
                                    </div>
                                    <div
                                        class="add-cart d-flex align-items-center mt-3">
                                        <button class="add-tocart">ADD TO CART</button>
                                        <button class="add-favourites ">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="items-end mt-5">
                                    <div class="d-flex item-cate align-items-baseline">
                                        <h6 class="fw-bold">SKU: </h6>
                                        <span class="mx-3"><?php echo htmlspecialchars($products['idProduct']) ?></span>
                                    </div>
                                    <?php 
                                        $idCat = $products['idCategories'];
                                        // echo $idCat;
                                        $category = $dbHelper->select("SELECT * FROM categories WHERE idCategories = :id", ['id' => $idCat])[0]; 
                                        // var_dump($category);
                                    ?>
                                    <div class="d-flex item-cate align-items-baseline mt-2">
                                        <h6 class="fw-bold">Category: </h6>
                                        <span class="mx-3"><?php echo htmlspecialchars($category['nameCategories']) ?></span>
                                    </div>
                                    <div class="d-flex item-cate align-items-baseline mt-2">
                                        <h6 class="fw-bold">Tag: </h6>
                                        <span class="mx-3"><?php echo htmlspecialchars($category['nameCategories']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
            $namePrd =  $products['nameProduct'];
            $idPrd = $products['idProduct'];
            $relaProduct = $dbHelper->select("SELECT * FROM products WHERE nameProduct LIKE '%$namePrd%' AND idProduct != $idPrd");
            // var_dump($relaProduct);
        ?>
        <section class="related-products mt-5">
            <div class="container">
                <div class="title-relaPrd">
                    <h2 class="fs-1">Related Products</h2>
                </div>
                <div class="row">
                    <?php foreach ($relaProduct as $product) { ?>
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
                                        <form method="POST" action="add-to-cart.php">
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
            </div>
        </section>

        <section class="service">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 cards-dad">
                        <div class="cards">
                            <div class="card-border-icon">
                                <i data-lucide="shopping-cart"></i>
                            </div>
                            <h3>Free Delivery</h3>
                            <div class="card-text">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipi elit.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 cards-dad">
                        <div class="cards">
                            <div class="card-border-icon">
                                <i data-lucide="user-round-check"></i>
                            </div>
                            <h3>100% Secure Payment</h3>
                            <div class="card-text">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipi elit.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 cards-dad">
                        <div class="cards">
                            <div class="card-border-icon">
                                <i data-lucide="tag"></i>
                            </div>
                            <h3>Daily Offer</h3>
                            <div class="card-text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipi
                                    elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 cards-dad">
                        <div class="cards">
                            <div class="card-border-icon">
                                <i data-lucide="award"></i>
                            </div>
                            <h3>Quality Guarantee</h3>
                            <div class="card-text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipi
                                    elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- footer  -->

        <?php include("./include/footer.php") ?>

    </body>
</html>