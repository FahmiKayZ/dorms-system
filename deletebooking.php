<?php

session_start();
include("includes/connection.php");

$bookingID = $_POST['bookingID'];

/* Ambil roomID sebelum delete */
$getBooking = mysqli_query(
    $connect,
    "SELECT roomID
     FROM booking
     WHERE bookingID='$bookingID'"
);

$bookingData = mysqli_fetch_assoc($getBooking);

$roomID = $bookingData['roomID'];

/* Delete booking */
mysqli_query(
    $connect,
    "DELETE FROM booking
     WHERE bookingID='$bookingID'"
);

/* Kurangkan occupancy */
mysqli_query(
    $connect,
    "UPDATE room
     SET currentOccupancy = currentOccupancy - 1
     WHERE roomID='$roomID'"
);

header("Location: mybooking.php");

?>