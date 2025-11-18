<?php
include 'connect.php';

session_start();

if (isset($_GET['department'])) {
    $department = $_GET['department'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students </title>
    <link rel="stylesheet" href="CSS/MyCourses.css">

</head>
<body>
    <header class="header">
        <div class="logo"><a href="#">BU-Drive <img src="Icons/externaldrive.fill.badge.icloud.png" alt="logo"></a></div>
        <div class="notifications"><a href="#"><img src="Icons/bell.png" alt="Notifications icon"></a></div>
    </header>

    <div class="container">
        <h2> Select Level </h2>
                <div class="courses-container">
                <div class="courses">
                    <div><h3> 100L </h3></div>
                    <div class="courses-button"><a href="SelectSem.php?department=<?php echo urlencode($department); ?>&level=100">Select Semester</a></div>
                </div>
                <div class="courses">
                    <div><h3> 200L </h3></div>
                    <div class="courses-button"><a href="SelectSem.php?department=<?php echo urlencode($department); ?>&level=200">Select Semester</a></div>
                </div>
                <div class="courses">
                    <div><h3> 300L </h3></div>
                    <div class="courses-button"><a href="SelectSem.php?department=<?php echo urlencode($department); ?>&level=300">Select Semester</a></div>
                </div>
                <div class="courses">
                    <div><h3> 400L </h3></div>
                    <div class="courses-button"><a href="SelectSem.php?department=<?php echo urlencode($department); ?>&level=400">Select Semester</a></div>
                </div>
                </div>

    <?php if(isset($_SESSION['studentId'])){?>
        <nav class="navigation">
            <a href="Homepage.php" class="nav-item">
                <img src="Icons/house.fill.png" alt="Profile icon">
                <span>Home</span>
            <a href="Resources.html" class="nav-item">
                <img src="Icons/folder.png" alt="Profile icon">
                <span>Resources</span>
            </a>
            <a href="Semester.html" class="nav-item">
                <img src="Icons/my courses.png" alt="Profile icon">
                <span>My Courses</span>
            </a>
            <a href="Profile.php" class="nav-item">
                <img src="Icons/profile.png" alt="Profile icon">
                <span>Profile</span>
            </a>
        </nav>
    <?php }?>
    <?php if(isset($_SESSION['adminId'])){?>
        <nav class="navigation">
            <a href="Homepage.php" class="nav-item">
                <img src="Icons/house.fill.png" alt="Profile icon">
                <span>Home</span>
            <a href="Resources.html" class="nav-item">
                <img src="Icons/folder.png" alt="Profile icon">
                <span>Resources</span>
            </a>
            <a href="Profile.php" class="nav-item">
                <img src="Icons/profile.png" alt="Profile icon">
                <span>Profile</span>
            </a>
        </nav>
    <?php }?>
</body>
</html>
    <script src="../JS/function.js"> </script>

</body>
</html>