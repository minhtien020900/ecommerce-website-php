<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
$isLogin = false;
if (isset($_SESSION['isLogin'])) {
    $isLogin = $_SESSION['isLogin'];
}
$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getCategoryList();

$brandModel = new BrandModel();
$productModel = new ProductModel();

$path = explode('-', $_SERVER['REQUEST_URI']);
$prdId = $path[count($path) - 1];

$productItemId = $productModel->getProductById($prdId);

$cart_qlt = 0;
$totalPrice = 0;
$CartModel = new CartModel();
if (!empty($_SESSION['user_id'])) {
    $cartList_User = $CartModel->getCartByUser($_SESSION['user_id']);
    foreach ($cartList_User as $value) {
        $cart_qlt += $value['product_quanlity'];
        $totalPrice += $value['product_quanlity'] * $value['product_price'];
    }
    if (isset($_SESSION['success'])) {
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }
    if (isset($_POST['cartId'])) {
        $pro_Id = $CartModel->getCartByCartId($_POST['cartId'])[0]['product_id'];
        if ($CartModel->DeleteCart($_POST['cartId'])) {
            unset($_SESSION['cart'][$pro_Id]['qty']);
            header('location:' . $_SERVER['REQUEST_URI']);
        }
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.devitems.com/subas-preview/subas/single-product.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:55:43 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Subas || Chi tiết sản phẩm</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/<?php echo BASE_URL ?>/parent/img/icon/favicon.png">

    <!-- All CSS Files -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/bootstrap.min.css">
    <!-- Nivo-slider css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/lib/css/nivo-slider.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/custom.css">

    <!-- Style customizer (Remove these two lines please) -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/style-customizer.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/style.css">
    <link href="#" data-style="styles" rel="stylesheet">

    <!-- Modernizr JS -->
    <script src="/<?php echo BASE_URL ?>/parent/js/vendor/modernizr-2.8.3.min.js"></script>

    <style>

    </style>
    <script>
        function addcart() {
            var qlt = $('#soluongProduct').val();
            $("input[name='product_quanlity']").val(qlt);
            $("input[name='product_quanlity_buy']").val(qlt);
        }
    </script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- START HEADER AREA -->
        <header class="header-area header-wrapper">
            <!-- header-top-bar -->
            <div class="header-top-bar plr-185">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 hidden-xs">
                            <div class="call-us">
                                <p class="mb-0 roboto">(+88) 01234-567890</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="top-link clearfix">
                                <ul class="link f-right">
                                    <li>
                                        <a href="my-account.html">
                                            <i class="zmdi zmdi-account"></i>
                                            My Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.html">
                                            <i class="zmdi zmdi-favorite"></i>
                                            Wish List (0)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="login.html">
                                            <i class="zmdi zmdi-lock"></i>
                                            Login
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-middle-area -->
            <div id="sticky-header" class="header-middle-area plr-185">
                <div class="container-fluid">
                    <div class="full-width-mega-dropdown">
                        <div class="row">
                            <!-- logo -->
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="logo">
                                    <a href="/<?php echo BASE_URL ?>/index.php">
                                        <img src="/<?php echo BASE_URL ?>/parent/img/logo/logo.png" alt="main logo">
                                    </a>
                                </div>
                            </div>
                            <!-- primary-menu -->
                            <div class="col-md-8 hidden-sm hidden-xs">
                                <nav id="primary-menu">
                                    <ul class="main-menu text-center">
                                        <li><a href="/subas/index.php">Trang chủ</a>
                                        </li>

                                        <li class="mega-parent"><a href="/subas/shop.php">Sản phẩm</a>
                                        </li>
                                        <li class="mega-parent"><a href="#">Pages</a>
                                        </li>
                                        <li><a href="#">Blog</a>
                                        </li>
                                        <li>
                                            <a href="#">About us</a>
                                        </li>
                                        <li>
                                            <a href="#">Contact</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- header-search & total-cart -->
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="search-top-cart  f-right">
                                    <!-- header-search -->
                                    <div class="header-search f-left">
                                        <div class="header-search-inner">
                                            <button class="search-toggle">
                                                <i class="zmdi zmdi-search"></i>
                                            </button>
                                            <form action="/<?php echo BASE_URL?>/resultsearch" method ="get">
                                                <div class="top-search-box">
                                                    <input type="text" name="keyword" placeholder="Search here your product...">
                                                    <button type="submit">
                                                        <i class="zmdi zmdi-search"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- total-cart -->
                                    <div class="total-cart f-left">
                                        <div class="total-cart-in">
                                            <div class="cart-toggler">
                                                <a <?php if ($isLogin == false) {
    echo 'href=/' . BASE_URL . '/login.php';
    if (isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['pagePre'] = $_SERVER['HTTP_REFERER'];
    }
} else {
    echo 'href=/' . BASE_URL . '/cart-list.php';
}?>>
                                                    <span class="cart-quantity"><?php echo $cart_qlt ?></span><br>
                                                    <span class="cart-icon">
                                                        <i class="zmdi zmdi-shopping-cart-plus"></i>
                                                    </span>
                                                </a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <div class="top-cart-inner your-cart">
                                                        <h5 class="text-capitalize">Giỏ hàng
                                                        </h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <?php $i = 0?>
                                                    <div class="total-cart-pro">
                                                        <!-- single-cart -->
                                                        <?php if (!empty($cartList_User)) { ?>
                                                        <?php foreach ($cartList_User as $cart_value) {
    $brandName = $brandModel->getBrandNamebyProductId($cart_value['product_id'])['brand_name'];
    $i++;
    ?>
                                                        <?php if ($i <= 3) {?>

                                                        <div class="single-cart clearfix">
                                                            <div class="cart-img f-left">
                                                                <a href="#">
                                                                    <img id="image-thumnail"
                                                                        src="/<?php echo BASE_URL ?>/public/images/<?php echo $cart_value['cart_image'] ?>"
                                                                        alt="Cart Product">
                                                                </a>
                                                                <div class="del-icon">
                                                                    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>"
                                                                        method="post">
                                                                        <input type="hidden" name="cartId"
                                                                            value="<?php echo $cart_value['cart_id'] ?>">
                                                                        <button type="submit"><i
                                                                                class="zmdi zmdi-close"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="cart-info f-left">
                                                                <h6 class="text-capitalize">
                                                                    <a
                                                                        href="#"><?php echo mb_substr($cart_value['product_name'], 0, 25) . '...' ?></a>
                                                                </h6>
                                                                <p>
                                                                    <span>Brand<strong>:</strong></span><?php echo $brandName ?>
                                                                </p>
                                                                <p>
                                                                    <span>Total<strong>:</strong></span><?php echo $cart_value['product_quanlity'] ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        <?php }?>
                                                    </div>
                                                    <?php     }?>
                                                </li>
                                                <li>
                                                    <div class="top-cart-inner subtotal">
                                                        <h4 class="text-uppercase g-font-2">
                                                            Tổng tiền:
                                                            <span><?php echo number_format($totalPrice, 2, ',', '.'); ?></span>
                                                        </h4>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="top-cart-inner view-cart">
                                                        <h4 class="text-uppercase">
                                                            <a href="/<?php echo BASE_URL ?>/cart-list.php">Xem giỏ
                                                                hàng</a>
                                                        </h4>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER AREA -->

        <!-- START MOBILE MENU AREA -->
        <div class="mobile-menu-area hidden-lg hidden-md">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul>
                                    <li><a href="/<?php echo BASE_URL ?>/index.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="/<?php echo BASE_URL ?>/shop.php">Sản phẩm</a>
                                    </li>
                                    <li><a href="#">Pages</a>
                                    </li>
                                    <li><a href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a href="#l">About Us</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MOBILE MENU AREA -->

        <!-- BREADCRUMBS SETCTION START -->
        <div class="breadcrumbs-section plr-200 mb-80">
            <div class="breadcrumbs overlay-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="breadcrumbs-inner">
                                <h1 class="breadcrumbs-title">Chi tiết sản phẩm</h1>
                                <ul class="breadcrumb-list">
                                    <li><a href="/<?php echo BASE_URL ?>/index.php">Trang chủ</a></li>
                                    <li>Chi tiết sản phẩm</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCRUMBS SETCTION END -->

        <!-- Start page content -->
        <section id="page-content" class="page-wrapper">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <!-- single-product-area start -->
                            <div class="single-product-area mb-80">
                                <div class="row">
                                    <!-- imgs-zoom-area start -->
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <div class="imgs-zoom-area">
                                            <img id="zoom_03"
                                                src="/<?php echo BASE_URL ?>/public/images/<?php echo $productItemId['product_image'] ?>"
                                                data-zoom-image="/<?php echo BASE_URL ?>/public/images/<?php echo $productItemId['product_image'] ?>"
                                                alt="">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div id="gallery_01" class="carousel-btn slick-arrow-3 mt-30">
                                                        <?php
$ProductImg = explode('/', $productItemId['product_image_other']);
foreach ($ProductImg as $value) {?>
                                                        <div class="p-c">
                                                            <a href="#"
                                                                data-image="/<?php echo BASE_URL ?>/public/images/<?php echo $value ?>"
                                                                data-zoom-image="/<?php echo BASE_URL ?>/public/images/<?php echo $value ?>">
                                                                <img class="zoom_03"
                                                                    src="/<?php echo BASE_URL ?>/public/images/<?php echo $value ?>"
                                                                    alt="">
                                                            </a>
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- imgs-zoom-area end -->
                                    <!-- single-product-info start -->
                                    <div class="col-md-7 col-sm-7 col-xs-12">

                                        <div class="single-product-info">
                                            <h3 class="text-black-1"><?php echo $productItemId['product_name'] ?>
                                            </h3>
                                            <h6 class="brand-name-2"><?php echo $productItemId['product_name'] ?>
                                            </h6>
                                            <!--  hr -->
                                            <hr>
                                            <!-- single-pro-color-rating -->
                                            <div class="single-pro-color-rating clearfix">
                                                <div class="sin-pro-color f-left">
                                                    <p class="color-title f-left">Color</p>
                                                    <div class="widget-color f-left">
                                                        <ul>
                                                            <li class="color-1"><a href="#"></a></li>
                                                            <li class="color-2"><a href="#"></a></li>
                                                            <li class="color-3"><a href="#"></a></li>
                                                            <li class="color-4"><a href="#"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="pro-rating sin-pro-rating f-right">
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star-outline"></i></a>
                                                    <span class="text-black-5">( 27 Rating )</span>
                                                </div>
                                            </div>
                                            <!-- hr -->
                                            <hr>
                                            <!-- plus-minus-pro-action -->

                                            <div class="plus-minus-pro-action clearfix">

                                                <div class="sin-plus-minus f-left clearfix">
                                                    <p class="color-title f-left">Qty</p>
                                                    <div class="cart-plus-minus f-left">
                                                        <input id="soluongProduct" type="text" value="1"
                                                            name="qtybutton" class="cart-plus-minus-box">
                                                    </div>
                                                </div>
                                                <div class="sin-pro-action f-right">
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Wishlist" tabindex="0"><i
                                                                    class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#productModal"
                                                                title="Quickview" tabindex="0"><i
                                                                    class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Compare" tabindex="0"><i
                                                                    class="zmdi zmdi-refresh"></i></a>
                                                        </li>

                                                        <li>
                                                            <form action ="<?php if ($isLogin == false) {
    echo '/' . BASE_URL . '/login.php';
    if (isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['pagePre'] = $_SERVER['HTTP_REFERER'];
    }
} else {
    echo '/' . BASE_URL . '/addcart.php?id='.$productItemId['product_id'];
}?>"
                                                                
                                                                method="post" onsubmit="return addcart();">
                                                                <input type="hidden" name="price_one_product" value="<?php echo $productItemId['product_price']?>">
                                                                <input type="hidden" name="product_quanlity">
                                                                <button id="btn-add-cart" type="submit"><i
                                                                        class="zmdi zmdi-shopping-cart-plus"></i></button>
                                                            </form>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- plus-minus-pro-action end -->
                                            <!-- hr -->
                                            <hr>
                                            <!-- single-product-price -->
                                            <h3 id ="giatien" class="pro-price">Giá:
                                                <?php echo number_format($productItemId['product_price'], 2, ',', '.') . 'đ' ?>
                                            </h3>
                                            <!--  hr -->
                                            <hr>
                                            <form
                                            action ="<?php if ($isLogin == false) {
    echo '/' . BASE_URL . '/login.php';
    if (isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['pagePre'] = $_SERVER['HTTP_REFERER'];
    }
} else {
    echo '/' . BASE_URL . '/addcart.php?id='.$productItemId['product_id'];
}?>"
                                                method="post" onsubmit="return addcart();">
                                                <input type="hidden" name="product_quanlity_buy">
                                                <div>
                                                    <button class="button extra-small button-black" type="submit">
                                                        <span class="btn-add-cart" id="btn-buy"
                                                            class="text-uppercase">Mua ngay</span>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- single-product-info end -->
                                </div>
                                <!-- single-product-tab -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- hr -->
                                        <hr>
                                        <div class="single-product-tab">
                                            <ul class="reviews-tab mb-20">
                                                <li class="active"><a href="#description" data-toggle="tab">Mô tả sản
                                                        phẩm</a></li>
                                                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="description">
                                                    <p><?php echo $productItemId['product_desc'] ?></p>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="information">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Autem,
                                                        neque fugit inventore quo dignissimos est iure natus quis
                                                        nam
                                                        illo officiis, deleniti consectetur non ,aspernatur.</p>
                                                    <p>rerum blanditiis dolore dignissimos expedita consequatur
                                                        deleniti
                                                        consectetur non exercitationem.</p>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="reviews">
                                                    <!-- reviews-tab-desc -->
                                                    <div class="reviews-tab-desc">
                                                        <!-- single comments -->
                                                        <div class="media mt-30">
                                                            <div class="media-left">
                                                                <a href="#"><img class="media-object"
                                                                        src="img/author/1.jpg" alt="#"></a>
                                                            </div>
                                                            <div class="media-body">
                                                                <div class="clearfix">
                                                                    <div class="name-commenter pull-left">
                                                                        <h6 class="media-heading"><a href="#">Gerald
                                                                                Barnes</a></h6>
                                                                        <p class="mb-10">27 Jun, 2017 at 2:30pm</p>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <ul class="reply-delate">
                                                                            <li><a href="#">Reply</a></li>
                                                                            <li>/</li>
                                                                            <li><a href="#">Delate</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-0">Lorem ipsum dolor sit amet,
                                                                    consectetur
                                                                    adipiscing elit. Integer accumsan egestas .</p>
                                                            </div>
                                                        </div>
                                                        <!-- single comments -->
                                                        <div class="media mt-30">
                                                            <div class="media-left">
                                                                <a href="#"><img class="media-object"
                                                                        src="img/author/2.jpg" alt="#"></a>
                                                            </div>
                                                            <div class="media-body">
                                                                <div class="clearfix">
                                                                    <div class="name-commenter pull-left">
                                                                        <h6 class="media-heading"><a href="#">Gerald
                                                                                Barnes</a></h6>
                                                                        <p class="mb-10">27 Jun, 2017 at 2:30pm</p>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <ul class="reply-delate">
                                                                            <li><a href="#">Reply</a></li>
                                                                            <li>/</li>
                                                                            <li><a href="#">Delate</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-0">Lorem ipsum dolor sit amet,
                                                                    consectetur
                                                                    adipiscing elit. Integer accumsan egestas .</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  hr -->
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-area end -->
                            <div class="related-product-area">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-title text-left mb-40">
                                            <h2 class="uppercase">related product</h2>
                                            <h6>There are many variations of passages of brands available,</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="active-related-product">
                                        <!-- product-item start -->
                                        <div class="col-xs-12">
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <a href="single-product.html">
                                                        <img src="img/product/1.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="single-product.html">Product Name</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                    </div>
                                                    <h3 class="pro-price">$ 869.00</h3>
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Wishlist"><i
                                                                    class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Compare"><i
                                                                    class="zmdi zmdi-refresh"></i></a>
                                                        </li>
                                                        <?php if ($isLogin == true) {?>
                                                        <li>
                                                            <a href="#" title="Thêm vào giỏ hàng"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                        </li>
                                                        <?php } else {
    header('location:login.php');
}?>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product-item end -->
                                        <!-- product-item start -->
                                        <div class="col-xs-12">
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <a href="single-product.html">
                                                        <img src="img/product/1.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="single-product.html">Product Name</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                    </div>
                                                    <h3 class="pro-price">$ 869.00</h3>
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Wishlist"><i
                                                                    class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Compare"><i
                                                                    class="zmdi zmdi-refresh"></i></a>
                                                        </li>
                                                        <?php if ($isLogin == true) {?>
                                                        <li>
                                                            <a href="#" title="Thêm vào giỏ hàng"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                        </li>
                                                        <?php } else {
    header('location:login.php');
}?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product-item end -->
                                        <!-- product-item start -->
                                        <div class="col-xs-12">
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <a href="single-product.html">
                                                        <img src="img/product/1.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="single-product.html">Product Name</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                    </div>
                                                    <h3 class="pro-price">$ 869.00</h3>
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Wishlist"><i
                                                                    class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Compare"><i
                                                                    class="zmdi zmdi-refresh"></i></a>
                                                        </li>
                                                        <?php if ($isLogin == true) {?>
                                                        <li>
                                                            <a href="#" title="Thêm vào giỏ hàng"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                        </li>
                                                        <?php } else {
    header('location:login.php');
}?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product-item end -->
                                        <!-- product-item start -->
                                        <div class="col-xs-12">
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <a href="single-product.html">
                                                        <img src="img/product/1.jpg" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="single-product.html">Product Name</a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                    </div>
                                                    <h3 class="pro-price">$ 869.00</h3>
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Wishlist"><i
                                                                    class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#productModal"
                                                                title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Compare"><i
                                                                    class="zmdi zmdi-refresh"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Thêm vào giỏ hàng"><i
                                                                    class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product-item end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <!-- widget-search -->
                            <aside class="widget-search mb-30">
                                <form action="#">
                                    <input type="text" placeholder="Search here...">
                                    <button type="submit"><i class="zmdi zmdi-search"></i></button>
                                </form>
                            </aside>
                            <!-- widget-categories -->
                            <aside class="widget widget-categories box-shadow mb-30">
                                <h6 class="widget-title border-left mb-20">Danh mục sản phẩm</h6>
                                <div id="cat-treeview" class="product-cat">
                                    <ul>
                                        <?php foreach ($categoryList as $categoryItem) {?>
                                        <li class="closed"><a href="#"><?php echo $categoryItem['category_name'] ?></a>
                                            <ul>
                                                <?php
$brandList = $brandModel->getBrandInCategory($categoryItem['category_id'])[0];
    $brandId = explode('/', $brandList['brand_id']);
    // $brandValue = explode()
    foreach ($brandId as $brandItem) {
        $brandValue = $brandModel->getBrandtById($brandItem);
        ?>
                                                <li><a
                                                        href="/<?php echo BASE_URL ?>/category.php/<?php echo str_replace(' ', '-', strtolower($categoryItem['category_name'] . '-' . $categoryItem['category_id'] . '-' . $brandItem)) ?>"><?php echo $brandValue['brand_name'] ?></a>
                                                </li>
                                                <?php }?>
                                            </ul>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </aside>
                            <!-- operating-system -->
                            <aside class="widget operating-system box-shadow mb-30">
                                <h6 class="widget-title border-left mb-20">operating system</h6>
                                <form action="http://demo.devitems.com/subas-preview/subas/action_page.php">
                                    <label><input type="checkbox" name="operating-1" value="phone-1">Windows
                                        Phone</label><br>
                                    <label><input type="checkbox" name="operating-1" value="phone-1">Bleckgerry
                                        ios</label><br>
                                    <label><input type="checkbox" name="operating-1" value="phone-1">Android</label><br>
                                    <label><input type="checkbox" name="operating-1" value="phone-1">ios</label><br>
                                    <label><input type="checkbox" name="operating-1" value="phone-1">Windows
                                        Phone</label><br>
                                    <label><input type="checkbox" name="operating-1" value="phone-1">Symban</label><br>
                                    <label class="mb-0"><input type="checkbox" name="operating-1"
                                            value="phone-1">Bleckgerry os</label><br>
                                </form>
                            </aside>
                            <!-- widget-product -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->

        </section>
        <!-- End page content -->

        <!-- START FOOTER AREA -->
        <footer id="footer" class="footer-area">
            <div class="footer-top">
                <div class="container-fluid">
                    <div class="plr-185">
                        <div class="footer-top-inner gray-bg">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-4">
                                    <div class="single-footer footer-about">
                                        <div class="footer-logo">
                                            <img src="img/logo/logo.png" alt="">
                                        </div>
                                        <div class="footer-brief">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the subas industry's standard dummy text
                                                ever since the 1500s,</p>
                                            <p>When an unknown printer took a galley of type and If you are going to use
                                                a passage of Lorem Ipsum scrambled it to make.</p>
                                        </div>
                                        <ul class="footer-social">
                                            <li>
                                                <a class="facebook" href="#" title="Facebook"><i
                                                        class="zmdi zmdi-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a class="google-plus" href="#" title="Google Plus"><i
                                                        class="zmdi zmdi-google-plus"></i></a>
                                            </li>
                                            <li>
                                                <a class="twitter" href="#" title="Twitter"><i
                                                        class="zmdi zmdi-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a class="rss" href="#" title="RSS"><i class="zmdi zmdi-rss"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 hidden-md hidden-sm">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Shipping</h4>
                                        <ul class="footer-menu">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>New
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Discount
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Best Sell
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Popular
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i
                                                        class="zmdi zmdi-circle"></i><span>Manufactirers</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Suppliers</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Special
                                                        Products</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">my account</h4>
                                        <ul class="footer-menu">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>My Account</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>My Wishlist</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>My Cart</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Sign In</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i
                                                        class="zmdi zmdi-circle"></i><span>Registration</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Check out</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Oder
                                                        Complete</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Get in touch</h4>
                                        <div class="footer-message">
                                            <form action="#">
                                                <input type="text" name="name" placeholder="Your name here...">
                                                <input type="text" name="email" placeholder="Your email here...">
                                                <textarea class="height-80" name="message"
                                                    placeholder="Your messege here..."></textarea>
                                                <button class="submit-btn-1 mt-20 btn-hover-1" type="submit">submit
                                                    message</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom black-bg">
                <div class="container-fluid">
                    <div class="plr-185">
                        <div class="copyright">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="copyright-text">
                                        <p>&copy; <a href="#" target="_blank">DevItems</a> 2017. All Rights Reserved.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <ul class="footer-payment text-right">
                                        <li>
                                            <a href="#"><img src="img/payment/1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/3.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/4.jpg" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER AREA -->

        <!-- START QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product clearfix">
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img alt="" src="img/product/quickview.jpg">
                                    </div>
                                </div><!-- .product-images -->

                                <div class="product-info">
                                    <h1>Aenean eu tristique</h1>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span class="new-price">£160.00</span>
                                            <span class="old-price">£190.00</span>
                                        </div>
                                    </div>
                                    <a href="single-product-left-sidebar.html" class="see-all">See all features</a>
                                    <div class="quick-add-to-cart">
                                        <form method="post" class="cart">
                                            <div class="numbers-row">
                                                <input type="number" id="french-hens" value="3">
                                            </div>
                                            <button class="single_add_to_cart_button" type="submit">Thêm vào giỏ
                                                hàng</button>
                                        </form>
                                    </div>
                                    <div class="quick-desc">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec
                                        est tristique auctor. Donec non est at libero.
                                    </div>
                                    <div class="social-sharing">
                                        <div class="widget widget_socialsharing_widget">
                                            <h3 class="widget-title-modal">Share this product</h3>
                                            <ul class="social-icons clearfix">
                                                <li>
                                                    <a class="facebook" href="#" target="_blank" title="Facebook">
                                                        <i class="zmdi zmdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="google-plus" href="#" target="_blank" title="Google +">
                                                        <i class="zmdi zmdi-google-plus"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="twitter" href="#" target="_blank" title="Twitter">
                                                        <i class="zmdi zmdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="pinterest" href="#" target="_blank" title="Pinterest">
                                                        <i class="zmdi zmdi-pinterest"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="rss" href="#" target="_blank" title="RSS">
                                                        <i class="zmdi zmdi-rss"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .product-info -->
                            </div><!-- .modal-product -->
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div>
            <!-- END Modal -->
        </div>
        <!-- END QUICKVIEW PRODUCT -->

        <!--style-customizer start -->
        <div class="style-customizer closed">
            <div class="buy-button">
                <a href="/<?php echo BASE_URL ?>/index.php" class="customizer-logo"><img src="images/logo/logo.png"
                        alt="Theme Logo"></a>
                <a class="opener" href="#"><i class="zmdi zmdi-settings"></i></a>
            </div>
            <div class="clearfix content-chooser">
                <h3>Layout Options</h3>
                <p>Which layout option you want to use?</p>
                <ul class="layoutstyle clearfix">
                    <li class="wide-layout selected" data-style="wide" title="wide"> Wide </li>
                    <li class="boxed-layout" data-style="boxed" title="boxed"> Boxed </li>
                </ul>
                <h3>Color Schemes</h3>
                <p>Which theme color you want to use? Select from here.</p>
                <ul class="styleChange clearfix">
                    <li class="skin-default selected" title="skin-default" data-style="skin-default"></li>
                    <li class="skin-green" title="green" data-style="skin-green"></li>
                    <li class="skin-purple" title="purple" data-style="skin-purple"></li>
                    <li class="skin-blue" title="blue" data-style="skin-blue"></li>
                    <li class="skin-cyan" title="cyan" data-style="skin-cyan"></li>
                    <li class="skin-amber" title="amber" data-style="skin-amber"></li>
                    <li class="skin-blue-grey" title="blue-grey" data-style="skin-blue-grey"></li>
                    <li class="skin-teal" title="teal" data-style="skin-teal"></li>
                </ul>
                <h3>Background Patterns</h3>
                <p>Which background pattern you want to use?</p>
                <ul class="patternChange clearfix">
                    <li class="pattern-1" data-style="pattern-1" title="pattern-1"></li>
                    <li class="pattern-2" data-style="pattern-2" title="pattern-2"></li>
                    <li class="pattern-3" data-style="pattern-3" title="pattern-3"></li>
                    <li class="pattern-4" data-style="pattern-4" title="pattern-4"></li>
                    <li class="pattern-5" data-style="pattern-5" title="pattern-5"></li>
                    <li class="pattern-6" data-style="pattern-6" title="pattern-6"></li>
                    <li class="pattern-7" data-style="pattern-7" title="pattern-7"></li>
                    <li class="pattern-8" data-style="pattern-8" title="pattern-8"></li>
                </ul>
                <h3>Background Images</h3>
                <p>Which background image you want to use?</p>
                <ul class="patternChange main-bg-change clearfix">
                    <li class="main-bg-1" data-style="main-bg-1" title="Background 1"> <img
                            src="images/customizer/bodybg/01.jpg" alt=""></li>
                    <li class="main-bg-2" data-style="main-bg-2" title="Background 2"> <img
                            src="images/customizer/bodybg/02.jpg" alt=""></li>
                    <li class="main-bg-3" data-style="main-bg-3" title="Background 3"> <img
                            src="images/customizer/bodybg/03.jpg" alt=""></li>
                    <li class="main-bg-4" data-style="main-bg-4" title="Background 4"> <img
                            src="images/customizer/bodybg/04.jpg" alt=""></li>
                    <li class="main-bg-5" data-style="main-bg-5" title="Background 5"> <img
                            src="images/customizer/bodybg/05.jpg" alt=""></li>
                    <li class="main-bg-6" data-style="main-bg-6" title="Background 6"> <img
                            src="images/customizer/bodybg/06.jpg" alt=""></li>
                    <li class="main-bg-7" data-style="main-bg-7" title="Background 7"> <img
                            src="images/customizer/bodybg/07.jpg" alt=""></li>
                    <li class="main-bg-8" data-style="main-bg-8" title="Background 8"> <img
                            src="images/customizer/bodybg/08.jpg" alt=""></li>
                </ul>
                <ul class="resetAll">
                    <li><a class="button button-border button-reset" href="#">Reset All</a></li>
                </ul>
            </div>
        </div>
        <!--style-customizer end -->
    </div>
    <!-- Body main wrapper end -->


    <!-- Placed JS at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="/<?php echo BASE_URL ?>/parent/js/vendor/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="/<?php echo BASE_URL ?>/parent/js/bootstrap.min.js"></script>
    <!-- jquery.nivo.slider js -->
    <script src="/<?php echo BASE_URL ?>/parent/lib/js/jquery.nivo.slider.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="/<?php echo BASE_URL ?>/parent/js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="/<?php echo BASE_URL ?>/parent/js/main.js"></script>
    <script src="/<?php echo BASE_UR; ?>/public/js/jquery-3.4.1.min.js"></script>
</body>


<!-- Mirrored from demo.devitems.com/subas-preview/subas/single-product.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:55:43 GMT -->

</html>