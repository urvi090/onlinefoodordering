<?php 
// include('default.php');
include('header.php');
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
          <li class="active"> Contact Us </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="contact-area pt-100 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="contact-info-wrapper text-center mb-30">
            <div class="contact-info-icon hov_icon">
              <!-- <i class="ion-ios-location-outline"></i> -->
              <i class='bx bx-current-location' ></i>
            </div>
            <div class="contact-info-content">
              <h4>Our Location</h4>
              <p>201 345 2678 / 614 456 0789</p>
              <p><a href="#">info@eatery.com</a></p>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 col-12">
          <div class="contact-info-wrapper text-center mb-30">
            <div class="contact-info-icon">
              <!-- <i class="ion-ios-telephone-outline"></i> -->
              <i class='bx bx-phone'></i>
            </div>
            <div class="contact-info-content">
              <h4>Contact us Anytime</h4>
              <p>Mobile: 201 642 0912</p>
              <p>Fax: 123 456 789</p>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 col-12">
          <div class="contact-info-wrapper text-center mb-30">
            <div class="contact-info-icon">
              <!-- <i class="ion-ios-email-outline"></i> -->
              <i class='bx bx-envelope'></i>
            </div>
            <div class="contact-info-content">
              <h4>Write Some Words</h4>
              <p><a href="#">Support24/7@eatery.com </a></p>
              <p><a href="#">info@eatery.com</a></p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12">
          <div class="contact-message-wrapper">
            <h4 class="contact-title">GET IN TOUCH</h4>
            <div class="contact-message">
              <form id="contact-form" action="contact_us_submit.php" method="post">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="contact-form-style mb-20">
                      <input name="name" placeholder="Full Name" type="text" required>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="contact-form-style mb-20">
                      <input name="email" placeholder="Email Address" type="email" required>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="contact-form-style mb-20">
                      <input name="phone" placeholder="Phone Number" type="text" required>
                    </div>
                  </div>
                  
                  <div class="col-lg-12">
                    <div class="contact-form-style mb-20">
                      <input name="subject" placeholder="Subject" type="text" required>
                    </div>
                  </div>
                  
                  <div class="col-lg-12">
                    <div class="contact-form-style">
                      <textarea name="message" placeholder="Message" required></textarea>
                      <button class="submit btn-style" type="submit">SEND MESSAGE</button>
                    </div>
                  </div>
                </div>
              </form>
              <p class="form-messege"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
include('footer.php');
?>
