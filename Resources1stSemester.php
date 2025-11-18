<?php
include 'connect.php';

session_start();

if (isset($_GET['department']) && isset($_GET['level'])) {
    $department = htmlspecialchars($_GET['department']);
    $level = htmlspecialchars($_GET['level']);
    $semester = htmlspecialchars($_GET['semester']);
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
        <h2> 1st Semester, <?php echo ''.$level.''; ?>L</h2>
        <?php
        
        $getAdminResources = "SELECT * FROM resources WHERE department = '$department' AND semester = '$semester' AND level = '$level' ORDER BY courseName";
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
                            echo "<a href='" . htmlspecialchars($row['documentPath']) . "' download><button class='courses-button'> Download Document </button></a>";
                        }

                        // Check and display video
                        if (!empty($row['videoPath'])) {
                            echo "<a href='" . htmlspecialchars($row['videoPath']) . "' download><button class='courses-button'> Download Video </button></a>";
                        }

                        // Check and display audio
                        if (!empty($row['audioPath'])) {
                            echo "<a href='" . htmlspecialchars($row['audioPath']) . "' download><button class='courses-button'> Download Audio </button></a>";
                        }

                        // Check and display external link
                        if (!empty($row['link'])) {
                            echo "<button class='courses-button'><p>External Resource <a style='color: blue' href='" . htmlspecialchars($row['link']) . "' target='_blank'>" . htmlspecialchars($row['link']) . "</a></p></button>";
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