<?php

session_start();

include 'connect.php';


$studentId = $_SESSION['studentId'];

$postTitle=$_POST['pTitle'];
$post=$_POST['post'];
$creationDate = date('Y-m-d');
$image=$_FILES['image']['tmp_name'];
$imgContent = addslashes(file_get_contents($image));

$insertQueue = "INSERT INTO posts (studentId, postTitle, post, creationDate, image) VALUES ('$studentId', '$postTitle', '$post','$creationDate','$imgContent')";

if ($conn->query($insertQueue) === TRUE) {
    header("Location: Profile.php");
    exit();
}else{
    echo "Error inserting into posts table: " . $conn->error;
}?>