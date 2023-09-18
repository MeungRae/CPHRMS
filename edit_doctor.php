<?php
include('dbconfig.php');
include('security.php');

$student_id = mysqli_real_escape_string($connection, $_GET['id']);
$student_id2 = mysqli_real_escape_string($connection, $_GET['id2']);
$url='http://localhost/cphrms/admin/edit_doctor.php?id=&id2=';
$parsed_url = parse_url($url);
parse_str($parsed_url['query'], $query_params);


$query_params['id'] = $student_id;
$query_params['id2'] = $student_id2;


$new_query = http_build_query($query_params);
$new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $new_query;

// Store the modified URL in the $_SESSION variable, or use it for redirect, etc.
$_SESSION['url'] = $new_url;
$sql="SELECT * from doctor where user_id='$student_id'";
$r = mysqli_query($connection, $sql);
$student = mysqli_fetch_array($r);
$actives=$student['active'];
$errors=array('sqlerror'=>'');
$success=array('success'=>'');
if(isset($_POST['upload']))
{
    $active=mysqli_real_escape_string($connection, $_POST['active']);
    $uid=mysqli_real_escape_string($connection, $_POST['user_id']);
    $rcid=mysqli_real_escape_string($connection, $_POST['record_id']);
    $did=mysqli_real_escape_string($connection, $_POST['dep_id']);
        
$sql2="UPDATE doctor set active='$active' where user_id='$uid'";
$r2 = mysqli_query($connection, $sql2);

if($r2){

	header("Location:search_doctor_department.php?id=".$did);
}else{
    $errors['sqlerror']="UPDATED Unsuccessfully";
}
}
include ('includes/header.php');
include ('includes/navbar.php');


?>
                


<div class="form-style-10">
<h1>Edit Doctor Active Status<span></span></h1>
<form action="edit_doctor.php"  method="POST" enctype="multipart/form-data">
<?php  
				if(!empty($errors['sqlerror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror'];?></div>
                <?php 
                }
                ?>

                                 <?php  
				if(!empty($success['success'])){
                    ?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $success['success'];?></div>
                
                </div>
                </form>
                </div>
                <?php
                }else{
                ?> 
    <div class="section"></div>
    <div class="inner-wrap">
    <input type="hidden" name="user_id" value="<?=$student_id;?>"readonly="readonly" class="form-control">
    <input type="hidden" name="dep_id" value="<?=$student_id2;?>"readonly="readonly" class="form-control">
   
    <h6>Active Status:</h6>
<select name="active" id="active" required>
	
	<option value="ACTIVE"<?php
                               if($actives=='ACTIVE'){
                                echo "selected";
                               }
                               ?>>ACTIVE</option>
	<option value="INACTIVE"
    <?php
                               if($actives=='INACTIVE'){
                                echo "selected";
                               }
                               ?>>INACTIVE</option>
	
</select>

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
        var result= confirm('Are you sure you want to update this doctor active status?');
        if (result==false){
            event.preventDefault();
        }
    }
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