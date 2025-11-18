<?php
    include 'connect.php';

    session_start();

    $postId = $_GET['postId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students </title>
    <link rel="stylesheet" href="CSS/homepage.css">

</head>
<body>
<header class="header">
        <div class="logo"><a href="#">BU-Drive <img src="Icons/externaldrive.fill.badge.icloud.png" alt="logo"></a></div>
        <div class="notifications"><a href="#"><img src="Icons/bell.png" alt="Notifications icon"></a></div>
    </header>

    <div class="container">
        <section style="margin-top: 100px;">
            <?php
                $getPost = "SELECT * FROM posts WHERE postId = $postId";
                $getPostResult = mysqli_query($conn, $getPost);
            
                if ($getPostResult && mysqli_num_rows($getPostResult) > 0) {
                    while ($row = mysqli_fetch_assoc($getPostResult)) {
                        $studentId = htmlspecialchars($row['studentId']);
                        $postTitle = htmlspecialchars($row['postTitle']);
                        $post = htmlspecialchars($row['post']);

                        $creationDate = new DateTime($row['creationDate']);
                        $formattedDate = htmlspecialchars($creationDate->format('Y-m-d'));
                        $formattedDate = htmlspecialchars(date('Y-m-d', strtotime($row['creationDate'])));
                        $image = 'data:image/jpeg;base64,' . base64_encode($row['image']);

                        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";
                        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);
                        if ($getStudentDetailsResult && mysqli_num_rows($getStudentDetailsResult) > 0) {
                            $student = mysqli_fetch_assoc($getStudentDetailsResult);
                            $studentFullName = htmlspecialchars($student['fullName']);
                            $studentEmail = htmlspecialchars($student['email']);
                        }
            
                        echo '<div style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center">
                                    <img src="'.$image.'" alt="Image post" style="height: 400px; width: 50%">
                                    <h2 class="section-title" style="margin-top: 50px">' . $postTitle . '</h2>
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <p>' . $post . '</p>
                                        <div class="blog-meta">
                                            <p>By '.$studentFullName.' on ' . $formattedDate . '</p>
                                        </div>
                                    </div>
                                </div>';
                    }
                }else {
                    echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>Post Unavailable.</p>";
                }
            ?>
        </section>
            
    </div>

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