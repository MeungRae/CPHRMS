<?php
include('dbconfig.php');
include('security.php');

include('includes/header.php');
include('includes/navbar.php');
include('../encryption/encryption.php');

$success=array('success'=>'');
$errors=array('sqlerror'=>'');
$errors = array();

$student_id = mysqli_real_escape_string($connection, $_GET['id']);
$number = count($_POST["name"]);  
for($i=0; $i<$number; $i++)  
{  
    if(trim($_POST["name"][$i] != ''))  
    {  
        $recid=$_POST['user_id'];
        if (empty($_POST['sdate'])) {
          $errors[] = 'You forgot to enter your start date.';
          $errors['sqlerror'] = 'You forgot to enter your start date.';

     } else {
       $sd = $_POST['sdate'];
     }
        $allergy=strtoupper(mysqli_real_escape_string($connection, $_POST["name"][$i]));

        $sql2="SELECT * from allergy where user_id='$recid' and allergy='$allergy'";
        $result=mysqli_query($connection, $sql2);
        if(mysqli_num_rows($result) == 0) 
        {
            if(empty($errors))
            {
               $sql = "INSERT INTO allergy(allergy,user_id,date_started,date_created) VALUES('$allergy','$recid','$sd',NOW())";  
               mysqli_query($connection, $sql);
            }
        }
    }  
} 

     $number = count($_POST["name"]);  
  
     for($i=0; $i<$number; $i++)  
     {  
$sql3="SELECT * from allergy where user_id='$recid'";
$r2=mysqli_query($connection, $sql3);
if(mysqli_num_rows($r2)==0){
          if(trim($_POST["name"][$i] != ''))  
          {  
           $recid=$_POST['user_id'];
           if (empty($_POST['sdate'])) {
              $errors[] = 'You forgot to enter your start date.';
              $errors['sqlerror'] = 'You forgot to enter your start date.';

         } else {
           $sd = $_POST['sdate'];
         }

          
         $allergy=strtoupper(mysqli_real_escape_string($connection, $_POST["name"][$i]));
         $allg=$all['allergy'];
          
    
    
         if(empty($errors)){
         $sql4 = "INSERT INTO allergy(allergy,user_id,date_started,date_created) VALUES('$allergy','$recid','$sd',NOW())";  
         mysqli_query($connection, $sql4);
         } 
    
          }  
         }  
}


  
 ?> 

<html>  
      <head>  
           <title>Dynamically Add or Remove input fields in PHP with JQuery</title>  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <body>  
           <div class="container">  
                <br />  
                <br />  
                
     
                <div class="form-group"> 
                <div class="form-style-10">
<h1>Patient Allergies</h1>
                     <form action="patient_allergies.php" method="POST" name="add_name" id="add_name">
					<?php
					 if(!empty($success['success'])){
                    ?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $success['success'];?></div>
                <?php
                }
                ?>   
                <?php  
				if(!empty($errors['sqlerror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror'];?></div>
                <?php
                }
                ?>
                          <div class="table-responsive">
                          
                          <input type="hidden" name="user_id" placeholder="USER ID" value="<?php echo $student_id;?>" required /> 

                          <label></label>
                          <h6>Date: </h6>
		<input type="date" name="sdate" size="15" maxlength="40" max="<?=date('Y-m-d')?>"min="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>" required/>
			
    	<label ></label>
                          <table style="background-color: #858789; border:1px black solid; border-spacing: 10px 10px; padding: 10px"class="table table-striped table-bordered">
                          <thead style="  border-bottom: 1px solid #ddd;">
                                <tr>
                                <th> Previous Allergies</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $query="SELECT *  FROM allergy  WHERE user_id='$student_id' and allergy is not null";
                            $query_run = mysqli_query($connection, $query);
                            if(mysqli_num_rows($query_run) > 0){
                                            foreach($query_run as $items){
                                                ?>
                                                <tr>
                                                    <td><?= $items['allergy'];?></td>

                                                  </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                                <tr>
                                                    <td colspan="4">No Record Found</td>
                                                </tr>
                                            <?php
                                        }
                                ?>
            </tbody>
                          <table>
						  <h6>Allergies</h6>
  
                               <table class="table table-bordered" id="dynamic_field">  
                                    <tr>  
                                         <td><input type="text" name="name[]" placeholder="Enter Allergies" class="form-control name_list" required/></td>  
                                         <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                    </tr>  
                               </table>  
                               <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />  
                               <a style="text-decoration:none"href="success_patient.php?id=<?php echo $student_id  ?>">
   <input type="button" name="back"  class="btn btn-info" value="BACK" />  
   </a>
                          </div>  
                     </form>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter Allergies" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"patient_allergies.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert("Patient Allergies Updated");  
                     $('#add_name')[0].reset();
					 url:"success_patient.php";  
                }  
           });  
      });  
 });  
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