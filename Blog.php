<?php
    include 'connect.php';

    session_start();
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
    <div style="width: 100%; margin-top: 100px">
        <form action="" method="GET" style="display: flex; align-items: center; justify-content: center; width: 100%;">
            <input style="padding: 10px; border-radius: 5px 0px 0px 5px; outline: none; border-right: none;" type="text" name="search" placeholder = "Search Blog" style="width: 25%;" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>">
            <button type="submit" style="padding: 12px; border-radius: 0px 5px 5px 0px; background-color: #007bff; outline: none; border: none; color: white; width: 25%;">Search</button>
        </form>
    </div>

    <h2 class="section-title">Blogs</h2>
    <section>
        <div class="blog-posts">
        <?php 
            if (isset($_GET['search']) && !empty($_GET['search'])) { 
                include 'connect.php';

                $filterValues = $_GET['search'];
                $query = "SELECT * FROM posts WHERE postTitle LIKE '%$filterValues%' OR post LIKE '%$filterValues%'";

                $queryResult = mysqli_query($conn, $query);

                if (mysqli_num_rows($queryResult) > 0) {
                    while ($blogDetail = mysqli_fetch_assoc($queryResult)) {
                        $image = 'data:image/jpeg;base64,' . base64_encode($blogDetail['image']);
                        $postId = $blogDetail['postId'];
                        $formattedDate = htmlspecialchars(date('Y-m-d', strtotime($blogDetail['creationDate'])));

                        $studentId = $blogDetail['studentId'];
                        $studentFullName = "Unknown Author";
                        
                        $getStudentDetails = "SELECT fullName FROM students WHERE studentId = $studentId";
                        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);
                        if ($getStudentDetailsResult && mysqli_num_rows($getStudentDetailsResult) > 0) {
                            $student = mysqli_fetch_assoc($getStudentDetailsResult);
                            $studentFullName = htmlspecialchars($student['fullName']);
                        }
                        ?>
                        <div class="blog-card">
                            <img src="<?= $image ?>" alt="Blog Image" class="blog-image">
                            <div class="blog-content">
                                <h3><?= htmlspecialchars($blogDetail['postTitle']); ?></h3>
                                <div class="blog-meta">
                                    <p>By <?= $studentFullName ?> on <?= $formattedDate ?></p>
                                </div>
                                <a href="ReadPost.php?postId=<?= $postId ?>"><button class="btn">Read More</button></a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <p style="padding: 50px">Blog doesn't exist.</p>
                    </div>
                    <?php
                }
            }
            else{
                $getPosts = "SELECT * FROM posts ORDER BY creationDate DESC";
                $getPostsResult = mysqli_query($conn, $getPosts);
            
                if ($getPostsResult && mysqli_num_rows($getPostsResult) > 0) {
                    while ($row = mysqli_fetch_assoc($getPostsResult)) {
                        $studentId = $row['studentId'];
                        $postId = $row['postId'];
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

                        echo '
                                <div class="blog-card">
                                    <img src="'.$image.'" alt="Remote learning" class="blog-image">
                                    <div class="blog-content">
                                        <h3>' . $postTitle . '</h3>
                                        <div class="blog-meta">
                                            <p>By '.$studentFullName.' on ' . $formattedDate . '</p>
                                        </div>
                                            <a href="ReadPost.php?postId=' . $postId . '"><button class="btn">Read More</button></a></br>
                                    </div>
                                </div>';
                    }
                }else {
                    echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>No Posts available.</p>";
                }
            }
        ?>
        </div>
        
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