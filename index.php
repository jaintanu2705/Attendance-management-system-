<?php
include 'config.php';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($username == 'admin' && $password == 'admin'){
        $_SESSION['user'] = $username;
        header('location:dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Login - JD College Attendance</title>
<style>
    body { font-family: Arial, sans-serif; background: #f0f4f8; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 320px; }
    h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
    input[type="text"], input[type="password"] { width: 100%; padding: 12px 15px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; }
    button { width: 100%; padding: 12px; background: #2980b9; border: none; border-radius: 5px; color: white; font-size: 16px; cursor: pointer; }
    button:hover { background: #1c5980; }
    .error { color: red; text-align: center; margin-bottom: 15px; }
</style>
</head>
<body>

<div class="login-box">
    <h2>JD College Attendance</h2>
    <?php if(isset($error)){ ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required autofocus />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" name="login">Log In</button>
    </form>
</div>

</body>
</html>
