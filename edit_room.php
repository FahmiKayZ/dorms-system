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
<div class="container"><h1>✏️ Edit Room</h1>
<form method="POST">
<p>Block</p><input name="blockName" value="<?php echo $row['blockName'];?>"><br><br>
<p>Floor</p><input type="number" name="floorLevel" value="<?php echo $row['floorLevel'];?>"><br><br>
<p>Capacity</p><input type="number" name="roomCapacity" value="<?php echo $row['roomCapacity'];?>"><br><br>
<p>Status</p>
<select name="roomStatus">
<option <?php if($row['roomStatus']=="Available") echo "selected";?>>Available</option>
<option <?php if($row['roomStatus']=="Full") echo "selected";?>>Full</option>
<option <?php if($row['roomStatus']=="Maintenance") echo "selected";?>>Maintenance</option>
</select><br><br>
<button name="update">Save Changes</button>
</form></div></body></html>