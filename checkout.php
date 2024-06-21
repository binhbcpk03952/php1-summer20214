<?php
    session_start();
    include_once('./DBUntil.php');
    $dbHelper = new DBUntil();
    use MailService\MailService as MailService;
                                            
    require_once('./MailService.php');

    $errors = [];
    echo $_SESSION['id'];
    $currentDateTime = getdate();
    // echo $_SESSION['totalCart'];

// Định dạng ngày giờ cho MySQL
    $mysqlDateTime = date("Y-m-d H:i:s", mktime(
        $currentDateTime['hours'] + 5,
        $currentDateTime['minutes'],
        $currentDateTime['seconds'],
        $currentDateTime['mon'],
        $currentDateTime['mday'],
        $currentDateTime['year']
    ));
    echo $mysqlDateTime;

    // validate form
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if (!isset($_POST['province']) || empty($_POST['province'])) {
            $errors['province'] = "Province is required";
            }
        else {
            $province = $_POST['province'];                
        }

        if (!isset($_POST['district']) || empty($_POST['district'])) {
            $errors['district'] = "district is required";
        }
        else {
            $district = $_POST['district'];
        }

        if (!isset($_POST['wards']) || empty($_POST['wards'])) {
            $errors['wards'] = "wards is required";
        } else {
            $wards = $_POST['wards'];
        }
        

        if (!isset($_POST['street']) || empty($_POST['street'])) {
            $errors['street'] = "street is required";
        } else {
            $street = $_POST['street'];
        }
        if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
            $errors['payment_method'] = "Payment method is required";
        } else {
            $paymentMethod = $_POST['payment_method'];
        }

        /**
         * 1. dat hang thanh cong
         * 2. dat hang va da thanh toan
         * 3. shop da xac nhan
         * 4. dang van chuyen
         * 5. thanh cong
         * 6. that bai
         * 7. da huy don     
         */

        if (count($errors) == 0) {
            $carts = $dbHelper->select("SELECT * FROM cart WHERE maKh = ?", [$_SESSION['id']]);
            if ($carts) {
                if ($paymentMethod == 1) {
                    $data = [
                        'allPrice' => $_SESSION['totalPrice'],
                        'maKh' => $_SESSION['id'],
                        'address' => $province.', '.$district.', '.$wards.', '.$street,
                        'orderDate' => $mysqlDateTime,
                        'noteOrder' => $_POST['note'],
                        'statusOrder' => 1,
                    ];
                    $orders = $dbHelper->insert('orders', $data);
                    $idOrder = $dbHelper->lastInsertId();
                    if ($orders) {
                        foreach($carts as $cart) {
                            $detailData = [
                                'idOrder' => $idOrder,
                                'idProduct' => $cart['idProduct'],
                                'quantityOrder' => $cart['quantityCart'],
                                // Thêm các trường dữ liệu khác cần thiết cho chi tiết đơn hàng
                            ];
                            // Thêm chi tiết đơn hàng vào cơ sở dữ liệu
                            $orderDetail = $dbHelper->insert('detailOrder', $detailData);
                            $products = $dbHelper->select("SELECT * FROM products WHERE idProduct = $cart[idProduct]");

                            $updateQuanProduct = $dbHelper->update('products', 
                                                                  ['quantity' => $products['quantity'] - $cart['quantityCart']], 
                                                                    "idProduct = $cart[idProduct]"
                                                                  
                            );
                        }

                        $removeCart = $dbHelper->delete('cart', "maKh = $_SESSION[id]");
                        unset($_SESSION['totalCart']);
    
                    // Chuyển hướng đến trang theo dõi đơn hàng
                        $users = $dbHelper->select("SELECT * FROM users WHERE maKh = ?", [$_SESSION['id']]);
                        $email = $users[0]["email"];
                        $username = $users[0]["username"];
                    // gui mail khi khach dat hang
                        try {
                            $result = MailService::send(
                                'binhcpk03952@gmail.com',
                                $email,
                                "Đặt hàng thành công",
                                "<p>Chào $username,</p>
                                <p>Cảm ơn bạn đã đặt sản phẩm của chúng tôi.</p>
                                <p>Chúng tôi sẽ liên hệ với bạn sớm nhất để hoàn tất đơn hàng.</p>
                                <a href='http://localhost/AsignmentPHP/order_details.php?id=$idOrder' class='fw-bold'>Thông tin đơn hàng</a>"
                            );
                        } catch (Exception $e) {
                            echo "Có lỗi xảy ra khi gửi email: " . $e->getMessage();
                        }

                        echo "<script>alert('Cảm ơn bạn đã đặt hàng! Đơn hàng của bạn đã được ghi nhận.')</script>";
                        header("Location: order_details.php?id=$idOrder");
                        exit();     
                        }                   
                }

                if ($paymentMethod == 2) {
                    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
                    date_default_timezone_set('Asia/Ho_Chi_Minh');

                    define("VNPAY_TMN_CODE", "RLH2F0WJ");
                    define("VNPAY_HASH_SECRET", "8B4FKPIX260QZ8XPSBEE0GSFTD5QK0FY");
                    define("VNPAY_URL", "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html");
                    define("VNPAY_RETURN_URL", "http://localhost/AsignmentPHP/order_details.php");
                    
                    // date_default_timezone_set('Asia/Ho_Chi_Minh');
                    // var_dump(array($orderId, $total));

    
                    $vnp_Url = VNPAY_URL;
                    $vnp_Returnurl = VNPAY_RETURN_URL;
                    $vnp_TmnCode = VNPAY_TMN_CODE;//Mã website tại VNPAY 
                    $vnp_HashSecret = VNPAY_HASH_SECRET; //Chuỗi bí mật

                    $vnp_TxnRef = rand(00, 9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                    $vnp_OrderInfo = "Thanh toan hoa don";
                    $vnp_OrderType = "billpayment";
                    $vnp_Amount = $_SESSION['totalPrice'] * 100;
                    $vnp_Locale = "vn";
                    // $vnp_BankCode = "MBBANK";
                    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                    $startTime = date("YmdHis");
                    $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
                    //Add Params of 2.0.1 Version
                    // $vnp_ExpireDate = $_POST['txtexpire'];
                    //Billing
                    // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
                    // $vnp_Bill_Email = $_POST['txt_billing_email'];
                    // $fullName = trim($_POST['txt_billing_fullname']);
                    // if (isset($fullName) && trim($fullName) != '') {
                    //     $name = explode(' ', $fullName);
                    //     $vnp_Bill_FirstName = array_shift($name);
                    //     $vnp_Bill_LastName = array_pop($name);
                    // }
                    // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
                    // $vnp_Bill_City=$_POST['txt_bill_city'];
                    // $vnp_Bill_Country=$_POST['txt_bill_country'];
                    // $vnp_Bill_State=$_POST['txt_bill_state'];
                    // // Invoice
                    // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
                    // $vnp_Inv_Email=$_POST['txt_inv_email'];
                    // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
                    // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
                    // $vnp_Inv_Company=$_POST['txt_inv_company'];
                    // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
                    // $vnp_Inv_Type=$_POST['cbo_inv_type'];
                    $inputData = array(
                        "vnp_Version" => "2.1.0",
                        "vnp_TmnCode" => $vnp_TmnCode,
                        "vnp_Amount" => $vnp_Amount,
                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        "vnp_IpAddr" => $vnp_IpAddr,
                        "vnp_Locale" => $vnp_Locale,
                        "vnp_OrderInfo" => $vnp_OrderInfo,
                        "vnp_OrderType" => $vnp_OrderType,
                        "vnp_ReturnUrl" => $vnp_Returnurl,
                        "vnp_TxnRef" => $vnp_TxnRef,
                        "vnp_ExpireDate"=>$expire

                        // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
                        // "vnp_Bill_Email"=>$vnp_Bill_Email,
                        // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
                        // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
                        // "vnp_Bill_Address"=>$vnp_Bill_Address,
                        // "vnp_Bill_City"=>$vnp_Bill_City,
                        // "vnp_Bill_Country"=>$vnp_Bill_Country,
                        // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
                        // "vnp_Inv_Email"=>$vnp_Inv_Email,
                        // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
                        // "vnp_Inv_Address"=>$vnp_Inv_Address,
                        // "vnp_Inv_Company"=>$vnp_Inv_Company,
                        // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
                        // "vnp_Inv_Type"=>$vnp_Inv_Type
                    );

                    // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    //     $inputData['vnp_BankCode'] = $vnp_BankCode;
                    // }
                    // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                    // }

                    //var_dump($inputData);
                    ksort($inputData);
                    $query = "";
                    $i = 0;
                    $hashdata = "";
                    foreach ($inputData as $key => $value) {
                        if ($i == 1) {
                            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashdata .= urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
                    }

                    $vnp_Url = $vnp_Url . "?" . $query;
                    if (isset($vnp_HashSecret)) {
                        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                    }
                    header('Location: ' . $vnp_Url);
                    die();
                       

                }
                
            }
        }
    }
   
?>

<!DOCTYPE html>
<html lang="en">
    <?php include ("./include/head.php") ?>
    <body>
        <?php include('./include/header.php') ?>
        <section class="banner-contact">
            <div class="container banner-items">
                <h2>Checkout</h2>
                <nav class="breadcrumb">
                    <a href="index.html"
                        class="breadcrumb-item nav-link">Home</a>
                    <a href="#" class="breadcrumb-item nav-link">Pages</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </section>
        <!-- main -->

        <section class="main-checkout mt-5">
            <div class="container">
                <form action="checkout.php" class="form-group" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="text-dark pb-3">Billing Details</h2>
                            <div class="form-input mt-4">
                                <label for="province">Province / City *</label>
                                <input type="text" id="province" name="province" class="inp-value w-100" value="">
                                <?php
                                    if(isset($errors['province'])) {
                                        echo "<span class='text-danger'>$errors[province] </span>";
                                    }
                                ?>
                            </div>
                            <div class="form-input mt-4">
                                <label for="district">District *</label>
                                <input type="text" id="district" name="district" class="inp-value w-100" value="">
                                <?php
                                    if(isset($errors['district'])) {
                                        echo "<span class='text-danger'>$errors[district] </span>";
                                    }
                                ?>
                            </div>
                            <div class="form-input mt-4">
                                <label for="wards">Wards *</label>
                                <input type="text" id="wards" name="wards" class="inp-value w-100" value="">
                                <?php
                                    if(isset($errors['wards'])) {
                                        echo "<span class='text-danger'>$errors[wards] </span>";
                                    }
                                ?>
                            </div>
                            <div class="form-input mt-4">
                                <label for="street">Street names *</label>
                                <input type="text" id="street" name="street" class="inp-value w-100" value="">
                                <?php
                                    if(isset($errors['street'])) {
                                        echo "<span class='text-danger'>$errors[street] </span>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <h2 class="text-dark pb-4">Additional Information</h2>
                            <div class="order-note mt-3 ">
                                <label for>Order notes (optional)</label>
                                <textarea name="note" id class="inp-value w-100 p-2" placeholder="Notes about your order. Like special notes for delivery."></textarea>
                            </div>
                            <div class="your-order">
                                <h2 class="text-dark mt-4">Cart Totals</h2>
                                <div class="total-price">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Total</th>
                                                <td class="total">
                                                    <?php echo $_SESSION['totalPrice']; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pay">
                                    <div class="d-flex gap-2 mt-3">
                                        <input type="radio" name="payment_method" value="1" class="form-check-input flex-shrink-0">
                                        <div class="content-pay">
                                            <b class="text-uppercase d-block">Cash on delivery</b>
                                            <small>Pay with cash upon
                                                delivery.</small>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <input type="radio" name="payment_method" value="2" class="form-check-input flex-shrink-0">
                                        <div class="content-pay">
                                            <b class="text-uppercase d-block">VN Pay</b>
                                            <small>Pay via PayPal; you can pay
                                                with your credit card if
                                                you don’t have a PayPal
                                                account.</small>
                                        </div>
                                    </div>
                                    <?php if(isset($errors['payment_method'])): ?>
                                        <span class='text-danger'><?php echo $errors['payment_method']; ?></span>
                                    <?php endif; ?>
                                    <button type="submit" class="mt-4 w-100 inp-value bg-dark fs-5 text-white py-4">ORDER</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- end -->

        <!-- footer  -->

        <?php include ("./include/footer.php") ?>
    </body>
</html>