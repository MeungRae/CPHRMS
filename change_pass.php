<?php
include('dbconfig.php');
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
$errors=array('logerror'=>'');
$success=array('changepass'=>'');
$_SESSION['url']='http://localhost/cphrms/admin/change_pass.php';

if(isset($_POST['submit_btn']))
{
$cpassword = $_POST['curpass'];

$usr=$_SESSION['user_id'];
$query = "SELECT * FROM user WHERE user_id='" . $usr . "' LIMIT 1";
$query_run = mysqli_query($connection, $query);
if(mysqli_num_rows($query_run)==1){
	$usertypes = mysqli_fetch_array($query_run);
    $data['password']=$usertypes['password'];
    if(password_verify($cpassword,$data['password'])){
        $new=$_POST['newpass'];
        $con=$_POST['conpass'];
        if (!empty($_POST['newpass'])) {
            if ($new != $con) {
                $errors['logerror'] = 'Your password did not match the confirmed password.';
            } else {
            $password = mysqli_real_escape_string($connection, trim($_POST['newpass']));
            $pw=password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET password ='$pw' WHERE user_id = '" . $usr . "'";
            $result= mysqli_query($connection, $sql);
            if(empty($errors['logerror'])){
               $success['changepass']='Password Change Complete';
			  
        }
    }
    
    }

}else{
    $errors['logerror'] = 'Incorrect Password.';
}
   
   
        
} else {
    $errors['logerror'] = 'User Not Exist.';
}
}


?>

    
   
<div class="form-style-10">
<h1>Change Password</h1>
<form action="change_pass.php" method="POST" enctype="multipart/form-data">
   
    <div class="inner-wrap">
    <?php  
				if(!empty($errors['logerror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['logerror'];?></div>
                <?php
                }
                ?>
                <?php  
				if(!empty($success['changepass'])){
                    ?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $success['changepass'];?></div>
                <?php
				sleep(5);
				echo "<script>window.location.href='logout_session.php';</script>";

                }
                ?>
    <input id="password-field" type="password" class="form-control" name="curpass" minlength="8" placeholder="Current Password" required>
    <label></label>
    <input id="password-field" type="password" class="form-control" name="newpass" minlength="8" placeholder="New Password" required>
    <label></label>
    <input id="password-field" type="password" class="form-control" name="conpass" minlength="8" placeholder="Confirm New Password" required>
    <label></label>   
    </div>
    <div class="button-section">
    <button type="submit" onclick="checker()"class="form-control btn btn-primary submit px-3" name="submit_btn">Change</button>
     
    </div>
</form>
</div>
<link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
<style type="text/css">
.form-style-10{
	width:950px;
	padding:30px;
	margin:40px auto;
	background: #FFF;
	border-radius: 10px;
	-webkit-border-radius:10px;
	-moz-border-radius: 10px;
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
}
.form-style-10 .inner-wrap{
	padding: 30px;
	background: #F8F8F8;
	border-radius: 6px;
	margin-bottom: 15px;
}
.form-style-10 h1{
	background: #2A88AD;
	padding: 20px 30px 15px 30px;
	margin: -30px -30px 30px -30px;
	border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	color: #fff;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
	font: normal 30px 'Bitter', serif;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	border: 1px solid #257C9E;
}
.form-style-10 h1 > span{
	display: block;
	margin-top: 2px;
	font: 13px Arial, Helvetica, sans-serif;
}
.form-style-10 label{
	display: block;
	font: 13px Arial, Helvetica, sans-serif;
	color: #888;
	margin-bottom: 15px;
}
.form-style-10 input[type="text"],
.form-style-10 input[type="date"],
.form-style-10 input[type="datetime"],
.form-style-10 input[type="email"],
.form-style-10 input[type="number"],
.form-style-10 input[type="search"],
.form-style-10 input[type="time"],
.form-style-10 input[type="url"],
.form-style-10 input[type="password"],
.form-style-10 textarea,
.form-style-10 select {
	display: block;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	width: 100%;
	padding: 8px;
	border-radius: 6px;
	-webkit-border-radius:6px;
	-moz-border-radius:6px;
	border: 2px solid #fff;
	box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
	-moz-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
	-webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
}

.form-style-10 .section{
	font: normal 20px 'Bitter', serif;
	color: #2A88AD;
	margin-bottom: 5px;
}
.form-style-10 .section span {
	background: #2A88AD;
	padding: 5px 10px 5px 10px;
	position: absolute;
	border-radius: 50%;
	-webkit-border-radius: 50%;
	-moz-border-radius: 50%;
	border: 4px solid #fff;
	font-size: 14px;
	margin-left: -45px;
	color: #fff;
	margin-top: -3px;
}
.form-style-10 input[type="button"], 
.form-style-10 input[type="submit"]{
	background: #2A88AD;
	padding: 8px 20px 8px 20px;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	color: #fff;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
	font: normal 30px 'Bitter', serif;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	border: 1px solid #257C9E;
	font-size: 15px;
}
.form-style-10 input[type="button"]:hover, 
.form-style-10 input[type="submit"]:hover{
	background: #2A6881;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.28);
}
.form-style-10 .privacy-policy{
	float: right;
	width: 250px;
	font: 12px Arial, Helvetica, sans-serif;
	color: #4D4D4D;
	margin-top: 10px;
	text-align: right;
}
</style>
<script>
    function checker(){
        var result= confirm('Are you sure you want to change your password?');
        if (result==false){
            event.preventDefault();
        }
    }
</script>


  <?php
include('includes/scripts.php');
include('includes/footer.php');
?>