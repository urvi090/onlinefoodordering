<?php
include('header.php');

if(!isset($_SESSION['USER_ID'])){
  redirect(FRONTEND_SITE_PATH.'main');
}

$getUserInfo = getUserInfo();

// prx($getUserInfo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile</title>
</head>
<body>
  <div class="breadcrumb-area gray-bg">
    <div class="container">
      <div class="breadcrumb-content">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li class="active">My Account </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="myaccount-area pb-80 pt-100">
    <div class="container">
      <div class="row">
        <div class="ml-auto mr-auto col-lg-9">
          <div class="checkout-wrapper">
            <div id="faq" class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                </div>
                <div id="my-account-1" class="panel-collapse collapse show">
                  <div class="panel-body">
                    <form method="post" id="fromProfile">
                      <div class="billing-information-wrapper">
                        <div class="account-info-wrapper">
                          <h4>My Account Information</h4>
                          <h5>Your Personal Details</h5>
                        </div>
                        <div class="row">
                          <div class="col-lg-6 col-md-6">
                            <div class="billing-info">
                              <label>First Name</label>
                              <input type="text" name="fname" id="cst_fname" value="<?php echo $getUserInfo['fname']?>" required>
                            </div>
                          </div>

                          <div class="col-lg-6 col-md-6">
                            <div class="billing-info">
                              <label>Last Name</label>
                              <input type="text" name="lname" value="<?php echo $getUserInfo['lname']?>" required>
                            </div>
                          </div>

                          <div class="col-lg-12 col-md-12">
                            <div class="billing-info">
                              <label>Email Address</label>
                              <input type="email" value="<?php echo $getUserInfo['email']?>" readonly='readonly'>
                            </div>
                          </div>
                                                        
                          <div class="col-lg-6 col-md-6">
                            <div class="billing-info">
                              <label>Phone Number</label>
                              <input type="number" name="phone" value="<?php echo $getUserInfo['phone']?>" required>
                            </div>
                          </div>
                        </div>

                        <div class="billing-back-btn">
                          <div class="billing-back">
                            <a href="#"><i class="ion-arrow-up-c"></i> Back</a>
                          </div>
                          <div class="billing-btn">
                            <button type="submit" id="profile_btn">Save</button>
                          </div>
                        </div>
                        <div id="form_msg"></div>
                      </div>
                      <input type="hidden" name="type" value="profile">
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="panel panel-default">
              <div class="panel-heading">
                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
              </div>
              
              <div id="my-account-2" class="panel-collapse collapse">
                <div class="panel-body">
                  <form method="post" id="formPassword">
                    <div class="billing-information-wrapper">
                      <div class="account-info-wrapper">
                        <h4>Change Password</h4>
                        <h5>Your Password</h5>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 col-md-12">
                          <div class="billing-info">
                            <label>Password</label>
                            <input type="password" name="old_password" required>
                          </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                          <div class="billing-info">
                            <label>Password Confirm</label>
                            <input type="password" name="new_password" required>
                          </div>
                        </div>
                      </div>
                      
                      <div class="billing-back-btn">
                        <div class="billing-back">
                          <a href="#"><i class="ion-arrow-up-c"></i> Back</a>
                        </div>

                        <div class="billing-btn">
                          <button type="submit" id="password_btn">Save</button>
                        </div>
                      </div>
                      <input type="hidden" name="type" value="password">
                      <div id="password_form_msg"></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>                
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