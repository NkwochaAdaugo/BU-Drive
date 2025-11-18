<?php
session_start();

include 'connect.php';

$postId = $_GET['postId'];

$deletePost = "DELETE FROM posts WHERE postId=$postId";

$deletePostResult = mysqli_query($conn, $deletePost);

if($deletePostResult){
    header("Location: ./Profile.php");
}
else{
    die(mysqli_error($conn));
}

?>