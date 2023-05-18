<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo SITENAME; ?></title>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/images/logo/favicon.ico" type="images/x-icon"/>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/lightcase.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/meanmenu.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/main.css">
    <style>
        input[type=number].disable_count::-webkit-inner-spin-button,
        input[type=number].disable_count::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

    </style>
</head>

<body class="dark-bg">

<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
            <div class="spinner"></div>
            <div class="txt-loading">
                    <span data-text-preloader="C" class="letters-loading">
                        C
                    </span>
                <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                <span data-text-preloader="F" class="letters-loading">
                        F
                    </span>
                <span data-text-preloader="E" class="letters-loading">
                        E
                    </span>
                <span data-text-preloader="N" class="letters-loading">
                        N
                    </span>
                <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
            </div>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- preloader end -->

<!-- header start -->
<!--<header class="site-header site-header__3 position-absolute">-->
<header class="site-header site-header__3">
    <div class="menu-area menu-area__3">
        <div class="container-fluid custom-width custom-width__2">
            <div class="row d-none d-xl-flex">
                <div class="col-xl-5 col-lg-4 col-md-5 align-self-center">
                    <div class="main-menu main-menu__3">
                        <nav>
                            <ul>
                                <?php if (IsAdmin()) : ?>
                                    <li><a href="<?php echo URLROOT; ?>/categories">Categories</a></li>
                                <?php endif; ?>
                                <?php if (isLoggedIn()) : ?>
                                    <li><a href="<?php echo URLROOT; ?>/checks">Checks</a></li>
                                <?php endif; ?>
                                <?php if (isLoggedIn()) : ?>
                                    <li><a href="<?php echo URLROOT; ?>/orders">Orders</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo URLROOT; ?>/products">Product</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 d-none d-lg-block text-center align-self-center">
                    <div class="logo">
                        <a href="<?php echo URLROOT; ?>/products">
                            <img src="<?php echo URLROOT; ?>/assets/images/logo/logo.png" alt="img">
                        </a>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-7 align-self-center">
                    <div class="menu-area__right menu-area__right--3 d-flex justify-content-end align-items-center">
                        <div class="main-menu main-menu__3">
                            <nav>
                                <ul>
                                    <?php if (isLoggedIn()): ?>
                                        <li class="menu-item-has-children">
                                            <a href="">
                                                <?php echo $_SESSION['user_name'] ?>
                                            </a>
                                            <ul class="sub-menu">
                                                <li><a href="<?php echo URLROOT; ?>/users/logout">Logout</a></li>
                                            </ul>
                                        </li>
                                        <?php if (IsAdmin()): ?>
                                            <li><a href="<?php echo URLROOT; ?>/users">Users</a></li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row d-lg-flex d-xl-none">
                <div class="col-xl-9 col-lg-10 col-6">
                    <div class="wrapper-for-lg d-flex align-items-center">
                        <div class="logo d-lg-none">
                            <a href="index.html">
                                <img src="<?php echo URLROOT; ?>/assets/images/logo/logo.png" alt="img">
                            </a>
                        </div>
                        <div class="main-menu main-menu__3">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="menu-item-has-children active"><a href="index.html">Home</a>
                                        <ul class="sub-menu">
                                            <li class="active"><a href="index.html">Home 01</a></li>
                                            <li><a href="home-2.html">Home 02</a></li>
                                            <li><a href="home-3.html">Home 03</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="menu.html">Menu</a></li>
                                    <li><a href="reservation.html">Reservation</a></li>
                                    <li><a href="#0">pages</a>
                                        <ul class="sub-menu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                            <li><a href="chefs.html">Chefs</a></li>
                                            <li><a href="faq.html">Faq</a></li>
                                            <li><a href="story.html">Story</a></li>
                                            <li><a href="gallery.html">Gallery</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="shop.html">Shop</a>
                                        <ul class="sub-menu">
                                            <li><a href="shop.html">Shop</a></li>
                                            <li><a href="product-details.html">Shop Details</a></li>
                                            <li><a href="cart.html">Shop Cart</a></li>
                                            <li><a href="checkout.html">Shop Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-6 align-self-center">
                    <div class="menu-area__right d-flex justify-content-end align-items-center">
                        <div class="search">
                            <div class="search__trigger item">
                                <span class="open"><i class="far fa-search"></i></span>
                                <span class="close"><i class="fal fa-times"></i></span>
                            </div>
                            <div class="search__form">
                                <form role="search" method="get"
                                      action="https://xpressrow.com/html/cafena/cafena/index.html">
                                    <input type="search" name="s" value="" placeholder="Search Keywords">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="hamburger-trigger item">
                            <i class="far fa-bars"></i>
                        </div>
                        <div class="cart cart-trigger item position-relative">
                            <i class="fa fa-shopping-basket"></i>
                            <span class="cart__count">3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="overlay"></div>

<main class="container">