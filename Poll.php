<?php

session_start();

include 'connect.php';


$studentId = $_SESSION['studentId'];

$pollTitle=$_POST['pTitle'];
$option1=$_POST['op1'];
$option2=$_POST['op2'];
$creationDate = date('Y-m-d');

$insertQueue = "INSERT INTO polls (studentId, pollTitle, option1, option2, creationDate) VALUES ('$studentId', '$pollTitle', '$option1','$option2', '$creationDate')";

if ($conn->query($insertQueue) === TRUE) {
    header("Location: Profile.php");
    exit();
}else{
    echo "Error inserting into posts table: " . $conn->error;
}?>