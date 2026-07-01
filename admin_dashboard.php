<?php
session_start();
include("includes/connection.php");

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin"){
    header("Location:index.php");
    exit();
}

$adminName = $_SESSION['user']['name'];
?>

<?php

$totalStudents =
mysqli_num_rows(mysqli_query($connect,"SELECT * FROM student"));

$totalRooms =
mysqli_num_rows(mysqli_query($connect,"SELECT * FROM room"));

$pendingEligibility =
mysqli_num_rows(mysqli_query($connect,"SELECT * FROM eligibility WHERE status='Pending'"));

$totalSupport =
mysqli_num_rows(mysqli_query($connect,"SELECT * FROM support_tickets WHERE status='Pending'"));

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>

<link rel="stylesheet" href="css/admin.css">

</head>

<body>
    <nav>

<h2>D.O.R.M.S Admin</h2>

<div>

Welcome,
<b><?php echo $adminName; ?></b>

|

<a href="index.php?logout=1"
   onclick="return confirm('🚪 Are you sure you want to logout?\n\nYou will be returned to the homepage.');">
    Logout
</a>

</div>

</nav>
<div class="container">

<h1>Admin Dashboard</h1>

<div class="cards">

<div class="card">
<h2><?php echo $totalStudents; ?></h2>
<p>Total Students</p>
</div>

<div class="card">
<h2><?php echo $totalRooms; ?></h2>
<p>Total Rooms</p>
</div>

<div class="card">
<h2><?php echo $pendingEligibility; ?></h2>
<p>Pending Eligibility</p>
</div>

<div class="card">
<h2><?php echo $totalSupport; ?></h2>
<p>Support Tickets</p>
</div>

</div>

</div>
<div class="menu">

<div class="menu">

<a href="admin_students.php">
👥 Manage Students
</a>

<a href="admin_rooms.php">
🏠 Manage Rooms
</a>

<a href="admin_eligibility.php">
✅ Eligibility Approval
</a>

<a href="admin_support.php">
🎫 Support Tickets
</a>

</div>

</div>
</body>
</html>