<?php
session_start();
include 'connect.php';

$adminId = $_SESSION['adminId'];
$department = $_POST['department'];
$courseName = $_POST['cName'];
$courseTopic = $_POST['cTopic'];
$level = $_POST['level'];
$semester = $_POST['semester'];
$creationDate = date('Y-m-d');

// File Upload Directory
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// File Upload Handling
$documentPath = null;
$videoPath = null;
$audioPath = null;

if (!empty($_FILES['document']['name'])) {
    $documentPath = $uploadDir . basename($_FILES['document']['name']);
    move_uploaded_file($_FILES['document']['tmp_name'], $documentPath);
}

if (!empty($_FILES['video']['name'])) {
    $videoPath = $uploadDir . basename($_FILES['video']['name']);
    move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
}

if (!empty($_FILES['audio']['name'])) {
    $audioPath = $uploadDir . basename($_FILES['audio']['name']);
    move_uploaded_file($_FILES['audio']['tmp_name'], $audioPath);
}

// Insert into Database
$insertQueue = "INSERT INTO resources (adminId, department, courseName, courseTopic, level, semester, creationDate, documentPath, videoPath, audioPath) 
                VALUES ('$adminId', '$department', '$courseName', '$courseTopic', '$level', '$semester', '$creationDate', '$documentPath', '$videoPath', '$audioPath')";

if ($conn->query($insertQueue) === TRUE) {
    header("Location: Profile.php");
    exit();
} else {
    echo "Error inserting into resources table: " . $conn->error;
}
?>
