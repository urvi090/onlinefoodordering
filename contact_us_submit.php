<?php 
include('database.php');
include('function.php');
include('default.php');

$name = safe_valueto($_POST['name']);
$email = safe_valueto($_POST['email']);
$phone = safe_valueto($_POST['phone']);
$subject = safe_valueto($_POST['subject']);
$message = safe_valueto($_POST['message']);

$cont_ins_sql = "insert into contact(name,email,phone,subject,message) values('$name','$email','$phone','$subject','$message')";
$cont_res = mysqli_query($con,$cont_ins_sql);

echo "Thank you for contacting us";
?>
