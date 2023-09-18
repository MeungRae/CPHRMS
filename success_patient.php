<?php
include('dbconfig.php');
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');

$student_id = mysqli_real_escape_string($connection, $_GET['id']);
$uid=$student_id;
$url='http://localhost/cphrms/admin/success_patient.php?id=';
$parsed_url = parse_url($url);
parse_str($parsed_url['query'], $query_params);


$query_params['id'] = $student_id;


$new_query = http_build_query($query_params);
$new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $new_query;

// Store the modified URL in the $_SESSION variable, or use it for redirect, etc.
$_SESSION['url'] = $new_url;

?>
                


<div class="form-style-10">
<h1>Patient Created Successfully<span></span></h1>
<form action="success_patient.php"  method="POST" enctype="multipart/form-data">

    <div class="section"><span>1</span>Choose Option</div>
    <div class="inner-wrap">
        
    <!--    
   <button type="button"><a style="text-decoration:none; margin:10px display:inline-block"  title="Create Patient" href="create_patient.php">CREATE NEW PATIENT</a></button>
   <button type="button"><a style="text-decoration:none; align:center; margin-left:20px; margin-right:10px; display:inline-block" title="Update Allergies" href="patient_allergies.php?id=<?php echo $uid  ?>">UPDATE ALLERGIES</a></buttton>
   <button type="button"><a style="text-decoration:none;  align:right; margin-right:10px; display:inline-block" title="Update History" href="patient_history.php?id=<?php echo $uid  ?>">UPDATE MEDICAL HISTORY</a></button>
-->
<a style="text-decoration:none"href="create_patient.php">

   <input type="button" name="patient"  class="btn btn-info" value="Create Patient" />  
   </a>

   <a style="text-decoration:none"href="patient_allergies.php?id=<?php echo $uid  ?>">
   <input type="button" name="allergy"  class="btn btn-info" value="Update Allergies" />  
</a>
<a style="text-decoration:none"href="patient_history.php?id=<?php echo $uid  ?>">
   <input type="button" name="history"  class="btn btn-info" value="Update History" />  
   </a>



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