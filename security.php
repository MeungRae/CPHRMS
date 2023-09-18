<?php
session_start();
include('dbconfig.php');
if($connection)
{
    // echo "Database Connected";
}
else
{
    header("Location: dbconfig.php");
}

if(!$_SESSION['email'])
{
    header('Location: ../login/login.php');
}else{
    if($_SESSION['role']!="Admin"){
    header('Location: ../login/multi_role.php');

    }
}
?>