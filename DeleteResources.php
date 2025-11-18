<?php
session_start();

include 'connect.php';

$resourceId = $_GET['resourceId'];

$deleteResource = "DELETE FROM resources WHERE resourceId = $resourceId";

$deleteResourceResult = mysqli_query($conn, $deleteResource);

if($deleteResourceResult){
    header("Location: ./Profile.php");
}
else{
    die(mysqli_error($conn));
}

?>