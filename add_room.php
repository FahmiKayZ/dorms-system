<?php
session_start();
include("connection.php");
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
<div class="container">
<h1>➕ Add Room</h1>
<form method="POST">
<p>Room ID</p><input name="roomID" required><br><br>
<p>Room Number</p><input name="roomNumber" required><br><br>
<p>Block</p><input name="blockName" required><br><br>
<p>Floor</p><input type="number" name="floorLevel" required><br><br>
<p>Capacity</p><input type="number" name="roomCapacity" value="4" required><br><br>
<button type="submit" name="save">Add Room</button>
</form></div></body></html>