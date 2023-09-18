<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.
//include('security.php');
$page_title = 'Register';
session_start();
include('dbconfig.php');
include('security.php');

include('../encryption/encryption.php');

include ('includes/header.php');
include ('includes/navbar.php');
$_SESSION['url']='http://localhost/cphrms/admin/activity_log.php';

$usr=$_SESSION['user_id'];
$sql3 = "SELECT hospital_id from admin WHERE user_id='" . $usr . "'";

$r3 = mysqli_query($connection, $sql3);
$usertypes = mysqli_fetch_array($r3);
$hid=$usertypes['hospital_id'];
?>
<div class="container">
        <div class="row">
           

            <div class="col-md-12">
                <div class="card mt-4">
                    <div style="background-color:yellow;" class ="card-header">
                        <h4>View Login Activity Log</h4>
</div>
                    <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                                <tr>
                                <th style="display:none">Loginn</th>                                    
                                <th>User ID</th>
                                <th>Session ID</th>
                                <th>Login</th>
                                <th>IP Address</th>
                                <th>Logout</th>
                                <th>Status</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                   
                                       
                                        $query="SELECT login_log.user_id, login_log.log_session, login_log.ip_address, login_log.login, login_log.logout, login_log.status FROM login_log INNER join admin on login_log.user_id=admin.user_id where admin.hospital_id='$hid' UNION SELECT login_log.user_id, login_log.log_session, login_log.ip_address, login_log.login, login_log.logout, login_log.status FROM login_log INNER join doctor on login_log.user_id=doctor.user_id where doctor.hospital_id='$hid' UNION SELECT login_log.user_id, login_log.log_session, login_log.ip_address, login_log.login, login_log.logout, login_log.status FROM login_log INNER join laboratory on login_log.user_id=laboratory.user_id where laboratory.hospital_id='$hid' order by login desc;";
                                        
                                        $query_run = mysqli_query($connection, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                               $log=$items['login'];

                                                ?>
                                                <tr>
                                               
                                                <td style="display:none"><?= $log; ?></td>
                                                    <td><?= $items['user_id']; ?></td>
                                                    <td><?= $items['log_session']; ?></td>
                                                    <td><?= $items['login']; ?></td>
                                                    <td><?= $items['ip_address']; ?></td>
                                                    <td><?= $items['logout']; ?></td>
                                                    <td><?= $items['status']; ?></td>

                                                    
                                                  
                                                    
                                                    
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
                    </div>
                </div>
            </div>
        </div>
    </div>
   
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <?php 
include ('includes/footer.php');
include ('includes/scripts.php');
 ?>