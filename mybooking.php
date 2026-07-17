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
    room.blockName, 
    room.floorLevel 
FROM booking 
INNER JOIN room ON booking.roomID = room.roomID 
WHERE booking.studentID='$studentID'
";
$result = mysqli_query($connect, $sql);
$booking = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Booking – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
  <div class="logo"><?php echo Icons::home(24); ?> D.O.R.M.S.</div>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="floorplan.php">Rooms</a>
    <a href="mybooking.php" class="active">My Booking</a>
    <a href="support.php">Support</a>
  </div>
  <a href="dashboard.php" class="btn-logout" style="background:#e9ecef; color:var(--text-body);">← Back to Dashboard</a>
</nav>

<div class="container" style="max-width: 680px;">
  <div class="card">
    <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 8px;">My Current Booking</h1>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 28px;">
      View reservation info, block details, and approval status for your accommodation.
    </p>

    <?php if ($booking): ?>
      <div class="booking-summary-card">
        <h2 style="font-size: 1.4rem; font-weight:700; border-bottom:1px solid var(--border); padding-bottom:12px; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
          <?php echo Icons::home(); ?> Room <?php echo htmlspecialchars($booking['roomID']); ?>
        </h2>
        
        <div class="booking-meta" style="margin-bottom: 28px;">
          <div>
            <span>Bed Position</span>
            <strong>Bed <?php echo htmlspecialchars($booking['bedNumber']); ?></strong>
          </div>
          <div>
            <span>Block</span>
            <strong><?php echo htmlspecialchars($booking['blockName']); ?> Block</strong>
          </div>
          <div>
            <span>Floor Level</span>
            <strong>Level <?php echo htmlspecialchars($booking['floorLevel']); ?></strong>
          </div>
          <div>
            <span>Status</span>
            <strong>
              <?php
              $status = $booking['bookingStatus'];
              if ($status === 'Approved') {
                  echo "<span class='status-available'>Approved</span>";
              } elseif ($status === 'Pending') {
                  echo "<span class='status-full' style='background:#fff3cd; color:#856404;'>Pending</span>";
              } else {
                  echo "<span class='status-full'>Cancelled</span>";
              }
              ?>
            </strong>
          </div>
        </div>

        <div style="font-size: 0.9rem; color: var(--text-muted); border-top: 1px solid var(--border); padding-top: 20px; display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
          <span>Reserved On:</span>
          <strong><?php echo date("d M Y, h:i A", strtotime($booking['bookingDate'])); ?></strong>
        </div>

        <?php if ($booking['bookingStatus'] == "Approved"): ?>

        <div style="margin-bottom:20px; text-align:right;">
          <a href="print_booking.php?id=<?php echo $booking['bookingID']; ?>"
          class="btn-submit"
          style="text-decoration:none; padding:12px 24px;">🖨 Print Booking Slip</a>
        </div> 
        <?php endif; ?>

        <div style="display:flex; justify-content:flex-end;">
          <a href="cancelbooking.php" class="btn-logout" style="padding: 12px 24px; text-decoration:none; text-align:center;">Cancel Reservation</a>
        </div>
      </div>
    <?php else: ?>
      <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
        <p style="margin-bottom: 16px; color: var(--bg-nav);"><?php echo Icons::bed(48); ?></p>
        <h3 style="font-weight: 700; font-size: 1.2rem; color: var(--text-heading); margin-bottom: 8px;">No Accommodation Booking Found</h3>
        <p style="font-size: 0.95rem; margin-bottom: 28px; max-width: 400px; margin-left: auto; margin-right: auto;">
          You do not have an active room allocation or request. Secure your spot in the residential college now.
        </p>
        <a href="floorplan.php" class="btn-submit" style="text-decoration:none; display:inline-block; padding: 12px 28px;">Browse Available Rooms</a>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>