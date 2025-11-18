<?php
    include 'connect.php';

    $pollId = $_GET['pollId'];

    session_start();

    if(isset($_SESSION['adminId'])) {
        $adminId = $_SESSION['adminId'];
        $getAdminDetails = "SELECT * FROM admins WHERE adminId = $adminId";

        $getAdminDetailsResult = mysqli_query($conn, $getAdminDetails);

        if($getAdminDetailsResult){
            while($row = mysqli_fetch_assoc($getAdminDetailsResult)){
                $role = htmlspecialchars($row['role']);

            }
        }
    }

    if(isset($_SESSION['studentId'])) {
        $studentId = $_SESSION['studentId'];
        $getStudentDetails = "SELECT * FROM students WHERE studentId = $studentId";

        $getStudentDetailsResult = mysqli_query($conn, $getStudentDetails);

        if($getStudentDetailsResult){
            while($row = mysqli_fetch_assoc($getStudentDetailsResult)){
                $role = htmlspecialchars($row['role']);
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
    <link rel="stylesheet" href="CSS/homepage.css">

</head>
<body>
    <header class="header">
        <div class="logo"><a href="#">BU-Drive <img src="Icons/externaldrive.fill.badge.icloud.png" alt="logo"></a></div>
        <div class="notifications"><a href="#"><img src="Icons/bell.png" alt="Notifications icon"></a></div>
    </header>

    <div class="container">
        <section>
            <div class="weekly-polls" style="display: flex; flex-direction: column; margin-top: 100px">
                <?php
                    $getPolls = "SELECT * FROM polls WHERE pollId = $pollId";
                    $getPollsResult = mysqli_query($conn, $getPolls);
                
                    if ($getPollsResult && mysqli_num_rows($getPollsResult) > 0) {
                        while ($row = mysqli_fetch_assoc($getPollsResult)) {
                            $studentId = $row['studentId'];
                            $pollId = $row['pollId'];
                            $pollTitle = htmlspecialchars($row['pollTitle']);
                            $option1 = htmlspecialchars($row['option1']);
                            $option2 = htmlspecialchars($row['option2']);

                            $creationDate = new DateTime($row['creationDate']);
                            $formattedDate = htmlspecialchars($creationDate->format('Y-m-d'));
                            $formattedDate = htmlspecialchars(date('Y-m-d', strtotime($row['creationDate'])));

                            $option1Vote = "SELECT COUNT(*) as count FROM votes WHERE pollId = $pollId AND option1 = 1";
                            $option1VoteResult = mysqli_query($conn, $option1Vote);
                            $amountOfOption1Vote = 0;
                            if ($option1VoteResult) {
                                $row = mysqli_fetch_assoc($option1VoteResult);
                                $amountOfOption1Vote = $row['count'];
                            }
                            else{
                                $amountOfOption1Vote = 0;
                            }

                            $option2Vote = "SELECT COUNT(*) as count FROM votes WHERE pollId = $pollId AND option2 = 1";
                            $option2VoteResult = mysqli_query($conn, $option2Vote);
                            $amountOfOption2Vote = 0;
                            if ($option2VoteResult) {
                                $row = mysqli_fetch_assoc($option2VoteResult);
                                $amountOfOption2Vote = $row['count'];
                            }
                            else{
                                $amountOfOption2Vote = 0;
                            }
                                
                            if($role == "Admin"){
                                echo '<h2 class="section-title">'.$pollTitle.'</h2>
                                    <div class="poll-card" style="width: 100%">
                                        <div class="poll-header">
                                            <div class="poll-icon"><img src="Icons/poll.png" alt="Vote icon"></div>
                                            <div>
                                                <div style="display: flex; margin-bottom: 40px; justify-content: space-between; width: 100%">
                                                    <div style="display: flex; flex-direction: column; margin-right: 30px">
                                                        <p>' . $option1 . '</p>
                                                        <p>Votes: ' . $amountOfOption1Vote . '</p>
                                                    </div>
                                                    <div style="display: flex; flex-direction: column">
                                                        <p>' . $option2 . '</p>
                                                        <p>Votes: ' . $amountOfOption2Vote . '</p>
                                                    </div>
                                                </div>
                                                <p class="poll-stats">Created on: ' . $formattedDate . '</p>
                                            </div>
                                        </div>
                                    </div>';
                            }

                            if($role == "Student"){
                                echo '<h2 class="section-title">'.$pollTitle.'</h2>
                                    <div class="poll-card" style="width: 100%">
                                        <div class="poll-header">
                                            <div class="poll-icon"><img src="Icons/poll.png" alt="Vote icon"></div>
                                            <div>
                                                <div style="display: flex; margin-bottom: 40px; justify-content: space-between; width: 100%">
                                                    <div style="display: flex; flex-direction: column; margin-right: 30px">
                                                        <p>' . $option1 . '</p>
                                                        <a href="PollVotingOption1.php?pollId=' . $pollId . '"><button class="btn" id="option1">Vote</button></a></br>
                                                        <p>Votes: ' . $amountOfOption1Vote . '</p>
                                                    </div>
                                                    <div style="display: flex; flex-direction: column">
                                                        <p>' . $option2 . '</p>
                                                        <a href="PollVotingOption2.php?pollId=' . $pollId . '"><button class="btn" id="option2">Vote</button></a></br>
                                                        <p>Votes: ' . $amountOfOption2Vote . '</p>
                                                    </div>
                                                </div>
                                                <p class="poll-stats">Created on: ' . $formattedDate . '</p>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                    }else {
                        echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>No Polls available.</p>";
                    }

                    $option1VoteForStudent = "SELECT * FROM votes WHERE pollId = $pollId AND studentId = $studentId";
                    $option1VoteForStudentResult = mysqli_query($conn, $option1VoteForStudent);

                    if ($option1VoteForStudentResult && mysqli_num_rows($option1VoteForStudentResult) > 0) {
                        while ($row = mysqli_fetch_assoc($option1VoteForStudentResult)) {
                            $option1ForStudent = htmlspecialchars($row['option1']);
                            $option2ForStudent = htmlspecialchars($row['option2']);
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
    <script>
        let option1 = document.getElementById("option1")
        let option2 = document.getElementById("option2")

        <?php if($option1ForStudent == 1){?>
            option1.style.backgroundColor = "green"
            option2.style.backgroundColor = "#007bff"
        <?php }?>

        <?php if($option2ForStudent == 1){?>
            option1.style.backgroundColor = "#007bff"
            option2.style.backgroundColor = "green"
        <?php }?>
    </script>
</body>
</html>