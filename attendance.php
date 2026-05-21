<?php
include 'config.php';

if(!isset($_SESSION['user'])){
    header('location:index.php');
    exit();
}

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

$date = date("Y-m-d");

// Save Attendance
if(isset($_POST['save'])){
    mysqli_query($conn,"DELETE FROM attendance WHERE date='$date'");

    foreach($_POST['status'] as $id => $s){
        mysqli_query($conn,"INSERT INTO attendance VALUES(NULL,'$id','$date','$s')");
    }

    echo "<script>alert('Attendance saved successfully');</script>";
}

// Send Email to Yourself for Selected Absent Students
if(isset($_POST['send_email'])){
    $messageTemplate = $_POST['message'];
    
    if(!empty($_POST['send_to'])){
        foreach($_POST['send_to'] as $student_id){
            $student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE id='$student_id'"));

            $mail = new PHPMailer(true);
            try{
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jaintanu2473@gmail.com';  // Your Gmail for sending
                $mail->Password = 'leheegpzflpprucy';       // Your Gmail App password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('jaintanu2473@gmail.com', 'JD College Attendance');
                $mail->addAddress('jaintanu2473@gmail.com'); // **Your email receives the absent students**
                $mail->isHTML(true);
                $mail->Subject = 'Absent Student Alert - ' . date('d M Y');

                // Replace placeholder [STUDENT_NAME] with actual student name
                $customMessage = str_replace('[STUDENT_NAME]', $student['name'], $messageTemplate);

                $mail->Body = $customMessage;

                $mail->send();
            }catch(Exception $e){
                echo "<script>alert('Failed to send email for {$student['name']}: {$mail->ErrorInfo}');</script>";
            }
        }
        echo "<script>alert('Email(s) sent successfully to your inbox');</script>";
    } else {
        echo "<script>alert('Please select at least one absent student');</script>";
    }
}

// Fetch students and today's attendance
$students = mysqli_query($conn,"SELECT * FROM students ORDER BY roll ASC");
$attendances = [];
$result = mysqli_query($conn,"SELECT * FROM attendance WHERE date='$date'");
while($row = mysqli_fetch_assoc($result)){
    $attendances[$row['student_id']] = $row['status'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Attendance - JD College</title>
<style>
body {font-family: Arial,sans-serif; background:#f4f7f8; margin:0; padding:0;}
header {background:#34495e; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center;}
a.back-btn {color:white; text-decoration:none; border:2px solid white; padding:6px 14px; border-radius:5px;}
main {max-width:900px; margin:40px auto; background:white; padding:30px; border-radius:8px;}
table {width:100%; border-collapse:collapse; margin-bottom:20px;}
th, td {border:1px solid #ccc; padding:12px; text-align:center;}
th {background:#27ae60; color:white;}
input[type=radio], input[type=checkbox] {transform:scale(1.2);}
textarea {width:100%; padding:12px; margin-bottom:15px; border-radius:5px; border:1px solid #ccc;}
button {padding:12px 30px; background:#2980b9; color:white; border:none; border-radius:6px; cursor:pointer; margin-right:10px;}
button:hover {background:#1c5980;}
</style>
</head>
<body>

<header>
    <a href="dashboard.php" class="back-btn">&#8592; Back</a>
    Attendance System
</header>

<main>
<h1>Attendance - <?= date('d M Y') ?></h1>

<form method="post" action="">
<table>
<thead>
<tr>
<th>Roll</th><th>Name</th><th>Present</th><th>Absent</th><th>Send Email?</th>
</tr>
</thead>
<tbody>
<?php while($student = mysqli_fetch_assoc($students)){
    $status = $attendances[$student['id']] ?? 'Present';
?>
<tr>
<td><?= htmlspecialchars($student['roll']) ?></td>
<td><?= htmlspecialchars($student['name']) ?></td>
<td><input type="radio" name="status[<?= $student['id'] ?>]" value="Present" <?= $status=='Present'?'checked':'' ?>></td>
<td><input type="radio" name="status[<?= $student['id'] ?>]" value="Absent" <?= $status=='Absent'?'checked':'' ?>></td>
<td>
    <?php if($status=='Absent'){ ?>
        <input type="checkbox" name="send_to[]" value="<?= $student['id'] ?>" checked>
    <?php } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>

<button type="submit" name="save">Save Attendance</button>

<h3>Send Email to Yourself for Selected Absent Students</h3>
<p>Use [STUDENT_NAME] in your message to insert the student’s name.</p>
<textarea name="message" required>Dear Parent, your child [STUDENT_NAME] was absent today in JD College.</textarea><br>
<button type="submit" name="send_email">Send Email</button>
</form>

</main>
</body>
</html>
