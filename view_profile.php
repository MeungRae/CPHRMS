<?php
include('dbconfig.php');
include('security.php');

include('includes/header.php'); 
include('includes/navbar.php');
include('../encryption/encryption.php');
$_SESSION['url']='http://localhost/cphrms/admin/view_profile.php';

$usr=$_SESSION['user_id'];
$query="SELECT * FROM user WHERE user_id='" . $usr . "'";
$query_run = mysqli_query($connection, $query);
$usertypes = mysqli_fetch_array($query_run);
$query1="SELECT * FROM admin inner join hospital on admin.hospital_id=hospital.hospital_id WHERE admin.user_id='" . $usr . "'";
$query_run1 = mysqli_query($connection, $query1);
$usertypes1 = mysqli_fetch_array($query_run1);
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

$address="{$hnum} {$street} {$brgy} {$mun} {$prov}";
?>
 <div class="container mt-5">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Profile Information
                <a style="background-color:green;"href="edit_profile.php?id=<?php echo $usr ?>" class="btn btn-danger float-end">EDIT</a>

                </h4>
            </div>
            <div class="card-body">
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
                                </div>
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
  <p>Hospital Name</p>
                                        <p class="form-control">
                                            <?=$hosname;?>
                                        </p>
  </div>
</div>
                            
                                    <div class="mb-3">
                                        <p>Address</p>
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
                                    </div>
                                    </div>
                                    </div>
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
include('includes/scripts.php');
include('includes/footer.php');
?>