<?php
session_start();

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

include("includes/connection.php");

$studentID = $_SESSION['studentID'];

$sql = "
SELECT
    booking.*,
    student.studentName,
    room.blockName,
    room.floorLevel
FROM booking
INNER JOIN student ON booking.studentID = student.studentID
INNER JOIN room ON booking.roomID = room.roomID
WHERE booking.studentID='$studentID'
LIMIT 1
";

$result = mysqli_query($connect,$sql);

if(mysqli_num_rows($result)==0){
    die("No booking found.");
}

$booking = mysqli_fetch_assoc($result);

if($booking['bookingStatus']!="Approved"){
    die("Booking has not been approved yet.");
}

$reference =
"DORMS-KWG-".
date("Ymd",strtotime($booking['bookingDate'])).
"-".
str_pad($booking['bookingID'],5,"0",STR_PAD_LEFT);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Booking Confirmation Slip</title>
        <link rel="stylesheet" href="css/print_booking.css">
        </head>

        <body>
            <div class="slip">
                <div class="header">
                    <img src="images/UiTM-Logo.jpg" alt="UiTM Logo" class="logo">
                    <h2>D.O.R.M.S</h2>
                    <h3>Digital Occupancy & Room Management System</h3>
                    <h1>BOOKING CONFIRMATION SLIP</h1>
                    </div>

                    <hr>
                    <div class="section">
                        <h3>Student Information</h3>
                        <table>
                            <tr>
                                <td>Name</td>
                                <td><?= $booking['studentName']; ?></td>
                                </tr>

                                <tr>
                                    <td>Student ID</td>
                                    <td><?= $booking['studentID']; ?></td>
                                    </tr>
                                    </table>
                                    </div>
                                    <div class="section">
                                        <h3>Accommodation Information</h3>
                                        <table>
                                            <tr>
                                                <td>College</td>
                                                <td>Kerawang</td>
                                                </tr>
                                                <tr>
                                                    <td>Block</td>
                                                    <td><?= $booking['blockName']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Room</td>
                                                        <td><?= $booking['roomID']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bed</td>
                                                            <td><?= $booking['bedNumber']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status</td>
                                                                <td>
                                                                    <b style="color:green;">
                                                                        <?= $booking['bookingStatus']; ?>
                                                                    </b>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Booking Date</td>
                                                                <td><?= date("d F Y",strtotime($booking['bookingDate'])); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Reference No</td>
                                                                <td><?= $reference; ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="signature">
                                                        Officer Signature
                                                        <br><br><br>
                                                        ________________________
                                                        <br>
                                                        D.O.R.M.S Administration
                                                    </div>
                                                    <div class="print">
                                                        <button onclick="window.print()">🖨 Print Slip</button>
                                                    </div>
                                                </div>
                                            </body>
                                            </html>