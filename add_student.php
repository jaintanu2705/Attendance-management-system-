<?php
include 'config.php';

if(!isset($_SESSION['user'])){
    header('location:index.php');
    exit();
}

if(isset($_POST['add'])){
    $roll = mysqli_real_escape_string($conn, $_POST['roll']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $parent_email = mysqli_real_escape_string($conn, $_POST['parent_email']);

    // Simple validation
    if(!filter_var($parent_email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid parent email address";
    } else {
        // Check duplicate roll
        $check = mysqli_query($conn, "SELECT * FROM students WHERE roll='$roll'");
        if(mysqli_num_rows($check) > 0){
            $error = "Roll number already exists";
        } else {
            mysqli_query($conn, "INSERT INTO students (roll, name, parent_email) VALUES ('$roll', '$name', '$parent_email')");
            header('location:attendance.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Add Student - JD College Attendance</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f7f8;
        margin: 0; padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-box {
        background: white;
        padding: 30px 40px;
        border-radius: 8px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        width: 360px;
    }
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #2c3e50;
    }
    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    button {
        width: 100%;
        padding: 14px;
        background-color: #27ae60;
        border: none;
        border-radius: 6px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #1e8449;
    }
    .error {
        color: red;
        text-align: center;
        margin-bottom: 15px;
    }
    a.back-link {
        display: block;
        margin-bottom: 15px;
        color: #2980b9;
        text-decoration: none;
        font-weight: 600;
    }
    a.back-link:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="form-box">
    <a href="attendance.php" class="back-link">&#8592; Back to Attendance</a>
    <h2>Add New Student</h2>

    <?php if(isset($error)){ ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="post" action="">
        <input type="text" name="roll" placeholder="Roll Number" required autofocus />
        <input type="text" name="name" placeholder="Student Name" required />
        <input type="email" name="parent_email" placeholder="Parent's Email" required />
        <button type="submit" name="add">Add Student</button>
    </form>
</div>

</body>
</html>
