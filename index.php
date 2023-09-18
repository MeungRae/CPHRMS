<?php
include('security.php');

include('includes/header.php'); 
include('includes/navbar.php'); 
$uid=$_SESSION['user_id'];
$_SESSION['url']='http://localhost/cphrms/admin/index.php';

$query1="SELECT * from admin where user_id='$uid'";
$query_run1 = mysqli_query($connection, $query1);
$students = mysqli_fetch_array($query_run1);
$hid=$students['hospital_id'];
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
    
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-3">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Medical Records</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                $query="SELECT COUNT(record_id) AS num_records FROM medical_record where hospital_id='$hid'";
                $query_run = mysqli_query($connection, $query);
                $student = mysqli_fetch_array($query_run);
              ?>
               <h4><?php echo $student['num_records'];?></h4>
            </div>
          </div>
          <div class="col-auto">
          <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                  </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-3">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Doctors</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                $query="SELECT COUNT(user_id) AS num_doctor FROM doctor where hospital_id='$hid' ";
                $query_run = mysqli_query($connection, $query);
                $student = mysqli_fetch_array($query_run);
              ?>
               <h4><?php echo $student['num_doctor'];?></h4>
            </div>
          </div>
          <div class="col-auto">
          <i class="fas fa-user-md fa-2x text-gray-300"></i>
                  </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-3">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Lab Records</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                $query="SELECT COUNT(lab_id) AS num_lab FROM lab_record inner join laboratory on lab_record.laboratory_id=laboratory.laboratory_id where hospital_id='$hid'";
                $query_run = mysqli_query($connection, $query);
                $student = mysqli_fetch_array($query_run);
              ?>
               <h4><?php echo $student['num_lab'];?></h4>
            </div>
          </div>
          <div class="col-auto">
          <i class="fas fa-microscope fa-2x text-gray-300"></i>
                  </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-3">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Laboratory</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                $query="SELECT COUNT(laboratory_id) AS num_l FROM laboratory where hospital_id='$hid'";
                $query_run = mysqli_query($connection, $query);
                $student = mysqli_fetch_array($query_run);
              ?>
               <h4><?php echo $student['num_l'];?></h4>
            </div>
          </div>
          <div class="col-auto">
          <i class="fas fa-flask fa-2x text-gray-300"></i>
                  </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-3">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Admitted Patient</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                $query="SELECT COUNT(admission_id) AS num_l FROM admission inner join medical_record on admission.record_id=medical_record.record_id where hospital_id='$hid' and admission_status!='DISCHARGED'";
                $query_run = mysqli_query($connection, $query);
                $student = mysqli_fetch_array($query_run);
              ?>
               <h4><?php echo $student['num_l'];?></h4>
            </div>
          </div>
          <div class="col-auto">
          <i class="fas fa-bed fa-2x text-gray-300"></i>
                  </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->








  <?php
include('includes/scripts.php');
include('includes/footer.php');
?>