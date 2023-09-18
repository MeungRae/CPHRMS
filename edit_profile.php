<?php
include('dbconfig.php');
include('security.php');

include('includes/header.php'); 
include('includes/navbar.php');
include('../encryption/encryption.php');

$errors=array('sqlerror'=>'');
$errors=array('sqlerror1'=>'');
$success=array('success'=>'');
$profile_id = mysqli_real_escape_string($connection, $_GET['id']);

$url='http://localhost/cphrms/admin/edit_profile.php?id=';
$parsed_url = parse_url($url);
parse_str($parsed_url['query'], $query_params);


$query_params['id'] = $profile_id;


$new_query = http_build_query($query_params);
$new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $new_query;

// Store the modified URL in the $_SESSION variable, or use it for redirect, etc.
$_SESSION['url'] = $new_url;
?>
<?php
if(isset($_POST['update_profile']))
{
    $usr=$_SESSION['user_id'];                              
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $query="SELECT * FROM admin WHERE user_id='$usr'";
    $query_run1 = mysqli_query($connection, $query);
    $user = mysqli_fetch_array($query_run1);
    $photos=$user['photo'];
 








    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $hnum = mysqli_real_escape_string($connection, $_POST['hnum']);
    $brgy = mysqli_real_escape_string($connection, $_POST['brgy']);
    $street = mysqli_real_escape_string($connection, $_POST['street']);
    $mun = mysqli_real_escape_string($connection, $_POST['mun']);
    $prov = mysqli_real_escape_string($connection, $_POST['prov']);
    
    $phone=encryptthis($phone,$key);
    $brgy=encryptthis($brgy,$key);
    $street=encryptthis($street,$key);
    $mun=encryptthis($mun,$key);
    $prov=encryptthis($prov,$key);
    

    if(isset($_FILES['uploadfile']['name'])&&($_FILES['uploadfile']['name']!="")){
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
    }else{
        $imagefile_name=$photos;
    }
    if (empty($errors['sqlerror1'])) {


        $sql = "UPDATE admin SET phone='$phone', hnum='$hnum', street='$street', brgy='$brgy', mun='$mun', prov='$prov', photo='$imagefile_name'  WHERE user_id = '$user_id'";
        $query_run = mysqli_query($connection, $sql);
        if($query_run){
            $success['success']='Success';
        }else{
            $errors['sqlerror']='Fail';
        }
    }
    
}
        
    
   

   


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Hospital Edit</title>
</head>
<body>
  
    <div class="container mt-5">

       

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h4>Edit Profile</h4>
                    <a style="background-color:green;"href="view_profile.php" class="btn btn-danger float-end">BACK</a>

            </div>
            <div class="card-body">
            <?php
                        if(isset($_GET['id']))
                        {
                            $query = "SELECT * FROM user WHERE user_id='$profile_id' ";
                            $query_run = mysqli_query($connection, $query);
                            $query1 = "SELECT * FROM admin inner join hospital on admin.hospital_id=hospital.hospital_id  WHERE admin.user_id='$profile_id' ";
                            $query_run2 = mysqli_query($connection, $query1);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $usertypes = mysqli_fetch_array($query_run);
                                $usertypes1 = mysqli_fetch_array($query_run2);

                                $usr=$_SESSION['user_id'];                              
$name=$usertypes['name'];
$email=$usertypes['email'];
$hnum=$usertypes1['hnum'];
$street=$usertypes1['street'];
$brgy=$usertypes1['brgy'];
$mun=$usertypes1['mun'];
$prov=$usertypes1['prov'];
$phone=$usertypes1['phone'];
$photo=$usertypes1['photo'];
$hosname=$usertypes1['hospital_name'];

$street=decryptthis($street,$key);
$brgy=decryptthis($brgy,$key);
$mun=decryptthis($mun,$key);
$prov=decryptthis($prov,$key);
$phone=decryptthis($phone,$key);


                            }
                        }
                                ?>
                                <?php  
				if(!empty($errors['sqlerror'])){
                    ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror'];?></div>
                <?php 
                }
                ?>

                                 <?php
                if(empty($errors['sqlerror1'])){                    
				if(!empty($success['success'])){
                    ?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $success['success'];?></div>
                </div>
        </div>
    </div>
</div>
</div>
                <?php
                }else{
                ?> 
                 
                        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
                       

                        <div class="mb-3">
                          <div style="display: flex; flex-direction: row;">
                          <div style="flex: 1;">
                          <label>Name</label>
                                <input type="text" name="name" value="<?=$name;?>"readonly="readonly" class="form-control">
                            
                            </div>
                            <div style="flex: 1; margin-left: 10px;">
                            <label>User ID:</label>
                                <input type="text" name="user_id" value="<?=$usr;?>"readonly="readonly" class="form-control">
                            </div>
                            <div style="flex: 1; margin-left: 10px;">
                            <label>Hospital Name</label>
                            <input type="text" name="hosname" size="100" maxlength="40" placeholder="Hospital Name" required value="<?=$hosname; ?>" readonly="readonly"class="form-control" />
                            </div>
                </div>
                <label></label>
                           
                <div class="mb-3">
                            <div style="display: flex; flex-direction: row;">
                          <div style="flex: 1;">    
                            <label>House Number</label>
                            <input type="number" name="hnum" size="100" min="1" max="999" placeholder="House Number" required value="<?=$hnum; ?>" class="form-control"/>
                            </div>
                    
                            <div style="flex: 1; margin-left: 10px;">
                            <label>Street</label>
                            <label></label>
                            <input type="text" name="street" size="100" maxlength="40" placeholder="Street" required value="<?=$street; ?>"class="form-control" />
                            </div>
                     
                            <div style="flex: 1; margin-left: 10px;">
                            <label>Barangay</label>
                            <input type="text" name="brgy" size="100" maxlength="40" placeholder="Barangay" required value="<?=$brgy; ?>"class="form-control" />
                            </div>
                    
                            <div style="flex: 1; margin-left: 10px;">
                            <label>Municipality</label>
                            <input type="text" name="mun" size="100" maxlength="40" placeholder="Municipality" required value="<?=$mun; ?>" class="form-control"/>
                            </div>
                      
                            <div style="flex: 1; margin-left: 10px;">
                            <label>Province</label>
                            <input type="text" name="prov" size="100" maxlength="40" placeholder="Province" required value="<?=$prov; ?>" class="form-control"/>
                            </div>
                </div>
                <label></label>
                         
                            <div class="mb-3">
                            <div style="display: flex; flex-direction: row;">
                          <div style="flex: 1;">  
                                <label>Phone Number</label>
                                <input type="tel" name="phone" size="15" maxlength="11" pattern="(^(09|\+63)(\d){9}$)" placeholder="09123456789" required value="<?=$phone;?>"class="form-control" />
                            </div>
                           
                            <div style="flex: 1; margin-left: 10px;">
                                <label>Email</label>
                                <input type="text" name="email" value="<?=$email;?>"readonly="readonly" class="form-control">
                            </div>
                </div>
                            
                           
                   
                <label></label>

                            
				
                <div class="mb-3">
                          <div style="display: flex; flex-direction: row;">
                          <div style="flex: 1; margin-left:5px;">
                          <label>Current Profile Picture:</label>
                          <label></label>
                          <img style="width: 200px; height: 200px" src="../superadmin/image/profile/<?php echo $photo; ?>">
                          </div>
                          <div style="flex: 1; margin-left: 10px; margin-right:625px;">

                                <label>Update Picture:</label>
                                <input class="form-control" type="file" accept="image/*" name="uploadfile" value="" />

                          </div>
                          </div>
                          <label></label>
                            <div class="mb-3">
                                <button type="submit" onclick="checker()" name="update_profile" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                        
            </div>
        </div>
    </div>
</div>
</div>
<?php
                }
            }else{
                ?>
                <div style="text-align:center;background-color:red;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text"><?php echo $errors['sqlerror1'];?></div>
                </div>
            </div>
        </div>
    </div>
    </div>
          <?php
            }
                    ?>
                
<script>
    function checker(){
        var result= confirm('Are you sure you want to update your profile?');
        if (result==false){
            event.preventDefault();
        }
    }
</script>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>