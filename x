<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.
//include('security.php');
$page_title = 'Register';
include('dbconfig.php');
include ('includes/header.php');
include ('includes/navbar.php');
include('../encryption/encryption.php');

//include('security.php');

function generateKey(){
	$keyLength=15;
	$uniq=uniqid("CPHRMS_");
	$randStr=substr($uniq,0,$keyLength);
	return $randStr;
}
function generateDKey(){
	$keyLength=15;
	$uniq=uniqid("LAB_");
	$randStr=substr($uniq,0,$keyLength);
	return $randStr;
}

$errors=array('sqlerror'=>'');
$errors=array('sqlerror2'=>'');
$errors=array('sqlerror3'=>'');

$success=array('success'=>'');
$result = $connection->query("SELECT hospital_name FROM hospital ORDER BY hospital_name ASC");
$result1 = $connection->query("SELECT DISTINCT department_name FROM department ORDER BY department_name ASC");

$email=$_SESSION['email'];
$sql3 = " SELECT hospital_name from user WHERE email='" . $email . "'; ";

$r3 = mysqli_query($connection, $sql3);
$usertypes = mysqli_fetch_array($r3);
$hosname=$usertypes['hospital_name'];
$sql4 = " SELECT hospital_id from hospital WHERE hospital_name='" . $hosname . "'";
$r4 = mysqli_query($connection, $sql4);
$hospital = mysqli_fetch_array($r4);
$hid=$hospital['hospital_id'];

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require ('../mysqli_connect.php'); // Connect to the db.
	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a user id:
	if (empty($_POST['user_id'])) {
		$errors[] = 'You forgot to enter your user id.';
	} else {
		$uid = mysqli_real_escape_string($dbc, trim($_POST['user_id']));

	}
	
	// Check for a first name:
	if (empty($_POST['name'])) {
		$errors[] = 'You forgot to enter your first name.';
		
	} else {
		$fn = strtoupper($_POST['name']);
	}
	
	
	// Check for a last name:
	
	
	if (empty($_POST['bdate'])) {
		$errors[] = 'You forgot to enter your birth date.';
	} else {
		$bd = $_POST['bdate'];
		
	}
	if (empty($_POST['bplace'])) {
		$errors[] = 'You forgot to enter your birth place.';
	} else {
		$bp = $_POST['bplace'];
		$bp=encryptthis($bp,$key);
	}
	if (!$_POST['gender'] ){
    $errors[]="No Gender";

    }else{
	$g=$_POST['gender'];
		$g=encryptthis($g,$key);
    }
	if (!$_POST['status']){
    $errors[]="No Status";

    }else{
	$s=$_POST['status'];
		$s=encryptthis($s,$key);
    }
	
    if (!$_POST['role'] ){
    $errors[]="No Role";

    }else{
	$rl=$_POST['role'];

}

	
	if (empty($_POST['hnum'])) {
		$errors[] = 'You forgot to enter your house number.';
	} else {
		$hn = $_POST['hnum'];
	
	}
	if (empty($_POST['street'])) {
		$errors[] = 'You forgot to enter your street.';
	} else {
		$st = $_POST['street'];
		$st=encryptthis($st,$key);
	}
	if (empty($_POST['brgy'])) {
		$errors[] = 'You forgot to enter your barangay.';
	} else {
		$bgy = $_POST['brgy'];
		$bgy=encryptthis($bgy,$key);
	}
	if (empty($_POST['mun'])) {
		$errors[] = 'You forgot to enter your municipality.';
	} else {
		$mun = $_POST['mun'];
		$mun=encryptthis($mun,$key);
	}
	if (empty($_POST['prov'])) {
		$errors[] = 'You forgot to enter your province.';
	} else {
		$pv = $_POST['prov'];
		$pv=encryptthis($pv,$key);
	}
	if (empty($_POST['phone'])) {
		$errors[] = 'You forgot to enter your phone number.';
	} else {
		$pn = $_POST['phone'];
		$pn=encryptthis($pn,$key);
	}
	
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email.';
	} else {
		$ead = mysqli_real_escape_string($connection, trim($_POST['email']));
	}
	$query2 = "SELECT email FROM user where email='$ead'";
	$qrun = mysqli_query($connection,$query2);
	if(mysqli_num_rows($qrun)==1){
	$errors['sqlerror2']="Email Already Exist";
	$errors[]="Email Already Exist";

}else{
		$ea=$ead;
	}


	// Check for a password and match against the confirmed password:
	if (!empty($_POST['password'])) {
		if ($_POST['password'] != $_POST['pass']) {
			$errors['sqlerror'] = 'Your password did not match the confirmed password.';
			$errors[] = 'Your password did not match the confirmed password.';

        } else {
			$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
			$pw=password_hash($password, PASSWORD_DEFAULT);
		
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}

	$image = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../superadmin/image/profile/" . $image;
    
	
	if (empty($_POST['doctor_id'])) {
		$errors[] = 'You forgot to enter your doctor id.';
	} else {
		$docid = mysqli_real_escape_string($connection, trim($_POST['doctor_id']));
	}
   
	
	

	if (empty($_POST['hospital_name'])) {
		$errors[] = 'You forgot to enter your hospital.';
	} else {
		$hosidd = mysqli_real_escape_string($connection, trim($_POST['hospital_name']));
	}
	$query3 = "SELECT hospital_name FROM doctor WHERE user_id='$user' and hospital_name='$hosidd'";
		$qrun1 = mysqli_query($connection,$query3);
	if(mysqli_num_rows($qrun1)==1){
	$errors[]="You are already registered on this hospital ";
	}else{
		$hosid=$hosidd;
	}
	if (empty($errors)) {
	 // If everything's OK.
	
 

	
		// Register the user in the database...
		
		
$sql = "INSERT INTO user (user_id,name,
	bdate,bplace,gender,cstatus,
	hnum,street,brgy,mun,prov,
	phone,email,password,role,photo) VALUES ('$uid','$fn','$bd','$bp','$g','$s','$hn','$st','$bgy','$mun','$pv','$pn','$ea','$pw','$rl','$image')";
		 @mysqli_query ($dbc, $sql); // Run the query.
		// Now let's move the uploaded image into the folder: image
		
		if (move_uploaded_file($tempname, $folder)) {
			// If it ran OK.
		    $sql10 = "INSERT INTO laboratory (user_id,hospital_name,laboratory_id) VALUES ('$uid','$hosid','$docid')";  
           $r=@mysqli_query($dbc, $sql10);
           if($r){
			// Print a message:
            $success['success']="Doctor Created Successfully";
            
            echo "<script>window.location.href='success_laboratory.php';</script>";
                
           }
		
		
		}
	  else { // If it did not run OK.
			
			// Public message:
            $errors['sqlerror']="Failed to Create Doctor";

			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

	
		
	} else { // Report the errors.
	
		
		 
	
		
	} // End of if (empty($errors)) IF.
	

} // End of the main Submit conditional.
?>


<div class="form-style-10">
<h1>Registration<span></span></h1>
<form action="create_laboratory.php" method="POST" enctype="multipart/form-data">
<?php  
				if(!empty($success['success'])){
                    ?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $success['success'];?></div>
                <?php
                }
                ?>  <?php  
				if(!empty($errors['sqlerror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror'];?></div>
                <?php
                }
                ?>
                 <?php  
				if(!empty($errors['sqlerror2'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror2'];?></div>
                <?php
                }
                ?>
                 <?php  
				if(!empty($errors['sqlerror3'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror3'];?></div>
                <?php
                }
                ?>
    <div class="section"><span>1</span>Personal Info</div>
    <div class="inner-wrap">

	<h6> Full Name:</h6>    
    
            <input type="text" name="name"size="15" maxlength="40" pattern="[a-zA-Z\s]+" placeholder="First Name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" required/>
			
		<label ></label>
           

	<h6>Birth Information:</h6>
	<h6>Birth Date: </h6>
		<input type="date" name="bdate" size="15" maxlength="40" max="<?=date('Y-m-d')?>" value="<?php if (isset($_POST['bdate'])) echo $_POST['bdate']; ?>" required/>
			
    	<label ></label>
		<h6>Birth Place: </h6>

	 <input type="text" name="bplace" size="15" maxlength="40" pattern="[a-zA-Z\s]+" placeholder="Birth Place" value="<?php if (isset($_POST['bplace'])) echo $_POST['bplace']; ?>" required/>
	 	
	 <label ></label>
	<h6>Gender:</h6>
<select name="gender" id="gender" required>
	<option value="">Select Gender</option>
	<option value="Male">Male</option>
	<option value="Female">Female</option>
	
</select>

     	<label></label>
	<h6>Civil Status:</h6>
	<select name="status" id="status" required>
	<option value="">Select Civil Status</option>
	<option value="Single">Single</option>
	<option value="Married">Married</option>
	<option value="Divorce">Divorce</option>
	<option value="Widowed">Widowed</option>
	</select>
	
	<label></label>

	<label ></label>
</div>

<div class="section"><span>2</span>Address Information</div>
    <div class="inner-wrap">
	<input type="number" name="hnum" size="15" min="1" max="999" placeholder="House Number" value="<?php if (isset($_POST['hnum'])) echo $_POST['hnum']; ?>" required/>
	
	<label></label>
	<input type="text" name="street" size="15" maxlength="40" placeholder="Street" value="<?php if (isset($_POST['street'])) echo $_POST['street']; ?>" required/>
	
	<label></label>
	<input type="text" name="brgy" size="15" maxlength="40" placeholder="Barangay" value="<?php if (isset($_POST['brgy'])) echo $_POST['brgy']; ?>" required/>
	
	<label></label>
	<input type="text" name="mun" size="15" maxlength="40" placeholder="Municipality" pattern="[a-zA-Z\s]+" value="<?php if (isset($_POST['mun'])) echo $_POST['mun']; ?>" required/>
	
	<label></label>
	<input type="text" name="prov" size="15" maxlength="40" placeholder="Province" pattern="[a-zA-Z\s]+" value="<?php if (isset($_POST['prov'])) echo $_POST['prov']; ?>" required/>
	
	<label></label>    
</div>
	
    <div class="section"><span>3</span>Account Information</div>
        <div class="inner-wrap">
		<h6>User ID</h6>
	 <input type="text" name="user_id" size="15" maxlength="20" placeholder="User ID" value="<?php  echo generateKey(); ?>"readonly="readonly" required/>
	 <label></label>
	 
	 <h6>Phone Number</h6>
        <input type="tel" name="phone" size="15" pattern="(^(09|\+63)(\d){9}$)" placeholder="09123456789" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" required/>
		<label></label>
		<h6>Email Address</h6>

		<input type="email" name="email" size="15" maxlength="40" placeholder="Email Address" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required/>
		<label></label>
		<h6>Password</h6>
		<input type="password" name="password" size="15" maxlength="40" minlength="8" placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" required/>
		<label></label>
		<h6>Confirm Password</h6>
		<input type="password" name="pass" size="15" maxlength="40" minlength="8" placeholder="Confirm Password" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" required/>
		<label></label>
		<h6>Role </h6> 
		<select name="role" id="role" required>
	
        <option value="Laboratory">Laboratory</option>
	
	

</select>


<label></label>
<h6>Hospital Name: <input type="text" name="hospital_name" size="15" maxlength="50" value="<?php echo $hosname; ?>"readonly="readonly" /></h6>

	<h6>Doctor ID: <input type="text" name="doctor_id" size="15" maxlength="20" value="<?php  echo generateDKey(); ?>"readonly="readonly" /></h6>
           
	
	<label></label>
   

          
	
	<label></label>

<label></label>

<h6>Profile Picture</h6>
<input class="form-control" type="file" accept="image/*" name="uploadfile" value="" required/>
    </div>
    <div class="button-section">
     <input type="submit" onclick="checker()" name="upload" />
     
    </div>
</form>
</div>
<script>
    function checker(){
        var result= confirm('Are you sure you want to create Doctor?');
        if (result==false){
            event.preventDefault();
        }
    }
</script>
<script src="jquery.min.js"></script>
<script src="jquery-editable-select.js"></script>
<script>
	$('#hospital_name').editableSelect();
	</script>
	<script>
	$('#department_name').editableSelect();
	</script>





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
.error{
color:white;
background-color:red;
padding:15px;
display:block;
transform:translateY(-20px);
margin-bottom:20px;
font-size:14px;

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


<?php
include ('includes/footer.php');
include('includes/scripts.php');
?>