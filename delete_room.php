<?php
include("connection.php");
$id=$_GET['id'];
mysqli_query($connect,"DELETE FROM room WHERE roomID='$id'");
header("Location:admin_rooms.php");
exit();
?>