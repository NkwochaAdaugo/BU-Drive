<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Based E-Learning Platform for Babcock Students </title>
    <link rel="stylesheet" href="CSS/SignpUp.css">

</head>
<body>
    <div class="Container"> 
        <h2> Create Poll </h2>
        
        <form id="pollForm" method="post" action="./Poll.php">
            <input type="text" id="pollTitle" name="pTitle" placeholder="Poll Title" required> <br>
            <input type="text" id="option1" name="op1" placeholder="Option 1" required> <br>
            <input type="text" id="option2" name="op2" placeholder="Option 2" required> <br>
            <button type="submit"> Create </button> <br>
        </form>
    </div>

    <script src="JS/function.js"></script>
</body>
</html>