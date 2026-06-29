<?php

include 'connection.php';

if(!isset($_GET['id'])){
    die("Ticket not found.");
}

$id = intval($_GET['id']);

$result = mysqli_query($connect,"SELECT * FROM support_tickets WHERE ticket_id=$id");

if(mysqli_num_rows($result)==0){
    die("Ticket not found.");
}

$ticket = mysqli_fetch_assoc($result);

if(isset($_POST['save'])){

    $status = mysqli_real_escape_string($connect,$_POST['status']);

    mysqli_query($connect,"
        UPDATE support_tickets
        SET status='$status'
        WHERE ticket_id=$id
    ");

    header("Location: admin_support.php");

    exit();

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>View Ticket</title>

<link rel="stylesheet" href="css/admin.css">

<style>

body{

    background:#f5f7fb;

    font-family:Arial,Helvetica,sans-serif;

}

.container{

    width:900px;

    margin:50px auto;

}

.ticket{

    background:white;

    border-radius:15px;

    padding:40px;

    box-shadow:0 10px 35px rgba(0,0,0,.08);

}

.ticket h1{

    margin-bottom:30px;

}

.info{

    margin-bottom:22px;

}

.info label{

    display:block;

    font-weight:bold;

    margin-bottom:6px;

}

.info p{

    color:#555;

}

textarea{

    width:100%;

    min-height:160px;

    resize:none;

    padding:15px;

    border-radius:10px;

    border:1px solid #ddd;

    background:#fafafa;

}

select{

    width:220px;

    padding:10px;

    border-radius:8px;

}

button{

    margin-top:25px;

    background:#27ae60;

    color:white;

    border:none;

    padding:12px 26px;

    border-radius:8px;

    cursor:pointer;

    font-size:16px;

}

.back{

    margin-left:12px;

    text-decoration:none;

    color:#555;

}

</style>

</head>

<body>
    <div class="back-button">

    <a href="admin_support.php">

        ← Back to Support Tickets

    </a>

</div>

<div class="container">

<div class="ticket">

<div class="page-header">

<h1>

🎫 Ticket #<?= $ticket['ticket_id']; ?>

</h1>

<p>

View and manage support ticket details.

</p>

</div>

<div class="info">

<label>Student Name</label>
<h2 style="margin-bottom:20px;color:#16a34a;">

👤 Student Information

</h2>

<p><?= $ticket['student_name']; ?></p>

</div>

<div class="info">

<label>Student ID</label>

<p><?= $ticket['student_id']; ?></p>

</div>

<div class="info">

<label>Email</label>

<p><?= $ticket['email']; ?></p>

</div>

<div class="info">

<label>Subject</label>

<p><?= $ticket['subject']; ?></p>

</div>

<div class="info">

<label>Priority</label>

<p>

<?php

$class="low";

if($ticket['priority']=="High"){

    $class="high";

}

elseif($ticket['priority']=="Medium"){

    $class="medium";

}

?>

<span class="priority <?= $class; ?>">

<?= strtoupper($ticket['priority']); ?>

</span>
<p style="margin-top:15px;">

Current Status :

<span class="status

<?php

if($ticket['status']=="Pending"){

echo "pending";

}

elseif($ticket['status']=="In Progress"){

echo "progress";

}

else{

echo "resolved";

}

?>

">

<?= $ticket['status']; ?>

</span>

</p>

</p>

</div>

<div class="info">

<label>Description</label>

<textarea readonly><?= $ticket['message']; ?></textarea>

</div>

<form method="POST">

<div class="info">

<label>Status</label>

<select name="status">

<option <?= $ticket['status']=="Pending"?"selected":""; ?>>Pending</option>

<option <?= $ticket['status']=="In Progress"?"selected":""; ?>>In Progress</option>

<option <?= $ticket['status']=="Resolved"?"selected":""; ?>>Resolved</option>

</select>

</div>

<button name="save">

Save Changes

</button>

<a href="admin_support.php" class="back">

Cancel

</a>

</form>

</div>

</div>

</body>

</html>