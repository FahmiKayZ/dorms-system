<?php
session_start();
include("connection.php");
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){ header("Location:index.php"); exit(); }

$id=$_GET['id'];
if(isset($_POST['update'])){
mysqli_query($connect,"UPDATE room SET
blockName='".$_POST['blockName']."',
floorLevel='".$_POST['floorLevel']."',
roomCapacity='".$_POST['roomCapacity']."',
roomStatus='".$_POST['roomStatus']."'
WHERE roomID='$id'");
header("Location:admin_rooms.php"); exit();
}
$row=mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM room WHERE roomID='$id'"));
?>
<!DOCTYPE html><html><head><title>Edit Room</title>
<link rel="stylesheet" href="css/admin.css"></head><body>

<nav>
    <div class="back-button">
        <a href="admin_rooms.php">← Back to Manage Rooms</a>
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
<h1>✏️ Edit Room — <?php echo $row['roomID']; ?></h1>

<div class="form-card">
<form method="POST">

    <div class="form-group">
        <label>Block</label>
        <input name="blockName" value="<?php echo $row['blockName'];?>">
    </div>

    <div class="form-group">
        <label>Floor</label>
        <input type="number" name="floorLevel" value="<?php echo $row['floorLevel'];?>">
    </div>

    <div class="form-group">
        <label>Capacity</label>
        <input type="number" name="roomCapacity" value="<?php echo $row['roomCapacity'];?>">
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="roomStatus">
            <option <?php if($row['roomStatus']=="Available") echo "selected";?>>Available</option>
            <option <?php if($row['roomStatus']=="Full") echo "selected";?>>Full</option>
            <option <?php if($row['roomStatus']=="Maintenance") echo "selected";?>>Maintenance</option>
        </select>
    </div>

    <button name="update" class="form-submit-btn">💾 Save Changes</button>

</form>
</div>
</div>

</body></html>