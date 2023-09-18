<?php
require 'dbconfig.php';
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
include('../encryption/encryption.php');
$student_id = mysqli_real_escape_string($connection, $_GET['id']);
$student_id2 = mysqli_real_escape_string($connection, $_GET['id2']);
$url='http://localhost/cphrms/admin/view_doctor_department.php?id=&id2=';
$parsed_url = parse_url($url);
parse_str($parsed_url['query'], $query_params);


$query_params['id'] = $student_id;
$query_params['id2'] = $student_id2;


$new_query = http_build_query($query_params);
$new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . '?' . $new_query;

// Store the modified URL in the $_SESSION variable, or use it for redirect, etc.
$_SESSION['url'] = $new_url;
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
                        <h4>Doctor Information 
                            <a href="search_doctor_department.php?id=<?php echo $student_id2; ?>" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                           
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
                               $photo=$student['photo'];
                               $name=$student['name'];
                               $email=$student['email'];
                               $usr=$student['user_id'];




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
                                      <img id="myImg" style="width: 200px; height: 200px" src="../superadmin/image/profile/<?php echo $photo; ?>" onclick="openImagePopup(this)">

<div id="imagePopup" class="popup">
  <span class="popup-close" onclick="closeImagePopup()">&times;</span>
  <img id="popupImg" class="popup-content">
</div>
<script>
    function openImagePopup(img) {
  var popup = document.getElementById("imagePopup");
  var popupImg = document.getElementById("popupImg");
  popupImg.src = img.src;
  popup.style.display = "block";
}

function closeImagePopup() {
  var popup = document.getElementById("imagePopup");
  popup.style.display = "none";
}

    </script>
            <div class="mb-3">
            <div style="display: flex; flex-direction: row;">
  <div style="flex: 1;">
    <p>Name:</p>
    <p class="form-control">
      <?=$name;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <p>User ID:</p>
    <p class="form-control">
      <?=$usr;?>
    </p>
  </div>
  <div style="flex: 1; margin-left: 10px;">
                                        <label>Doctor ID</label>
                                        <p class="form-control">
                                            <?=$docid;?>
                                        </p>
                                    </div>
                                    <div style="flex: 1; margin-left: 10px;">
                                        <label>Doctor Position</label>
                                        <p class="form-control">
                                            <?=$docpos;?>
                                        </p>
                                    </div>
                                    <div style="flex: 1; margin-left: 10px;">
                                        <label>Department</label>
                                        <p class="form-control">
                                            <?=$docdep;?>
                                        </p>
                                    </div>
</div>
                                    
                                   
                                    <div class="mb-3">
                            <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
    <p>Gender:</p>
    <p class="form-control">
      <?=$gender;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <p>Birth Date:</p>
    <p class="form-control">
      <?=$bdate;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <p>Age:</p>
    <p class="form-control">
      <?=$age;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <p>Civil Status:</p>
    <p class="form-control">
      <?=$cstatus;?>
    </p>
  </div>
</div>
                                   
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <p class="form-control">
                                            <?=$address;?>
                                        </p>
                                    </div>
                                   
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
  <p>Phone Number:</p>
    <p class="form-control">
      <?=$phone;?>
    </p>
  </div>


  <div style="flex: 1; margin-left: 10px;">
    <p>Email:</p>
    <p class="form-control">
      <?=$email;?>
    </p>
  </div>

  
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
<style>
    /* Popup container */
.popup {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.9);
}

/* Popup content */
.popup-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Close button */
.popup-close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.popup-close:hover,
.popup-close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

    </style>
<?php
include ('includes/footer.php');
include('includes/scripts.php');
?>