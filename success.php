<?php 
// include('default.php');
include('header.php');

if(!isset($_SESSION['ORDER_ID'])){
  redirect(FRONTEND_SITE_PATH.'main');
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
</head>
<body>
  <div class="breadcrumb-area gray-bg">
    <div class="container">
      <div class="breadcrumb-content">
        <ul>
          <li><a href="<?php echo FRONTEND_SITE_PATH?>index">Home</a></li>
          <li class="active">About us </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="about-us-area pt-50 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-7 d-flex align-items-center">
          <div class="overview-content-2">
            <h2>Your Order#<span>Order Id: <?php echo $_SESSION['ORDER_ID'] ?></span> has been placed Successfully...🎉</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
unset($_SESSION['ORDER_ID']);
include('footer.php');
?>
