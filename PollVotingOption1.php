<?php
session_start();
include 'connect.php';

if (!isset($_GET['pollId']) || !isset($_SESSION['studentId'])) {
    die("Invalid request.");
}

$pollId = intval($_GET['pollId']);
$studentId = intval($_SESSION['studentId']);

if ($pollId === 0 || $studentId === 0) {
    die("Invalid poll or student ID.");
}

$checkVote = "SELECT * FROM votes WHERE studentId='$studentId' AND pollId='$pollId'";
$checkVoteResult = mysqli_query($conn, $checkVote);

if ($checkVoteResult && mysqli_num_rows($checkVoteResult) > 0) {
    $deleteVote = "DELETE FROM votes WHERE studentId='$studentId' AND pollId='$pollId'";
    if (!mysqli_query($conn, $deleteVote)) {
        die("Error deleting previous vote: " . mysqli_error($conn));
    }
}

$option1 = 1;
$option2 = 0;
$createVote = "INSERT INTO votes (pollId, studentId, option1, option2) VALUES ('$pollId', '$studentId', '$option1', '$option2')";

if (mysqli_query($conn, $createVote)) {
    header("Location: Homepage.php");
    exit();
} else {
    die("Error inserting vote: " . mysqli_error($conn));
}
?>
