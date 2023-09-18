<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.
//include('security.php');
$page_title = 'Register';
include('dbconfig.php');
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
include('../encryption/encryption.php');
$_SESSION['url']='http://localhost/cphrms/admin/create_laboratory.php';


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
$errors=array('sqlerror1'=>'');

$errors=array('sqlerror2'=>'');
$errors=array('sqlerror3'=>'');
$success=array('success'=>'');

$usr=$_SESSION['user_id'];
$sql3 = " SELECT * from admin inner join  hospital on admin.hospital_id=hospital.hospital_id WHERE admin.user_id='$usr'";
$r3 = mysqli_query($connection, $sql3);
$usertypes = mysqli_fetch_array($r3);
$hid=$usertypes['hospital_id'];
$hosname=$usertypes['hospital_name'];

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

	if(isset($_FILES['uploadfile']['name'])){
        $file = $_FILES['uploadfile'];
        $file_type = $file['type'];
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
    
        if (!in_array($file_type, $allowed_types)) {
            $errors['sqlerror1']="Error: Only JPEG, PNG, and GIF files are allowed.";
            $errors[]="Error: Only JPEG, PNG, and GIF files are allowed.";
            
        } else {
            $image = $_FILES["uploadfile"]["name"];
            $imagefile_name=uniqid() . '-' . $image;
    
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $folder = "../superadmin/image/profile/" . $imagefile_name;
            move_uploaded_file($tempname,$folder);
        }
    }
	
	if (empty($_POST['laboratory_id'])) {
		$errors[] = 'You forgot to enter your laboratory id.';
	} else {
		$docid = mysqli_real_escape_string($connection, trim($_POST['laboratory_id']));
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
	$sql4="SELECT * from hospital where hospital_name='$hosid'";
	$qrun4 = mysqli_query($connection,$sql4);
	$usertypes2 = mysqli_fetch_array($qrun4);
	$hosp_id=$usertypes2['hospital_id'];

	if (empty($errors)) {
	 // If everything's OK.
	
 

	
		// Register the user in the database...
		
		
$sql = "INSERT INTO user (user_id,name,email,password,role) VALUES ('$uid','$fn','$ea','$pw','$rl')";
		 $r=mysqli_query ($dbc, $sql); 
		 
		 
		 
		 // Run the query.
		// Now let's move the uploaded image into the folder: image
		
		if ($r) {
			// If it ran OK.
		    $sql1 = "INSERT INTO laboratory(user_id,bdate,gender,cstatus,hnum,street,brgy,mun,prov,phone,photo,laboratory_id,hospital_id,active) VALUES ('$uid','$bd','$g','$s','$hn','$st','$bgy','$mun','$pv','$pn','$imagefile_name','$docid','$hosp_id','ACTIVE')";
		 $run=mysqli_query ($dbc, $sql1); 
		 if($run){  
			// Print a message:
            $success['success']="Laboratory Created Successfully   ";
            
		 }
           
		
		
		}
	  else { // If it did not run OK.
			
			// Public message:
            $errors['sqlerror']="Failed to Create Laboratory";

			
			// Debugging message:
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

	
		
	} else { // Report the errors.
	
		
		 
	
		
	} // End of if (empty($errors)) IF.
	

} // End of the main Submit conditional.
?>

<div style="width: 1500px; " class="form-style-10">
<h1>Create Laboratory<span></span></h1>
<?php  
				if(!empty($errors['sqlerror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror'];?></div>
                <?php
                }
                ?>
				<?php  
				if(!empty($errors['sqlerror1'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror1'];?></div>
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
                <?php  
				if(!empty($success['success'])){
                    ?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $success['success'];?><a style="color:white;"href="create_laboratory.php">Create another Laboratory</a></div>
                </div>
				<?php
                }else{
                ?>  
<form action="create_laboratory.php" method="POST" enctype="multipart/form-data">
    <div class="section">Personal Info</div>
	<div class="mb-3">
	
	<p> Full Name:</p>    
            <input class="form-control" type="text" name="name"size="15" maxlength="40" pattern="[a-zA-Z\s]+" placeholder="First Name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" required/>
				</div>
				<label></label>
				<div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">			
	<p>Birth Date: </p>
		<input class="form-control" type="date" name="bdate" size="15" maxlength="40" max="<?=date('Y-m-d')?>" value="<?php if (isset($_POST['bdate'])) echo $_POST['bdate']; ?>" required/>
    	</div>
		<div style="flex: 1; margin-left: 10px;">

	<p>Gender:</p>
<select class="form-control" name="gender" id="gender" required>
	<option value="">Select Gender</option>
	<option value="Male">Male</option>
	<option value="Female">Female</option>
</select>
     	</div>
		 <div style="flex: 1; margin-left: 10px;">

	<p>Civil Status:</p>
	<select class="form-control" name="status" id="status" required>
	<option value="">Select Civil Status</option>
	<option value="Single">Single</option>
	<option value="Married">Married</option>
	<option value="Divorce">Divorce</option>
	<option value="Widowed">Widowed</option>
	</select>
	</div>

	
</div>
<label ></label>
<label ></label>

<div class="section">Address Information</div>
<div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">
	<p>House No:</p>	
	<input class="form-control" type="number" name="hnum" size="15" min="1" max="9999" placeholder="House Number" value="<?php if (isset($_POST['hnum'])) echo $_POST['hnum']; ?>" required/>
				</div>
				<div style="flex: 1; margin-left: 10px;">

	<p>Street:</p>
	<input class="form-control" type="text" name="street" size="15" maxlength="40" placeholder="Street" value="<?php if (isset($_POST['street'])) echo $_POST['street']; ?>" required/>
	
	</div>
	<div style="flex: 1; margin-left: 10px;">

	<p>Barangay:</p>
	<input class="form-control" type="text" name="brgy" size="15" maxlength="40" placeholder="Barangay" value="<?php if (isset($_POST['brgy'])) echo $_POST['brgy']; ?>" required/>
	
	</div>
	<div style="flex: 1; margin-left: 10px;">

	<p>Municipality:</p>
	<input class="form-control" type="text" name="mun" size="15" maxlength="40" placeholder="Municipality" pattern="[a-zA-Z\s]+" value="<?php if (isset($_POST['mun'])) echo $_POST['mun']; ?>" required/>
	
	</div>
	<div style="flex: 1; margin-left: 10px;">

	<p>Province:</p>
	<input class="form-control" type="text" name="prov" size="15" maxlength="40" placeholder="Province" pattern="[a-zA-Z\s]+" value="<?php if (isset($_POST['prov'])) echo $_POST['prov']; ?>" required/>
	</div>    
</div>
				</div>
<label></label>
<label></label>
    <div class="section">Account Information</div>
	<div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">
		<p>User ID</p>
	 <input class="form-control" type="text" name="user_id" size="15" maxlength="20" placeholder="User ID" value="<?php  echo generateKey(); ?>"readonly="readonly" required/>
	 </div>
	 <div style="flex: 1; margin-left: 10px;">

	 <p>Hospital Name:</p> <input class="form-control" type="text" name="hospital_name" size="15" maxlength="50" value="<?php echo $hosname; ?>"readonly="readonly" />
				</div>
				<div style="flex: 1; margin-left: 10px;">
			
	 <p>Laboratory ID: </p><input class="form-control" type="text" name="laboratory_id" size="15" maxlength="20" value="<?php  echo generateDKey(); ?>"readonly="readonly" />
				</div>
				</div>
				<label></label><div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">
	 <p>Phone Number</p>
        <input class="form-control" type="tel" name="phone" size="15" pattern="(^(09|\+63)(\d){9}$)" placeholder="09123456789" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" required/>
		</div>
		<div style="flex: 1; margin-left: 10px;">

		<p>Email Address</p>
		<input class="form-control" type="email" name="email" size="15" maxlength="40" placeholder="Email Address" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required/>
		</div>
	</div>
	<label></label>

		<div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">
		<p>Password</p>
		<input class="form-control" type="password" name="password" size="15" maxlength="40" minlength="8" placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" required/>
		</div>
		<div style="flex: 1; margin-left: 10px;">

		<p>Confirm Password</p>
		<input class="form-control" type="password" name="pass" size="15" maxlength="40" minlength="8" placeholder="Confirm Password" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" required/>
		</div>
		<div style="flex: 1; margin-left: 10px;">

		<p>Role </p> 
		<select class="form-control" name="role" id="role" required>
	<option value="Laboratory">Laboratory</option>
</select>
</div>
	</div>

           
	
	<label></label>
	<label></label>
	<div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">
<p>Profile Picture</p>
<input class="form-control" type="file" accept="image/*" name="uploadfile" value="" required/>
    </div>
				</div>
				<label></label>
    <div class="button-section">
     <input type="submit" onclick="checker()" name="upload" />
     
    </div>
</form>
</div>
<?php
				}
?>
<script>
    function checker(){
        var result= confirm('Are you sure you want to create Laboratory?');
        if (result==false){
            event.preventDefault();
        }
    }
</script>
<script src="jquery.min.js"></script>
<script src="jquery-editable-select.js"></script>

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