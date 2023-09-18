<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.
//include('security.php');
$page_title = 'Register';
//session_start();
include('dbconfig.php');
include('security.php');

include('../encryption/encryption.php');

include ('includes/header.php');
include ('includes/navbar.php');
$_SESSION['url']='http://localhost/cphrms/admin/search_laboratory.php';

$user=$_SESSION['user_id'];
$sql3 = " SELECT hospital_id from admin WHERE user_id='" . $user . "'; ";

$r3 = mysqli_query($connection, $sql3);
$usertypes = mysqli_fetch_array($r3);
$hid=$usertypes['hospital_id'];
?>
<div class="container">
        <div class="row">
           

            <div class="col-md-12">
                <div class="card mt-4">
                    <div style="background-color:yellow;" class ="card-header">
                        <h4>View Laboratory</h4>
</div>
                    <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                                <tr>
                                <th>Laboratory ID</th>

                                <th>Name</th>
                              
                                <th>Action</th>


                               
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                   
                                       
                                    $query="SELECT *  FROM laboratory inner join user on laboratory.user_id=user.user_id WHERE laboratory.hospital_id='$hid'";
                                        
                                        $query_run = mysqli_query($connection, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                               

                                                ?>
                                                <tr>
                                                    <td><?= $items['laboratory_id']; ?></td>

                                                    <td><?= $items['name']; ?></td>
                                                  
                                                    <td>
                                                    <a href="view_laboratory.php?id=<?php echo $items['user_id']; ?>" class="btn btn-info btn-sm">View</a>
                                                    <a href="edit_laboratory.php?id=<?php echo $items['user_id']; ?>" class="btn btn-info btn-sm">Edit Active Status</a>

                                                    
                                                    
                                                  
                                                    
                                                    
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