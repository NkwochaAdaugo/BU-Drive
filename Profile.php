<?php
    include 'connect.php';

    session_start();

    if(isset($_SESSION['adminId'])) {
        $adminId = $_SESSION['adminId'];
        $getAdminDetails = "SELECT * FROM admins WHERE adminId = $adminId";

        $getAdminDetailsResult = mysqli_query($conn, $getAdminDetails);

        if($getAdminDetailsResult){
            while($row = mysqli_fetch_assoc($getAdminDetailsResult)){
                $adminFullName = htmlspecialchars($row['fullName']);
                $adminEmail = htmlspecialchars($row['email']);
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
                $studentFullName = htmlspecialchars($row['fullName']);
                $studentEmail = htmlspecialchars($row['email']);
                $course = htmlspecialchars($row['course']);
                $level = htmlspecialchars($row['level']);
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
    <link rel="stylesheet" href="CSS/Homepage.css">

</head>
<body>
<header class="header">
        <div class="logo"><a href="#">BU-Drive <img src="Icons/externaldrive.fill.badge.icloud.png" alt="logo"></a></div>
        <div class="notifications"><a href="#"><img src="Icons/bell.png" alt="Notifications icon"></a></div>

        <style>
            .courses {
                display: flex;
                margin-bottom: 2rem;
                justify-content: space-between;
                width: 100%;
            }

            .courses-button {
                font-size: 14px;
                padding: 12px 20px;
                background: #ebebeb;
                border-radius: 15px;
                border: none;
                cursor: pointer; 
            }

            .courses-button a {
                font-size: 15px;
                text-decoration: none;
                color: black;
            }
        </style>
    </header>

    <div class="container">
        <?php
            if ($role == 'Admin') echo '<div style= "margin-top: 100Px">
                                            <h2> Admin Details </h2>
                                            <div style= "margin-top: 15px">
                                                <p style>Name: '.$adminFullName.'</p>
                                                <p style= "margin-top: 10px"> Email: '.$adminEmail.'</p>
                                            </div>
                                        </div>
                                        <a href="CreateResourcePhp.php"><button style="padding: 0.5rem 1rem; border-radius: 5px; width: 25%; background-color: #007bff; color: white; border: none; margin-top: 20px; cursor: pointer; font-weight: bold">Create/Upload Resource</button></a>
                                        <a href="UpdateAdminAccount.php?updateId=' . $adminId . '"><button style="padding: 0.5rem 1rem; border-radius: 5px; width: 25%; background-color: #007bff; color: white; border: none; margin-left: 50px; cursor: pointer; font-weight: bold">Update Account</button></a>';
            
            if ($role == 'Student') echo '<div style= "margin-top: 100px">
                                            <h2> Student Details </h2>
                                            <div style= "margin-top: 15px">
                                                <p>Name: '.$studentFullName.'</p>
                                                <p style= "margin-top: 10px"> Email: '.$studentEmail.'</p>
                                                <p>level: '.$level.'</p>
                                                <p>course: '.$course.'</p>
                                            </div>
                                        </div>
                                        <a href="UpdateStudentAccount.php?updateId=' . $studentId . '"><button style="padding: 0.5rem 1rem; border-radius: 5px; width: 25%; color: white; background-color: #007bff; margin-top: 15px; cursor: pointer; font-weight: bold; border: none">Edit Account Details</button></a>
                                        <a href="CreatePost.php"><button style="padding: 0.5rem 1rem; border-radius: 5px; width: 25%; background-color: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; margin-left: 15px">Create Post</button></a>
                                        <a href="CreatePoll.php"><button style="padding: 0.5rem 1rem; border-radius: 5px; width: 25%; background-color: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; margin-left: 15px">Create Poll</button></a>';
        
        ?>

        <?php if ($role == 'Admin'){
            $getAdminResources = "SELECT * FROM resources WHERE adminId = $adminId ORDER BY creationDate DESC";
            $getAdminResourcesResult = mysqli_query($conn, $getAdminResources);

            if ($getAdminResourcesResult && mysqli_num_rows($getAdminResourcesResult) > 0) {
                echo '<h2 style="margin-top: 50px; margin-bottom: 40px;">Resources Uploaded</h2>';

                while ($row = mysqli_fetch_assoc($getAdminResourcesResult)) {
                    $resourceId = $row['resourceId'];
                    $courseName = $row['courseName'];
                    $courseTopic = $row['courseTopic'];

                    echo '
                        <div class="courses-container">
                            <div class="courses">
                                <div><h3>' . htmlspecialchars($courseName) . ': ' . htmlspecialchars($courseTopic) . '</h3></div>';   

                            echo "<a href='DeleteResource.php?resourceId=" . $resourceId . "'><button class='btn' style='background-color: red'>Delete Resources</button></a>";

                        echo '  
                                </div>
                            </div>';

                }
            }
            else{
                echo '<h3 id="empty">You have not uploaded any resources.</h3>';
            }
        }?>

        <?php 
            if($role == 'Student'){
        ?>
            <div id="buttons" style="width: 100%; display: flex; justify-content: center">
                <button id= "blogsSectionBtn" class="btn" style="background-color: light green; margin-top: 20px; margin-right: 20px">Blogs</button>
                <button id= "pollsSectionBtn" class="btn" style="background-color: light green; margin-top: 20px">Polls</button>
            </div>
        <?php }?>

        <?php 
            if($role == 'Student'){
        ?>

            <section id="blogsSection">
                <h2 class="section-title">Blog</h2>
                <div class="blog-posts">
                <?php
                    $getPosts = "SELECT * FROM posts WHERE studentId = $studentId ORDER BY creationDate DESC";
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
                                            <div style="display: flex; justify-content: space-between; margin: 10px 0px">
                                                    <a href="ReadPost.php?postId=' . $postId . '"><button class="btn">Read More</button></a>
                                                <a href="EditPost.php?postId=' . $postId . '"><button class="btn">Edit Post</button></a>
                                                <a href="DeletePost.php?postId=' . $postId . '"><button class="btn" style="background-color: red;">Delete Post</button></a>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }else {
                        echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>No Posts available.</p>";
                    }
                ?>
                </div>
            </section>

            <section id="pollsSection">
                <h2 class="section-title">Poll</h2>
                <?php
                    $getPolls = "SELECT * FROM polls WHERE studentId = $studentId";
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
                                
                            echo '
                                    <div class="poll-card" style="width: 100%">
                                        <h2 class="section-title">'.$pollTitle.'</h2>
                                        <div class="poll-header" style= "margin-bottom: 0; align-items: flex-start">
                                            <div class="poll-icon"><img src ="Icons/poll.png" style="margin-top: 15px"></div>
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
                                                <a href="DeletePoll.php?pollId=' . $pollId . '"><button class="btn" style="background-color: red; margin-top: 15px">Delete Poll</button></a>
                                            </div>
                                        </div>
                                    </div></br></br>';
                        }
                    }else {
                        echo "<p style='color: white; font-weight: bold; background-color: #007bff;'>No Polls available.</p>";
                    }
                ?>
            </section>
        <?php }?>

        <a href="Logout.php"><button style="width: 100%; color: white; background-color: #007bff; font-weight: bold; margin-bottom: 40px; margin-top: 50px; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer;">Logout</button></a>

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
<?php if($role == "Admin"){?>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
        import { getDatabase, ref, set, push } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-database.js";
        import { getStorage, ref as storageRef, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-storage.js";

        const firebaseConfig = {
            apiKey: "AIzaSyABHAfb8DGfwhTPY__jsgrsv7VRqv0Ei6M",
            authDomain: "bu-drive-236c1.firebaseapp.com",
            databaseURL: "https://bu-drive-236c1-default-rtdb.firebaseio.com",
            projectId: "bu-drive-236c1",
            storageBucket: "bu-drive-236c1.appspot.com",
            messagingSenderId: "998018097892",
            appId: "1:998018097892:web:a015ddc4dd4391d73842f1"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const storage = getStorage(app);

        function RetrieveData() {
            const dbRef = ref(db);
            let coursesContainer = document.querySelector(".courses-container");
            coursesContainer.innerHTML = "";

            get(child(dbRef, "Resource")).then((snapshot) => {
                if (snapshot.exists()) {
                    snapshot.forEach((childSnapshot) => {
                        let resource = childSnapshot.val();
                        let resourceKey = childSnapshot.key;

                        if (resource.adminId == "<?php echo htmlspecialchars($adminId); ?>") {
                            let courseDiv = document.createElement("div");
                            courseDiv.classList.add("courses");

                            let fileUrl = resource.document || resource.audio || resource.video;
                            let fileType = resource.document ? "document" : resource.audio ? "audio" : "video";

                            if (fileUrl) {
                                courseDiv.innerHTML = `
                                    <div><h3>${resource.course}</h3></div>
                                    <a href="${fileUrl}" download>Download Materials</a>
                                    <button class="deleteMaterial" data-key="${resourceKey}" data-url="${fileUrl}" style="background-color: red;">Delete Material</button>
                                `;

                                coursesContainer.appendChild(courseDiv);
                            }
                        }
                    });

                    document.querySelectorAll(".deleteMaterial").forEach(button => {
                        button.addEventListener("click", function () {
                            let resourceKey = this.getAttribute("data-key");
                            let fileUrl = this.getAttribute("data-url");

                            deleteResource(resourceKey, fileUrl);
                        });
                    });

                } else {
                    document.getElementById("empty").style.display = "block";
                }
            }).catch((error) => {
                console.log("Error fetching data:", error);
            });
        }

        function deleteResource(resourceKey, fileUrl) {
            let storageReference = storageRef(storage, fileUrl);

            deleteObject(storageReference).then(() => {
                remove(ref(db, "Resource/" + resourceKey)).then(() => {
                    alert("Resource deleted successfully.");
                    RetrieveData();
                }).catch((error) => {
                    console.log("Error deleting database entry:", error);
                });
            }).catch((error) => {
                console.log("Error deleting file:", error);
            });
        }

        RetrieveData();

    </script>
<?php }?>
<?php if($role == "Student"){?>
    <script>
        let blogsSection = document.getElementById("blogsSection")
        let pollsSection = document.getElementById("pollsSection")
        let blogsBtn = document.getElementById("blogsSectionBtn")
        let pollsBtn = document.getElementById("pollsSectionBtn")

        pollsSection.style.display = "none"
        blogsSection.style.display = "block"

        blogsBtn.addEventListener("click", function(){
            pollsSection.style.display = "none"
            blogsSection.style.display = "block"
        })

        pollsBtn.addEventListener("click", function(){
            pollsSection.style.display = "block"
            blogsSection.style.display = "none"
        })
    </script>
<?php }?>
    <script src="JS/function.js"> </script>

</body>
</html>