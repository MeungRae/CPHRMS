<?php
require 'dbconfig.php';
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
include('../encryption/encryption.php');
$student_id = mysqli_real_escape_string($connection, $_GET['id']);

$url='http://localhost/cphrms/admin/view_laboratory.php?id=';
$parsed_url = parse_url($url);
parse_str($parsed_url['query'], $query_params);


$query_params['id'] = $student_id;


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
                        <h4>Laboratory Information 
                            <a href="search_laboratory.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $query10 = "SELECT * FROM user inner join laboratory on user.user_id=laboratory.user_id inner join hospital on laboratory.hospital_id=hospital.hospital_id WHERE user.user_id='$student_id' ";
                            $query_run10 = mysqli_query($connection, $query10);
                            $student = mysqli_fetch_array($query_run10);

                            if(mysqli_num_rows($query_run10) > 0)
                            {
                                $bdate=$student['bdate'];
                                $bplace=$student['bplace'];
                                $gender=$student['gender'];
                                $cstatus=$student['cstatus'];
                                $btype=$student['btype'];
                                $hnum=$student['hnum'];
                                $street=$student['street'];
                                $brgy=$student['brgy'];
                                $mun=$student['mun'];
                                $prov=$student['prov'];
                                $phone=$student['phone'];
                                $gname=$student['gname'];
                                $gemail=$student['gemail'];
                                $gphone=$student['gphone'];
                                $gaddress=$student['gaddress'];
                               $docid=$student['laboratory_id'];
                               $hid=$student['hospital_id'];
                               $photo=$student['photo'];
                               $hosname=$student['hospital_name'];




                                $bplace=decryptthis($bplace,$key);
                                $gender=decryptthis($gender,$key);
                                $cstatus=decryptthis($cstatus,$key);
                                $btype=decryptthis($btype,$key);
                              
                                $street=decryptthis($street,$key);
                                $brgy=decryptthis($brgy,$key);
                                $mun=decryptthis($mun,$key);
                                $prov=decryptthis($prov,$key);
                                $phone=decryptthis($phone,$key);
                                $gname=decryptthis($gname,$key);
                                $gemail=decryptthis($gemail,$key);
                                $gphone=decryptthis($gphone,$key);
                                $gaddress=decryptthis($gaddress,$key);
                                
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
    <h6>Name:</h6>
    <p class="form-control">
      <?=$student['name'];?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>User ID:</h6>
    <p class="form-control">
      <?=$student['user_id'];?>
    </p>
  </div>
  <div style="flex: 1; margin-left: 10px;">
    <h6>Laboratory ID:</h6>
    <p class="form-control">
      <?=$docid;?>
    </p>
  </div>
  <div style="flex: 1; margin-left: 10px;">
    <h6>Hospital:</h6>
    <p class="form-control">
      <?=$hosname;?>
    </p>

</div>
                                    </div>
                                 
                            <div class="mb-3">
                            <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
    <h6>Gender:</h6>
    <p class="form-control">
      <?=$gender;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Birth Date:</h6>
    <p class="form-control">
      <?=$bdate;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Age:</h6>
    <p class="form-control">
      <?=$age;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Civil Status:</h6>
    <p class="form-control">
      <?=$cstatus;?>
    </p>
  </div>
</div>

                                   
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
                                        <h6>Address:</h6>
                                        <p class="form-control">
                                            <?=$address;?>
                                        </p>
                                    </div>
</div>
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
  <h6>Phone Number:</h6>
    <p class="form-control">
      <?=$phone;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Email:</h6>
    <p class="form-control">
      <?=$student['email'];?>
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