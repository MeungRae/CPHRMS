<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.
//include('security.php');
$page_title = 'Register';
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
include('dbconfig.php');

$usr=$_SESSION['user_id'];
$sql3 = " SELECT * from admin inner join  hospital on admin.hospital_id=hospital.hospital_id WHERE admin.user_id='$usr'";
$r3 = mysqli_query($connection, $sql3);
$usertypes = mysqli_fetch_array($r3);
$hid=$usertypes['hospital_id'];




function generateKey(){
	$keyLength=20;
	$uniq=uniqid("DEPARTMENT_");
	$randStr=substr($uniq,0,$keyLength);
	return $randStr;
}
$errors=array('sqlerror'=>'');
$success=array('success'=>'');


// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//require ('../mysqli_connect.php'); // Connect to the db.
	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a user id:
	
	
    	
	if (empty($_POST['department_id'])) {
		$errors[] = 'You forgot to enter your department id.';
	} else {
		$did = mysqli_real_escape_string($dbc, trim($_POST['department_id']));
	}
    	
	if (!$_POST['department_name'] ){
		$errors[]="No department name";
	
		}else{
		$depd=mysqli_real_escape_string($connection, trim($_POST['department_name']));
		}
		$query1 = "SELECT department_name FROM department WHERE department_name='$depd' AND hospital_id='$hid'";
		$qrun = mysqli_query($dbc,$query1);
	
		if(mysqli_num_rows($qrun)==1){
		$errors[]="Department Already Exist ";
		$errors['sqlerror']="Department Already Exist ";

    }else{
		$dep=strtoupper($depd);
	}

	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO department (hospital_id, department_id, department_name) VALUES ('$hid', '$did','$dep')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
            $success['success']="Department Created Successfully";
	
		
		} else { // If it did not run OK.
			
			// Public message:
            $errors['sqlerror']="Failed to Create Department";
 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
      
		
	} else { // Report the errors.
	
		
		
	} // End of if (empty($errors)) IF.
	

} // End of the main Submit conditional.
?>
	

<div class="form-style-10">
<h1>Create Department<span></span></h1>
<form action="create_department.php" method="POST" enctype="multipart/form-data">
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
    <div class="section">Department Info</div>
    <div class="inner-wrap">

	<label></label>
	<input type="hidden" name="hospital_id" size="15" maxlength="40" placeholder="Hospital ID" value="<?php echo $hid; ?>"readonly="readonly" required/>
	
	<label></label>
	<h6>Department ID:</h6>

	<input class="form-control" type="text" name="department_id" size="15" maxlength="40" placeholder="Department ID" value="<?php  echo generateKey(); ?>"readonly="readonly" required/>
	
	<label></label>
	<h6>Department Name:</h6>
	<select class="form-control" name="department_name" id="department_name" required>
       <?php
	   $result1 = $connection->query("SELECT DISTINCT department_name FROM department where hospital_id='$hid' ORDER BY department_name ASC");

       foreach($result1 as $row)
       {
        echo '<option value="'.$row["department_name"].'">'.$row["department_name"].'</option>';
       }
       ?>
       </select>
     	
    <div class="button-section">
     <input type="submit" onclick="checker()" name="upload" />
     
    </div>
</form>
</div>
<script>
    function checker(){
        var result= confirm('Are you sure you want to create department?');
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
//include('includes/scripts.php');
?>