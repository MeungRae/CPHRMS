<?php
include('dbconfig.php');
include('security.php');

include ('includes/header.php');
include ('includes/navbar.php');
$_SESSION['url']='http://localhost/cphrms/admin/success_laboratory.php';

?>
                <div style="text-align:center;background-color:green;color:white; display:block; padding:10px;font-size:14px;transform: translateY(-20px);margin-bottom: 20px;" class="red-text">Laboratory Created Successfully<li><a class="getstarted scrollto" href="create_laboratory.php">Create another laboratory</a></li> 
</div>

<?php
include ('includes/footer.php');
include ('includes/scripts.php');

?>