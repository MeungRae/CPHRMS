        $sql = "UPDATE user SET cstatus='$cstatus',phone='$phone', hnum='$hnum', street='$street', brgy='$brgy', mun='$mun', prov='$prov', gname='$gname', gphone='$gphone', gemail='$gemail', gaddress='$gaddress', photo='$image'  WHERE user_id = '" . $usr . "'";




         
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $hnum = mysqli_real_escape_string($connection, $_POST['hnum']);
    $brgy = mysqli_real_escape_string($connection, $_POST['brgy']);
    $street = mysqli_real_escape_string($connection, $_POST['street']);
    $mun = mysqli_real_escape_string($connection, $_POST['mun']);
    $prov = mysqli_real_escape_string($connection, $_POST['prov']);
    $gname = mysqli_real_escape_string($connection, $_POST['gname']);
    $gphone = mysqli_real_escape_string($connection, $_POST['gphone']);
    $gemail = mysqli_real_escape_string($connection, $_POST['gemail']);
    $gaddress = mysqli_real_escape_string($connection, $_POST['gaddress']);
    
    $cstatus=encryptthis($cstatus,$key);
    $phone=encryptthis($phone,$key);
    $brgy=encryptthis($brgy,$key);
    $street=encryptthis($street,$key);
    $mun=encryptthis($mun,$key);
    $prov=encryptthis($prov,$key);
    $gname=encryptthis($gname,$key);
    $gphone=encryptthis($gphone,$key);
    $gemail=encryptthis($gemail,$key);
    $gaddress=encryptthis($gaddress,$key);
































    <?php
include('dbconfig.php');
include('../encryption/encryption.php');
include ('includes/header.php');
include ('includes/navbar.php');

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Student View</title>
</head>
<body>

    <div class="container mt-5">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Record Information 
                            <a href="view_medred_patient.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($connection, $_GET['id']);
                            $query = "SELECT * FROM medical_record WHERE record_id='$student_id' ";
                            $query_run = mysqli_query($connection, $query);
                            
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);

                                $rd=$student['record_id'];
                                $_SESSION['rid']=$student['doctor_id'];
                                $bp=$student['blood_pressure'];
                                $symp=$student['symptoms'];
                                $dgs=$student['diagnosis'];
                                $pcn=$student['prescription'];
                                $com=$student['doctor_comment'];
                                $pass=$student['pass'];
                                $temp=$student['temperature'];
                                $hgt=$student['height'];
                                $wgt=$student['weight'];
                                $docid=$student['doctor_id'];
                                $bp=decryptthis($bp,$key);
                                $symp=decryptthis($symp,$key);
                                $dgs=decryptthis($dgs,$key);
                                $pcn=decryptthis($pcn,$key);
                                $com=decryptthis($com,$key);
                                $pass=decryptthis($pass,$key);
                                $temp=decryptthis($temp,$key);
                                $hgt=decryptthis($hgt,$key);
                                $wgt=decryptthis($wgt,$key);

                                $query5 = "SELECT user_id FROM doctor WHERE doctor_id='". $docid ."' ";
                                $query_run5 = mysqli_query($connection, $query5);
                                if(mysqli_num_rows($query_run5) > 0)
                            {
                                $doc = mysqli_fetch_array($query_run5);
                                $docuser=$doc['user_id'];
                                $query6 = "SELECT name FROM user WHERE user_id='". $docuser ."' ";
                                $query_run6 = mysqli_query($connection, $query6);
                                if(mysqli_num_rows($query_run6) > 0)
                            {
                                $docs=mysqli_fetch_array($query_run6);
                            }
                            }
                                ?>
                                <div class="mb-3">
                                        <label>User ID</label>
                                        <p class="form-control">
                                        <?=$student['user_id'];?>
  
                            </p>   
                                    </div>
                                 <div class="mb-3">
                                        <label>Record ID</label>
                                        <p class="form-control">
                                            <?=$student['record_id'];?>
                                        </p>
                            </div>
                            <div class="mb-3">
                                        <label>Password</label>
                                        <p class="form-control">
                                            <?=$pass;?>
                                        </p>
                            </div>
                            <div class="mb-3">
                                        <label>Admission Date</label>
                                        <p class="form-control">
                                            <?=$student['admission_date'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Hospital Name</label>
                                        <p class="form-control">
                                            <?=$student['hospital_name'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Doctor Name</label>
                                        <p class="form-control">
                                            <?=$docs['name'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Height</label>
                                        <p class="form-control">
                                            <?=$hgt;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Weight</label>
                                        <p class="form-control">
                                            <?=$wgt;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Blood Pressure</label>
                                        <p class="form-control">
                                            <?=$bp;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Temperature</label>
                                        <p class="form-control">
                                            <?=$temp;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Symptoms</label>
                                        <p class="form-control">
                                            <?=$symp;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Diagnosis</label>
                                        <p class="form-control">
                                            <?=$dgs;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Prescription</label>
                                        <p class="form-control">
                                            <?=$pcn;?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Comment</label>
                                        <p class="form-control">
                                            <?=$com;?>
                                        </p>
                                    </div>
                                   
                                    

                                    <div class="mb-3">
                                    <button onclick="window.print();" class="btn btn-success btn-sm">Print</button>

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
    <label></label>
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Laboratory Records 
                           
                        </h4>
                    </div>
                    <div class="card-body">
                                             <div class="mb-3">
                                              <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                  <th>Laboraratory ID</th>
                                                  <th>Record ID</th>
                                                  <th>Laboratory Date</th>
                                                  
                                                  <th>Action</th>
                                                      
                                                      
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <?php 
                                                      $connection = mysqli_connect("localhost","root","","cphrms");
                  
                                                  
                                                      $filtervalues = $rd;

                                                          $query="SELECT  * FROM lab_record WHERE record_id Like '%$filtervalues%' ";
                                                          
                                                          $query_run = mysqli_query($connection, $query);
                  
                                                          if(mysqli_num_rows($query_run) > 0)
                                                          {
                                                              foreach($query_run as $items)
                                                              {
                                                                  ?>
                                                                  <tr>
                                                                      <td><?= $items['lab_id']; ?></td>
                                                                      <td><?= $items['record_id']; ?></td>
                                                                      <td><?= $items['lab_date']; ?></td>
                                                                      
                  
                                                                      <td>
                                                                      <a href="view_labrecord.php?id=<?php echo $items['lab_id']; ?>" class="btn btn-info btn-sm">View</a>
                                                                      <a href="check_codoctorlab_form.php?id=<?php echo $items['lab_id']; ?>&r_id=<?php echo $rd; ?>" class="btn btn-info btn-sm">Grant</a>

                                                                      
                                                                    
                                                                      
                                                                      
                                                                  </tr>
                                                                  <?php
                                                              }
                                                          }
                                                          else
                                                          {
                                                              ?>
                                                                  <tr>
                                                                      <td colspan="4">No Record Found</td>
                                                                  </tr>
                                                              <?php
                                                          }
                                                      
                                                  ?>
                                              </tbody>
                                          </table>
                                            


                                            



                                        </p>
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