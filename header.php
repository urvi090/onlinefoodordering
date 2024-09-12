<?php 
include('database.php');
include('function.php');
include('default.php');

session_start();

$totalPrice = 0;
getFoodCartStatus();

if(isset($_POST['update_cart'])){
  foreach($_POST['qty'] as $key=> $val){
    if(isset($_SESSION['USER_ID'])){
      if($val[0] == 0){
        $added_cart_del_sql = "delete from food_cart where food_item_id='$key' and customer_id=".$_SESSION['USER_ID'];
        $added_cart_del_res = mysqli_query($con,$added_cart_del_sql);
      }else{
        $added_cart_upd_sql = "update food_cart set 	food_qty='".$val[0]."' where food_item_id='$key' and customer_id=".$_SESSION['USER_ID'];
        $added_cart_upd_res = mysqli_query($con,$added_cart_upd_sql);
      }
      
    }else{
      if($val[0] == 0){
        unset($_SESSION['cart'][$key]['qty']);
      }else{
        $_SESSION['cart'][$key]['qty']=$val[0];
      }
    }
  }
}

$cartArry = get_cart_detail();

//prx($cartArry);

foreach($cartArry as $list){
  $totalPrice = $totalPrice+($list['food_qty']*$list['price']);
}

$totalFoodAdded = count($cartArry);
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo FRONTEND_WEBSITE_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" type="image/svg" href="front_assets/img/brand-logo/the-eatery.svg" />
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/animate.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/slick.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/chosen.min.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/meanmenu.min.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/style.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/signup.css">
  <link rel="stylesheet" href="<?php echo FRONTEND_SITE_PATH?>front_assets/css/responsive.css">
  <script src="<?php echo FRONTEND_SITE_PATH?>front_assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
  <header class="header-area">
    <div class="header-top black-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-12 col-sm-4">
            <div class="welcome-area">
              <p>Welcome to The Eatery Restaurant </p>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-12 col-sm-8">
            <div class="account-curr-lang-wrap f-right">
            <?php
                if(isset($_SESSION['USER_NAME'])){
              ?>
              <ul>
                <li class="top-hover"><a href="#"><?php 
                        echo "Welcome <span id='cst_header_name'>".$_SESSION['USER_NAME'];
                    ?></span>
                    <i class='bx bxs-chevron-down down_arr'></i> 
                  <!-- <i class="down-icon ion-chevron-down"></i> </a> -->
                  <ul>
                    <li><a href="profile.php">My Account</a></li>
                    <li><a href="order_history.php">Order History</a></li>
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                </li>
              </ul>
              <?php 
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header-middle">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-12 col-sm-4">
            <div class="logo">
              <a href="<?php echo FRONTEND_SITE_PATH?>index">
                <img alt="" src="<?php echo FRONTEND_SITE_PATH?>front_assets/img/brand-logo/the-eatery.svg">
              </a>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 col-12 col-sm-8">
            <div class="header-middle-right f-right">
              <div class="header-login">
              <?php 
                if(!isset($_SESSION['USER_NAME'])){ 
              ?>
                <a href="<?php echo FRONTEND_SITE_PATH?>login_signup">
                  <div class="header-icon-style">
                    <i class="icon-user icons"></i>
                  </div>
                  <div class="login-text-content">
                    <p>Sign up <br> or <span>Sign in</span></p>
                  </div>
                </a>
              <?php 
                }
              ?>
              </div>
              <div class="header-wishlist">
                &nbsp;
              </div>
              <div class="header-cart">
                <a href="<?php echo FRONTEND_SITE_PATH?>cart">
                  <div class="header-icon-style">
                    <i class="icon-handbag icons"></i>
                    <span class="count-style" id="totalFoodAdded"><?php echo $totalFoodAdded?></span>
                  </div>
                  <div class="cart-text">
                    <span class="digit">My Cart</span>
                    <span class="cart-digit-bold" id="totalPrice">
                      <?php
                        if($totalPrice != 0){
                          echo '$ '.$totalPrice;
                        }
                      ?>
                    </span>
                  </div>
                </a>
                <?php if($totalPrice != 0){ ?>
                  <div class="shopping-cart-content">
                    <ul id="cart_ul">
                      <?php foreach($cartArry as $key=>$list){ ?>
                        <li class="single-shopping-cart" id="attr_<?php echo $key ?>">
                          <div class="shopping-cart-img">
                            <a href="javascript:void(0)"><img alt="" src="<?php echo SITE_FOOD_IMG_CALL.$list['image']?>"></a>
                          </div>
                          <div class="shopping-cart-title">
                            <h4><a href="javascript:void(0)"> <?php echo $list['name']?> </a></h4>
                            <h6>Qty: <?php echo $list['food_qty']?> </h6>
                            <span> $ <?php echo number_format($list['food_qty']*$list['price'],2); ?> </span>
                          </div>
                          <div class="shopping-cart-delete">
                            <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key?>')"><i class="ion ion-close"></i></a>
                          </div>
                        </li>
                      <?php } ?>
                    </ul>
                    <div class="shopping-cart-total">
                      <h4>Total : <span class="shop-total">$ <?php echo number_format($totalPrice,2) ?></span></h4>
                    </div>
                    <div>
                      <a href="cart.php"></a>
                    </div>
                    <div class="shopping-cart-btn">
                      <button onclick="viewCart()" class="add_to_cart_btn">View Cart</button>
                      <button onclick="checkout()" class="add_to_cart_btn">Checkout</button>
                    </div>
                  </div>
                <?php 
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="header-bottom transparent-bar black-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <div class="main-menu">
              <nav>
                <ul>
                  <li><a href="<?php echo FRONTEND_SITE_PATH?>main">Home</a></li>
                  <li><a href="<?php echo FRONTEND_SITE_PATH?>about_us">About Us</a></li>
                  <li><a href="<?php echo FRONTEND_SITE_PATH?>contact_us">Contact Us</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mobile-menu-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="mobile-menu">
              <nav id="mobile-menu-active">
                <ul class="menu-overflow" id="nav">
                  <li><a href="<?php echo FRONTEND_SITE_PATH?>main">Home</a></li>
                  <li><a href="<?php echo FRONTEND_SITE_PATH?>about_us">About Us</a></li>
                  <li><a href="<?php echo FRONTEND_SITE_PATH?>contact_us">Contact Us</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</body>
</html>