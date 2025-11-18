<?php
session_start();

include 'connect.php';

$pollId = $_GET['pollId'];

$deletePoll = "DELETE FROM polls WHERE pollId = $pollId";
$deletePollFromVotes = "DELETE FROM votes WHERE pollId = $pollId";

$deletePollResult = mysqli_query($conn, $deletePoll);
$deletePollFromVotesResult = mysqli_query($conn, $deletePollFromVotes);

if($deletePollResult && $deletePollFromVotesResult){
    header("Location: Profile.php");
}
else{
    die(mysqli_error($conn));
}

?>