<?php
session_start();
include("connection.php");

if(!isset($_SESSION['adminID'])){
    header("Location:index.php");
    exit();
}

if(isset($_GET['search']) && $_GET['search']!=""){

    $search = mysqli_real_escape_string($connect,$_GET['search']);

    $query = "
    SELECT
        student.studentID,
        student.studentName,
        student.studentEmail,
        student.studentGender,
        eligibility.status
    FROM student
    JOIN eligibility
        ON student.studentID = eligibility.studentID
    WHERE eligibility.status='Pending'
      AND (
            student.studentID LIKE '%$search%'
            OR
            student.studentName LIKE '%$search%'
          )
    ORDER BY student.studentName ASC";

}else{

    $query = "
    SELECT
        student.studentID,
        student.studentName,
        student.studentEmail,
        student.studentGender,
        eligibility.status
    FROM student
    JOIN eligibility
        ON student.studentID = eligibility.studentID
    WHERE eligibility.status='Pending'
    ORDER BY student.studentName ASC";

}

$sql = mysqli_query($connect,$query);
?>
<!DOCTYPE html>
<html>

<head>

<title>Eligibility Approval</title>

<link rel="stylesheet" href="css/admin.css">

</head>

<body>

<nav>
    <div class="back-button">

    <a href="admin_dashboard.php">

        ← Back to Dashboard

    </a>

</div>

<h2>D.O.R.M.S Admin</h2>

<div>

Welcome,
<b><?php echo $_SESSION['user']['name']; ?></b>

|

<a href="index.php?logout=1"
   onclick="return confirm('🚪 Are you sure you want to logout?\n\nYou will be returned to the homepage.');">
    Logout
</a>

</div>

</nav>

<div class="container">

<h1>✅ Eligibility Approval</h1>

<form method="GET" class="search-bar">

    <input
        type="text"
        name="search"
        placeholder="🔍 Search by Student ID or Name..."
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

    <button type="submit">

        Search

    </button>

</form>

<table class="student-table">

<tr>
    <th>Student ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Gender</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
while($row=mysqli_fetch_array($sql)){
?>

<tr>

<td><?php echo $row['studentID']; ?></td>

<td><?php echo $row['studentName']; ?></td>

<td><?php echo $row['studentEmail']; ?></td>

<td><?php echo $row['studentGender']; ?></td>

<td>
<span class="pending">
⏳ <?php echo $row['status']; ?>
</span>
</td>

<td>

<?php
if($row['status']=="Pending"){
?>

<a class="approve-btn"
href="approve_student.php?id=<?php echo $row['studentID']; ?>"
onclick="return confirm('✅ Approve this student?\n\nThis student will be allowed to login and book a room.');">
✅ Approve
</a>

<?php
}
else{
    echo "Approved";
}
?>

</td>
</tr>

<?php } ?>

</table>

<?php

if(mysqli_num_rows($sql)==0){

    echo "

    <div style='
        background:white;
        padding:25px;
        border-radius:15px;
        margin-top:20px;
        text-align:center;
        color:#dc2626;
        font-weight:bold;
    '>

    No pending eligibility requests found.

    </div>

    ";

}
?>
</div>
</body>
</html>