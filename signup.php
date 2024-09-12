<?php
include ('database.php');
include('function.php');

if(isset($_POST['submit'])){
  $fnm = safe_valueto($_POST['fname']);
  $lnm = safe_valueto($_POST['lname']);
  $eml = safe_valueto($_POST['email']);
  $phn = safe_valueto($_POST['phone']);
  $pass = md5($_POST['password']);
  $cpass = md5($_POST['compassword']);
  $user_type = $_POST['user_type'];

  $sql = "select * from reg_login where email = '$eml' and password = '$pass'";

  $res = mysqli_query($con,$sql);
  
  if(mysqli_num_rows($res) > 0){
    $error[] = 'User already Exist!!';
  }else{
    if($pass != $cpass){
      $error[] = 'Password Not Matched!!';
    }else{
      $sql_insert = "insert into reg_login(fname,lname,email,phone_number,password,user_type) values('$fnm','$lnm','$eml','$phn','$pass','$user_type')";
      mysqli_query($con,$sql_insert);
      echo"
        <script>
          alert('Sign up Successfully...!');
          window.location.href = 'login.php';
        </script>";
    }
  }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form</title>

  <!-- Boxicons Link-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- CSS Link -->
  <link rel="stylesheet" href="assets/css/signup.css" />
  <link rel="stylesheet" href="assets/css/fonts.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

  <div class="constiner_forms forms">
    <form action="" method="post">
      <h3 class="pagefor">Sign Up</h3>
      
      <?php 
        if(isset($error)){
          foreach($error as $error){
            echo'<span class="err_msg">'.$error. '</span>';
          }
        }
      ?>

      <input type="text" name="fname" placeholder="Enter First Name" required>

      <input type="text" name="lname" placeholder="Enter Last Name" required>
      
      <input type="email" name="email" placeholder="Enter Email" required>

      <input type="number" name="phone" placeholder="Enter Phone Number" required>
      
      <input type="password" name="password" class="password" placeholder="Enter Password" required>

      <div class="items">
        <input  type="password" name="compassword" class="password" placeholder="Re-Enter Comfirm Password" required>
        <i class='bx bx-hide hide_icone'></i>
      </div>

      <select name="user_type">
        <option value="customer">Customer</option>
        <option value="admin">Admin</option>
      </select>
      
      <input type="submit" name="submit" value="signup" class="button_div">

      <div class="form_link">
        <span>Already have an account? <a href="<?php echo FRONTEND_SITE_PATH?>login" class="link signup_link"> Login</a></span>
      </div>

    </form>
  </div>

    <!-- <section class="container forms">
      <div class="outter_form_div login">
        <div class="form_details">
          <header>Signup Form</header>

          <form action="#">
            <div class="items input_div">
              <input type="email" placeholder="Email" class="input">
            </div>

            <div class="items input_div">
              <input type="password" placeholder="Password" class="password">
              <i class='bx bx-hide hide_icone'></i>
            </div>
            
            <div class="items button_div">
              <button>Signup</button>
            </div>
          </form>

          <div class="form_link">
            <span>Already have an account? <a href="login.html" class="login_link">Login</a></span>
          </div>

        </div>
      </div>
    </section> -->

    <!--JS Links-->
    <script src="assets/js/script.js"></script>
</body>
</html>