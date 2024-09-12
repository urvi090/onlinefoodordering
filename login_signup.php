<?php 
// include('default.php');
include('header.php');

?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
</head>
<body>
  <div class="login-register-area pt-95 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-12 ml-auto mr-auto">
          <div class="login-register-wrapper">
            <div class="login-register-tab-list nav">
              <a class="active" data-toggle="tab" href="#lg1">
                <h4> login </h4>
              </a>
              <a data-toggle="tab" href="#lg2">
                <h4> Sign Up </h4>
              </a>
            </div>
            <div class="tab-content">
              <div id="lg1" class="tab-pane active">
                <div class="login-form-container">
                  <div class="login-register-form">
                    <form method="post" id="formLogin">
                      <div class="items input_div">
                        <input type="email" placeholder="Enter Email" class="input" name="user_email" required>
                      </div>

                      <div class="items input_div">
                        <input type="password" placeholder="Enter Password" class="password" name="user_password" required>
                        <i class='bx bx-hide hide_icone'></i>
                      </div>

                      <div>
                        <input type="submit" name="submit" id="login_submit_btn" value="login" class="button_div"/>
                      </div>

                      <input type="hidden" name="sign_reg" value="login_msg"/>
                      <input type="hidden" name="is_checkout" id="is_checkout" value=""/>

                      <span id="email_error" class="errMsg"></span>

                      <div id="login_form_msg" class="succMsg"></div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="lg2" class="tab-pane">
                <div class="login-form-container">
                  <div class="login-register-form">
                    <form method="post" id="formSignup">
                      <input type="text" name="fname" id="fname" placeholder="Enter First Name" required/>

                      <input type="text" name="lname" id="lname" placeholder="Enter Last Name" required/>

                      <input type="email" name="email" id="email" placeholder="Enter Email" required/>

                      <span id="email_error_sign" class="errMsgSign ml-10"></span>

                      <input type="number" name="phone" id="phone" placeholder="Enter Phone Number" required/>

                      <input type="password" name="password" id="password" class="password" placeholder="Enter Password" required/>

                      <div class="items">
                        <input  type="password" name="compassword" id="compassword" class="password" placeholder="Re-Enter Comfirm Password" required/>
                        <i class='bx bx-hide hide_icone'></i>
                      </div>

                      <span id="pass_error" class="passMsg ml-10"></span>

                      <div>
                        <input type="submit" name="submit" id="signup" value="signup" class="button_div"/>
                      </div>

											<input type="hidden" name="sign_reg" value="register"/>

                      <span id="wait_msg" class="passMsg ml-10"></span>

                      <div id="signup_form_msg" class="succMsg"></div>

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
