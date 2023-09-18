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

$_SESSION['url']='http://localhost/cphrms/admin/search_department.php';


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
                        <h4>View Department</h4>
</div>
                    <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                                <tr>
                                <th>Department ID</th>
                                <th>Department Name</th>
                                <th>Number of Doctors</th>
                                <th>Actions</th>
                               
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                   
                                       
                                        $query="SELECT d.department_id AS department_id, d.department_name AS department_name, COUNT(doc.department_id) AS num_doctors FROM department d left JOIN doctor doc ON doc.department_id = d.department_id where d.hospital_id='$hid' GROUP BY d.department_id";
                                        
                                        $query_run = mysqli_query($connection, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                               

                                                ?>
                                                <tr>
                                                    <td><?= $items['department_id']; ?></td>
                                                    <td><?= $items['department_name']; ?></td>
                                                    <td><?= $items['num_doctors']; ?></td>
                                                   
                                                   <?php
                                                   if($items['num_doctors']>0){

                                                  ?>
                                                    <td>
                                                    <a href="search_doctor_department.php?id=<?php echo $items['department_id']; ?>" class="btn btn-info btn-sm">View</a>
                                                <?php
                                                }else{
                                                    ?>
                                                <td>No Action</td>
<?php
                                                }        
     ?>                                             
                                                    
                                                    
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