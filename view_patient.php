<?php
require 'dbconfig.php';
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
include('../encryption/encryption.php');
$student_id = mysqli_real_escape_string($connection, $_GET['id']);

$url='http://localhost/cphrms/admin/view_patient.php?id=';
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
                        <h4>Patient Information 
                            <a href="search_patient.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $query = "SELECT * FROM user inner join patient on user.user_id=patient.user_id WHERE user.user_id='$student_id'";
                            $query_run = mysqli_query($connection, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
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
                                $photo=$student['photo'];
                                $usr=$student['user_id'];
                                $name=$student['name'];
                                $email=$student['email'];



                               
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
      <?=$name;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>User ID:</h6>
    <p class="form-control">
      <?=$usr;?>
    </p>
  </div>
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

                                    </div>
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
    <h6>Birth Place:</h6>
    <p class="form-control">
      <?=$bplace;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Address:</h6>
    <p class="form-control">
      <?=$address;?>
    </p>
  </div>

 
                                    </div>
                                   
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
    <h6>Blood Type:</h6>
    <p class="form-control">
      <?=$btype;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Phone Number:</h6>
    <p class="form-control">
      <?=$phone;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Email:</h6>
    <p class="form-control">
      <?=$email;?>
    </p>
  </div>

  
                                    </div>
                                   
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
    <h6>Guardian Name:</h6>
    <p class="form-control">
      <?=$gname;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Guardian Address:</h6>
    <p class="form-control">
      <?=$gaddress;?>
    </p>
  </div>
                                    </div>
                                    <div class="mb-3">
                                    <div style="display: flex; flex-wrap: wrap;">
  <div style="flex: 1;">
    <h6>Guardian Phone Number:</h6>
    <p class="form-control">
      <?=$gphone;?>
    </p>
  </div>

  <div style="flex: 1; margin-left: 10px;">
    <h6>Guardian Email:</h6>
    <p class="form-control">
      <?=$gemail;?>
    </p>
  </div>
                                    </div>
                                   
                                    <div class="mb-3">
                                    <table style="background-color: #FFFFFF;  border-spacing: 20px 20px; padding: 10px; width: 100%; border-collapse: separate; border-spacing: 0; text-align: center" class="table table-striped table-bordered">
  <thead style="background-color: #00009c; color: white">
    <tr>
      <th style="border-bottom: 2px solid black; padding: 10px">Allergy</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query="SELECT *  FROM allergy  WHERE user_id='$usr'";
      $query_run = mysqli_query($connection, $query);
      $row_count = 0;
      if(mysqli_num_rows($query_run) > 0){
        foreach($query_run as $items){
          $items['allergy']=decryptthis($items['allergy'],$key);
          $row_color = ($row_count % 2 == 0) ? "#FFFFFF" : "#dddddd";
    ?>
    <tr style="background-color: <?= $row_color ?>">
      <td style="border-bottom: 1px solid #ddd; padding: 10px"><?= $items['allergy'];?></td>
    </tr>
    <?php
          $row_count++;
        }
      }else{
    ?>
    <tr style="background-color: #FFFFFF">
      <td colspan="2" style="border-bottom: 1px solid #ddd; padding: 10px">No Record Found</td>
    </tr>
    <?php
      }
    ?>
  </tbody>
</table>
                                    </div>
                                    <div class="mb-3">
                                    <table style="background-color: #FFFFFF;  border-spacing: 20px 20px; padding: 10px; width: 100%; border-collapse: separate; border-spacing: 0; text-align: center" class="table table-striped table-bordered">
  <thead style="background-color: #00009c; color: white">
    <tr>
      <th style="border-bottom: 2px solid black; padding: 10px">Previous Medical History</th>
      <th style="border-bottom: 2px solid black; padding: 10px">Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query="SELECT *  FROM history  WHERE user_id='$usr'";
      $query_run = mysqli_query($connection, $query);
      $row_count = 0;
      if(mysqli_num_rows($query_run) > 0){
        foreach($query_run as $items){
          $items['history']=decryptthis($items['history'],$key);
          $row_color = ($row_count % 2 == 0) ? "#FFFFFF" : "#dddddd";
    ?>
    <tr style="background-color: <?= $row_color ?>">
      <td style="border-bottom: 1px solid #ddd; padding: 10px"><?= $items['history'];?></td>
      <td style="border-bottom: 1px solid #ddd; padding: 10px"><?= $items['date_created'];?></td>
    </tr>
    <?php
          $row_count++;
        }
      }else{
    ?>
    <tr style="background-color: #FFFFFF">
      <td colspan="2" style="border-bottom: 1px solid #ddd; padding: 10px">No Record Found</td>
    </tr>
    <?php
      }
    ?>
  </tbody>
</table>


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