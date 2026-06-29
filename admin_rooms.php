<?php
session_start();
include("connection.php");

if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){
    header("Location:index.php");
    exit();
}

if(isset($_GET['search']) && $_GET['search']!=""){

    $search = mysqli_real_escape_string($connect,$_GET['search']);

    $sql = "
    SELECT *
    FROM room
    WHERE
        roomNumber LIKE '%$search%'
        OR
        blockName LIKE '%$search%'
        OR
        floorLevel LIKE '%$search%'
    ORDER BY roomID ASC
    ";

}else{

    $sql = "
    SELECT *
    FROM room
    ORDER BY roomID ASC
    ";

}

$result = mysqli_query($connect,$sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Rooms</title>
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
Welcome, <b><?php echo $_SESSION['user']['name']; ?></b> |
<a href="index.php?logout=1"
   onclick="return confirm('🚪 Are you sure you want to logout?\n\nYou will be returned to the homepage.');">
    Logout
</a>
</div>
</nav>

<div class="container">
<h1>🏠 Manage Rooms</h1>

<form method="GET" class="search-bar">

    <input
        type="text"
        name="search"
        placeholder="🔍 Search by Room Number, Block or Floor..."
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

    <button type="submit">

        Search

    </button>

</form>

<div style="margin-bottom:20px;">

    <a href="add_room.php" class="add-btn">
        ➕ Add Room
    </a>

</div>

<table class="student-table">
<tr>
<th>Room ID</th>
<th>Room No.</th>
<th>Block</th>
<th>Floor</th>
<th>Capacity</th>
<th>Occupied</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['roomID']; ?></td>
<td><?php echo $row['roomNumber']; ?></td>
<td><?php echo $row['blockName']; ?></td>
<td><?php echo $row['floorLevel']; ?></td>
<td><?php echo $row['roomCapacity']; ?></td>
<td>

<?php echo $row['currentOccupancy']; ?>

/

<?php echo $row['roomCapacity']; ?>

</td>
<td>
<?php
if($row['roomStatus']=="Available"){
echo "<span class='yes'>Available</span>";
}elseif($row['roomStatus']=="Full"){
echo "<span class='pending'>Full</span>";
}else{
echo "<span class='no'>".$row['roomStatus']."</span>";
}
?>
</td>
<td>
<a href="edit_room.php?id=<?php echo $row['roomID']; ?>" class="edit-btn">✏️ Edit</a>
<a href="delete_room.php?id=<?php echo $row['roomID']; ?>" class="delete-btn" onclick="return confirm('⚠️ Are you sure you want to delete this room?\n\nThis action cannot be undone.');">🗑 Delete</a>
</td>
</tr>
<?php } ?>
</table>
<?php

if(mysqli_num_rows($result)==0){

    echo "

    <div style='
        background:white;
        padding:25px;
        border-radius:15px;
        text-align:center;
        color:#dc2626;
        font-weight:bold;
        margin-top:20px;
    '>

    No rooms found.

    </div>

    ";

}

?>
</div>
</body>
</html>
