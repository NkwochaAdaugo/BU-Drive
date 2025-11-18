<?php
    include 'connect.php';

    session_start();

    if(isset($_SESSION['adminId'])) {
        $adminId = $_SESSION['adminId'];
    } else {
        $adminId = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students</title>
    <link rel="stylesheet" href="CSS/SignpUp.css">
</head>
<body>
    <div class="Container"> 
        <h2>Create Resource</h2>

        <form id="resourceForm" method="post" action="AddResources.php" enctype="multipart/form-data">
            <select id="department" name="department" required>
                <option value="" disabled selected>Select Department</option>
                <option value="CS">Computer Science (CS)</option>
                <option value="IT">Information Technology (IT)</option>
                <option value="CT">Computer Technology (CT)</option>
            </select> <br>

            <input type="text" id="courseName" name="cName" placeholder="Enter name of course" required> <br>
            <input type="text" id="courseTopic" name="cTopic" placeholder="Enter name of Topic" required> <br>
            <input type="number" id="level" name="level" placeholder="Level" required> <br>
            <p id="levelError" style="color: red; display: none;">Level can only be 100, 200, 300 and 400 level</p>

            <select id="semester" name="semester" required>
                <option value="" disabled selected>Select Semester</option>
                <option value="1st Semester">1st Semester</option>
                <option value="2nd Semester">2nd Semester</option>
            </select> <br>

            <input type="text" id="link" name="link" placeholder="Resource Link"> <br>

            <p>Input Document</p>
            <input type="file" id="document" name = "document" accept=".pdf, .doc, .docx, .xls, .xlsx, .txt">

            <p>Input Video</p>
            <input type="file" id="video" name = "video" accept="video/mp4,video/mkv,video/avi">

            <p>Input Audio</p>
            <input type="file" id="audio" name = "audio" accept="audio/mpeg,audio/wav,audio/ogg">

            <p id="resourceError" style="color: red; display: none;">Input at least one resource</p>

            <button type="submit"> Create </button> <br>
        </form>
    </div>

    <script>
        document.getElementById("resourceForm").addEventListener("submit", function(event) {
            let level = document.getElementById("level").value;
            let link = document.getElementById("link").value;
            let docFile = document.getElementById("document").files.length > 0;
            let vidFile = document.getElementById("video").files.length > 0;
            let audFile = document.getElementById("audio").files.length > 0;

            let levelError = document.getElementById("levelError");
            let resourceError = document.getElementById("resourceError");

            levelError.style.display = "none";
            resourceError.style.display = "none";

            if (![100, 200, 300, 400].includes(parseInt(level))) {
                event.preventDefault();
                levelError.style.display = "block";
            }

            if (!docFile && !vidFile && !audFile &&link == "") {
                event.preventDefault();
                resourceError.style.display = "block";
            }
        });
    </script>


</body>
</html>
