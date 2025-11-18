<?php
    include 'connect.php';

    session_start();

    if(isset($_SESSION['studentId'])) {
        $studentId = $_SESSION['studentId'];
        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";

        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);

        if($getStudentDetailsResult){
            while($row = mysqli_fetch_assoc($getStudentDetailsResult)){
                $level = htmlspecialchars($row['level']);
                $course = htmlspecialchars($row['course']);
            }
        }
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
        <h2> 1st Semester, <?php echo ''.$level.''; ?></h2>
        <?php
        
        $getAdminResources = "SELECT * FROM resources WHERE department = '$course' AND semester = '1st Semester' AND level = '$level' ORDER BY courseName";
            $getAdminResourcesResult = mysqli_query($conn, $getAdminResources);

            if ($getAdminResourcesResult && mysqli_num_rows($getAdminResourcesResult) > 0) {
                while ($row = mysqli_fetch_assoc($getAdminResourcesResult)) {
                    $resourceId = $row['resourceId'];
                    $courseName = $row['courseName'];
                    $courseTopic = $row['courseTopic'];

                    echo '
                        <div class="courses-container">
                            <div class="courses">
                                <div><h3>' . htmlspecialchars($courseName) . ': ' . htmlspecialchars($courseTopic) . '</h3></div>';  

                        // Check and display document
                        if (!empty($row['documentPath'])) {
                            echo "<a href='" . htmlspecialchars($row['documentPath']) . "' download><button class='courses-button'> Download Materials </button></a>";
                        }

                        // Check and display video
                        if (!empty($row['videoPath'])) {
                            echo "<p>Watch Video: <a href='" . htmlspecialchars($row['videoPath']) . "' download>Click Here</a></p>";
                        }

                        // Check and display audio
                        if (!empty($row['audioPath'])) {
                            echo "<p>Listen to Audio: <a href='" . htmlspecialchars($row['audioPath']) . "' download>Click Here</a></p>";
                        }

                        // Check and display external link
                        if (!empty($row['link'])) {
                            echo "<p>External Resource: <a href='" . htmlspecialchars($row['link']) . "' target='_blank'>Click Here</a></p>";
                        }

                        echo '  
                                </div>
                            </div>';

                }
            }
            else{
                echo '<h3 id="empty">No Resource Available.</h3>';
            }

        ?>
                
    <?php if(isset($_SESSION['studentId'])){?>
        <nav class="navigation">
            <a href="Homepage.php" class="nav-item">
                <img src="Icons/house.fill.png" alt="Profile icon">
                <span>Home</span>
            <a href="Resources.php" class="nav-item">
                <img src="Icons/folder.png" alt="Profile icon">
                <span>Resources</span>
            </a>
            <a href="Semester.php" class="nav-item">
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
            <a href="Resources.php" class="nav-item">
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

    <script src="JS/function.js"> </script>
</body>
</html>