<?php
include 'config.php';
if(!isset($_SESSION['user'])){
    header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Dashboard - JD College Attendance</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
        color: #2c3e50;
        margin: 0; padding: 0;
        display: flex;
        flex-direction: column;
        height: 100vh;
        justify-content: center;
        align-items: center;
    }
    header {
        position: fixed;
        top: 0; width: 100%;
        background: #34495e;
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    a.logout-btn {
        color: #ecf0f1;
        text-decoration: none;
        border: 2px solid #ecf0f1;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        transition: background-color 0.3s, color 0.3s;
    }
    a.logout-btn:hover {
        background-color: #ecf0f1;
        color: #34495e;
    }
    main {
        margin-top: 80px;
        text-align: center;
        width: 100%;
        max-width: 480px;
    }
    h1 {
        font-size: 2.8rem;
        margin-bottom: 40px;
    }
    button.attendance-btn {
        background: #27ae60;
        color: white;
        font-size: 1.5rem;
        padding: 18px 40px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(39, 174, 96, 0.4);
        transition: background-color 0.3s ease;
    }
    button.attendance-btn:hover {
        background: #1e8449;
    }
</style>
</head>
<body>

<header>
    JD College of Engineering and Management, Nagpur
    <a href="logout.php" class="logout-btn">Logout</a>
</header>

<main>
    <h1>Dashboard</h1>
    <button class="attendance-btn" onclick="location.href='attendance.php'">Attendance System</button>
</main>

</body>
</html>
