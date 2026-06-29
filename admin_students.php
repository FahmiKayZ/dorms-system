<?php
session_start();
include("connection.php");

if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location:index.php");
    exit();
}

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = mysqli_real_escape_string($connect,$_GET['search']);

    $sql = "SELECT *
            FROM student
            WHERE studentID LIKE '%$search%'
            OR studentName LIKE '%$search%'
            ORDER BY studentName";
}
else
{
    $sql = "SELECT *
            FROM student
            ORDER BY studentName";
}

$result = mysqli_query($connect,$sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Students</title>

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

<h1>👥 Manage Students</h1>
<form method="GET" style="margin-bottom:20px; display:flex; gap:10px;">

    <input
        type="text"
        name="search"
        placeholder="Search by Student ID or Name..."
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
        style="
            width:320px;
            padding:10px 15px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:15px;
        ">

    <button
        type="submit"
        style="
            background:#16a34a;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:8px;
            cursor:pointer;
        ">
        🔍 Search
    </button>

</form>
<table class="student-table">

<tr>

<th>Student ID</th>
<th>Name</th>
<th>Email</th>
<th>Gender</th>
<th>Eligibility</th>
<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result)){

    $studentID=$row['studentID'];

    $check=mysqli_query($connect,"
    SELECT status
    FROM eligibility
    WHERE studentID='$studentID'
    ");

    $status="Pending";

    if(mysqli_num_rows($check)>0){

        $elig=mysqli_fetch_assoc($check);

        $status=$elig['status'];

    }

?>

<tr>

<td><?php echo $row['studentID']; ?></td>

<td><?php echo $row['studentName']; ?></td>

<td><?php echo $row['studentEmail']; ?></td>

<td><?php echo $row['studentGender']; ?></td>

<td>

<?php

if($status=="YES"){

    echo "<span class='yes'>Approved</span>";

}elseif($status=="NO"){

    echo "<span class='no'>Rejected</span>";

}else{

    echo "<span class='pending'>Pending</span>";

}

?>

</td>

<td>

<a href="delete_student.php?id=<?php echo $row['studentID']; ?>"
   class="delete-btn"
   onclick="return confirm('⚠️ Are you sure you want to delete this student?\n\nThis action cannot be undone.');">
    🗑 Delete
</a>

</td>

</tr>

<?php
}
?>
<?php

if(mysqli_num_rows($result)==0)
{
    echo "<p style='text-align:center;color:red;font-weight:bold;margin-top:20px;'>
    No student found.
    </p>";
}

?>
</table>

</div>

</body>
</html>