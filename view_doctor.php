<?php
require 'dbconfig.php';
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
include('../encryption/encryption.php');

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>User View</title>
</head>
<body>

    <div class="container mt-5">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Information 
                            <a href="search_doctor.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($connection, $_GET['id']);
                           
                            $query10 = "SELECT * FROM user inner join doctor on user.user_id=doctor.user_id inner join department on doctor.department_id=department.department_id WHERE user.user_id='$student_id' ";
                            $query_run10 = mysqli_query($connection, $query10);
                            $student = mysqli_fetch_array($query_run10);
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $bdate=$student['bdate'];
                                $gender=$student['gender'];
                                $cstatus=$student['cstatus'];
                                $hnum=$student['hnum'];
                                $street=$student['street'];
                                $brgy=$student['brgy'];
                                $mun=$student['mun'];
                                $prov=$student['prov'];
                                $phone=$student['phone'];
                               $docid=$student['doctor_id'];
                               $docpos=$student['doctor_position'];
                               $docdep=$student['department_name'];
                               $hosname=$student['hospital_name'];



                                $gender=decryptthis($gender,$key);
                                $cstatus=decryptthis($cstatus,$key);                              
                                $street=decryptthis($street,$key);
                                $brgy=decryptthis($brgy,$key);
                                $mun=decryptthis($mun,$key);
                                $prov=decryptthis($prov,$key);
                                $phone=decryptthis($phone,$key);
                                
$today=  date("Y-m-d");
$diff = date_diff(date_create($bdate), date_create($today));
$age=(int) $diff->format('%y');
$address="{$hnum} {$street} {$brgy} {$mun} {$prov}";
                                ?>
                                      <img style="width: 100px; height: 100px" src="../superadmin/image/profile/<?=$student['photo']; ?>">                                        </p>
                                        
                                 <div class="mb-3">
                                        <label>User ID</label>
                                        <p class="form-control">
                                            <?=$student['user_id'];?>
                                        </p>
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <p class="form-control">
                                            <?=$student['name'];?>
                                        </p>
                                    </div>
                                   
                                    <div class="mb-3">
                                        <label>Birth Date</label>
                                        <p class="form-control">
                                            <?=$bdate;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Age</label>
                                        <p class="form-control">
                                            <?=$age;?>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label>Gender</label>
                                        <p class="form-control">
                                            <?=$gender;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Civil Status</label>
                                        <p class="form-control">
                                            <?=$cstatus;?>
                                        </p>
                                    </div>
                                   
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <p class="form-control">
                                            <?=$address;?>
                                        </p>
                                    </div>
                                   
                                    <div class="mb-3">
                                        <label>Phone Number</label>
                                        <p class="form-control">
                                            <?=$phone;?>
                                        </p>
                                    </div>
                                   
                                    <div class="mb-3">
                                        <label>Email Address</label>
                                        <p class="form-control">
                                            <?=$student['email'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Doctor ID</label>
                                        <p class="form-control">
                                            <?=$docid;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Doctor Position</label>
                                        <p class="form-control">
                                            <?=$docpos;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Department</label>
                                        <p class="form-control">
                                            <?=$docdep;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                    <label><label>
                                    <a href="print_doctor.php?id=<?php echo $student['user_id'];; ?>" target="_blank">  
      <input type="submit" value="PRINT" style="background-color:green;"class="btn btn-info"/>  
     </a>
                            </div>  
                                   
                                    
                                   

                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include ('includes/footer.php');
include('includes/scripts.php');
?>