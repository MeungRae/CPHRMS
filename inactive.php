<?php
//require 'dbconfig.php';
include('security.php');
//session_start();
$errors=array('vererror'=>'');
$user=$_SESSION['user_id'];
$url=$_SESSION['url'];
if (isset($_POST["verify_email"]))
{
    //$email = $_POST["email"];
    $verification_code = $_POST["verification_code"];
$sql2="SELECT * from user where user_id= '" . $user . "'";
$result2=mysqli_query($connection, $sql2);
$ver = mysqli_fetch_array($result2);

    // connect with database
  if($verification_code!=$ver['verCode']){
    $errors['vererror']='Verification code failed.';
  }
else{
    // mark email as verified
   
	header('Location: ' . $url);
	exit;


	
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<form action="inactive.php" method="POST">

	<div class="login-box">
	  <h1>VERIFICATION</h1>
	  <div class="textbox">
		<i class="fas fa-user"></i>
        <input type="number" name="verification_code" pattern="[0-9]{6}" min="000000"max="999999" placeholder="Enter verification code" required />
		
	</div>
	<div class="textbox">
        <input type="hidden"  name="hidden" placeholder="hidden"/>
		
	</div>
    <?php  
				if(!empty($errors['vererror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['vererror'];?></div>
                <?php
                }
                ?>
	<input type="submit" class="btn" name="verify_email" value="Verify">
    <center>
					<a style="color:white"href="logout_session.php">Back To Login</a>
</center>
	
   </div>
            </form>
</body>
</html>
<style>
@import "https://use.fontawesome.com/releases/v5.5.0/css/all.css";
body{
	margin:0;
	padding:0;
	font-family: sans-serif;
	background-image: url("bg1.jpg");
	
	background-size: cover;
}
.login-box
{
	width: 280px;
	position: absolute;
	top: 50%;
	left:50%;
	transform: translate(-50%,-50%);
	color: white;	
}
.login-box h1
{
	float: left;
	font-size: 40px;
	border-bottom: 6px solid #4caf50;
	margin-bottom: 50px;
	padding: 13px 0;
}	
.textbox
{
	width: 100%;
	overflow: hidden;
	font-size: 20px;
	padding: 8px 0;
	margin: 8px 0;
	border-bottom: 1px solid #4caf50;	
}
.textbox icon
{
	width: 26px;
	float: left;
	text-align: center;	
}
.textbox input
{
	border: none;
	outline: none;
	background: none;
	color: white;
	font-size: 18px;
	width: 80%;
	float: left;
	margin: 0 10px;
}
.btn
{
	width: 100%;
	background: none;
	border:  2px solid #4caf50;
	color: white;
	padding: 5px;
	font-size:18px;
	cursor: pointer;
	margin: 12px 0;
}
</style>
<?php
include('includes/scripts2.php');
?>
