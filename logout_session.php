<?php # Script 12.11 - logout.php #2
// This page lets the user logout.
// This version uses sessions.

include('security.php');
 $sid=$_SESSION['session_id'];
 echo $sid;
 $status="OFFLINE";
 $sql="UPDATE login_log SET logout=NOW(),status='$status' where log_session='$sid'";
 $r=mysqli_query ($connection, $sql); // Run the query.
sleep(5);
header('Location:logout.php');
?>