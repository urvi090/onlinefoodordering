<?php 
// include('database.php');
// include('function.php');
// include('default.php');
include('header.php');
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo FRONTEND_WEBSITE_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="front_assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="front_assets/css/animate.css">
  <link rel="stylesheet" href="front_assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="front_assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="front_assets/css/style.css">
  <link rel="stylesheet" href="front_assets/css/responsive.css">
  <script src="front_assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
  <div class="slider-area">
    <div class="slider-active owl-dot-style owl-carousel">
      <?php
        $slid_sel_sql = "select * from slider where slider_status = '1' order by slider_stack";
        $slid_res = mysqli_query($con,$slid_sel_sql);
        while($slid_row = mysqli_fetch_assoc($slid_res)){ ?>        
      <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url(<?php echo SITE_SLIDER_IMG_CALL.$slid_row['image'] ?>);">
        <div class="container">
          <div class="slider-content slider-animated-1">
            <h1 class="animated"><?php echo $slid_row['heading']?></h1>
            <h3 class="animated"><?php echo $slid_row['sub_heading'] ?></h3>
            <div class="slider-btn mt-90">
              <a class="animated" href="<?php echo $slid_row['link'] ?>"><?php echo $slid_row['link_text'] ?></a>
            </div>
          </div>
        </div>
      </div>
      <?php
        } 
      ?>
    </div>
  </div>      
</body>
</html>

<?php
include('footer.php');
?>
