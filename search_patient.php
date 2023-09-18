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
$_SESSION['url']='http://localhost/cphrms/admin/search_patient.php';



?>
<div class="container">
        <div class="row">
           

            <div class="col-md-12">
                <div class="card mt-4">
                    <div style="background-color:yellow;" class ="card-header">
                        <h4>View Patient</h4>
</div>
                    <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                                <tr>
                                <th>User ID</th>

                                <th>Name</th>
                                <th>Email</th>

                                <th>Action</th>


                               
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 

                                   
                                       
                                    $query="SELECT user_id, name, email  FROM user  WHERE role='Patient'";
                                        
                                        $query_run = mysqli_query($connection, $query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                               

                                                ?>
                                                <tr>
                                                    <td><?= $items['user_id']; ?></td>

                                                    <td><?= $items['name']; ?></td>
                                                    <td><?= $items['email']; ?></td>
                                                  
                                                    <td>
                                                    <a href="view_patient.php?id=<?php echo $items['user_id']; ?>" class="btn btn-info btn-sm">View</a>
                                                    
                                                    
                                                    
                                                  
                                                    
                                                    
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