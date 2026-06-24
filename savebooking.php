<?php

session_start();
include("connection.php");

$studentID = $_SESSION['studentID'];
$roomID = $_POST['roomID'];

/* CHECK EXISTING BOOKING */

$checkBooking = mysqli_query(
    $connect,
    "SELECT *
     FROM booking
     WHERE studentID='$studentID'"
);

if(mysqli_num_rows($checkBooking) > 0){

    echo "
    <script>
        alert('You already have an active booking.');
        window.location='mybooking.php';
    </script>
    ";

    exit();
}

$getRoom = mysqli_query(
    $connect,
    "SELECT currentOccupancy, roomCapacity
     FROM room
     WHERE roomID='$roomID'"
);

$room = mysqli_fetch_assoc($getRoom);

if($room['currentOccupancy'] >= $room['roomCapacity']){

    echo "
    <script>
    alert('Room is already full.');
    window.location='floorplan.php';
    </script>
    ";

    exit();
}

$sql = "
INSERT INTO booking
(
bookingDate,
bookingStatus,
studentID,
roomID
)
VALUES
(
NOW(),
'Approved',
'$studentID',
'$roomID'
)
";

mysqli_query($connect,$sql);

/* UPDATE OCCUPANCY */
mysqli_query(
    $connect,
    "UPDATE room
     SET currentOccupancy = currentOccupancy + 1
     WHERE roomID='$roomID'"
);

header("Location: mybooking.php");

?>