<?php
session_start();
include("includes/connection.php");
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!="admin"){ header("Location:index.php"); exit(); }

if(isset($_POST['save'])){
    $roomID=$_POST['roomID'];
    $roomNumber=$_POST['roomNumber'];
    $blockName=$_POST['blockName'];
    $floorLevel=$_POST['floorLevel'];
    $roomCapacity=$_POST['roomCapacity'];

    mysqli_query($connect,"INSERT INTO room(roomID,roomNumber,blockName,floorLevel,roomCapacity,currentOccupancy,roomStatus)
    VALUES('$roomID','$roomNumber','$blockName','$floorLevel','$roomCapacity',0,'Available')");

    header("Location:admin_rooms.php");
    exit();
}
?>
<!DOCTYPE html><html><head><title>Add Room</title>
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
<h1>➕ Add Room</h1>

<div class="form-card">
<form method="POST">

    <div class="form-group">
        <label>Room ID</label>
        <input name="roomID" placeholder="e.g. K201/S201" required>
    </div>

    <div class="form-group">
        <label>Room Number</label>
        <input name="roomNumber" placeholder="e.g. K201/S201" required>
    </div>

    <div class="form-group">
        <label>Block</label>
        <input name="blockName" placeholder="e.g. Kasa/Sutera" required>
    </div>

    <div class="form-group">
        <label>Floor</label>
        <input type="number" name="floorLevel" placeholder="e.g. 3" required>
    </div>

    <div class="form-group">
        <label>Capacity</label>
        <input type="number" name="roomCapacity" value="4" required>
    </div>

    <button type="submit" name="save" class="form-submit-btn">➕ Add Room</button>

</form>
</div>
</div>

</body></html>