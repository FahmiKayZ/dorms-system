<?php
session_start();

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

include("includes/connection.php");

$studentID = $_SESSION['studentID'];
$sql = "SELECT * FROM booking WHERE studentID='$studentID'";
$result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cancel Booking – D.O.R.M.S.</title>
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
  <a href="mybooking.php" class="btn-logout" style="background:#e9ecef; color:var(--text-body);">← Back</a>
</nav>

<div class="container" style="max-width: 600px;">
  <div class="card" style="border-color: #f5c6cb;">
    <h1 style="font-size: 2rem; font-weight: 800; color: #721c24; text-align: center; margin-bottom: 12px; display:flex; align-items:center; justify-content:center; gap:8px;">
      <?php echo Icons::warning(); ?> Cancel Reservation
    </h1>
    <p style="color: var(--text-muted); text-align: center; font-size: 0.95rem; margin-bottom: 28px;">
      Are you sure you want to cancel your current room allocation? This action cannot be undone.
    </p>

    <?php
    $hasBooking = mysqli_num_rows($result) > 0;
    if ($hasBooking):
      while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="booking-meta" style="grid-template-columns:1fr; gap:16px; margin-bottom:28px; background: #fff8f8; border:1px solid #f5c6cb;">
          <div style="display:flex; justify-content:space-between; align-items:center; padding: 4px 0; border-bottom:1px solid #e9ecef;">
            <span style="font-weight:600; font-size:0.85rem; color:#721c24; text-transform:uppercase;">Room ID</span>
            <strong style="font-size:1.2rem; color:var(--text-heading);">Room <?php echo htmlspecialchars($row['roomID']); ?></strong>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding: 4px 0; border-bottom:1px solid #e9ecef;">
            <span style="font-weight:600; font-size:0.85rem; color:#721c24; text-transform:uppercase;">Bed Number</span>
            <strong style="font-size:1.2rem; color:var(--text-heading);">Bed <?php echo htmlspecialchars($row['bedNumber']); ?></strong>
          </div>
          <div style="display:flex; justify-content:space-between; align-items:center; padding: 4px 0;">
            <span style="font-weight:600; font-size:0.85rem; color:#721c24; text-transform:uppercase;">Status</span>
            <strong style="font-size:1.1rem; color:#721c24; background:#f8d7da; padding: 4px 10px; border-radius:12px;"><?php echo htmlspecialchars($row['bookingStatus']); ?></strong>
          </div>
        </div>

        <form action="deletebooking.php" method="POST" onsubmit="return confirm('Are you absolutely sure you want to cancel this booking? This will release your bed allocation to other students.');">
          <input type="hidden" name="bookingID" value="<?php echo htmlspecialchars($row['bookingID']); ?>">
          <button type="submit" class="btn-logout" style="width:100%; padding:14px; font-size:1.05rem; display:flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; border:none;">
            <?php echo Icons::delete(); ?> Cancel Booking Reservation
          </button>
        </form>
      <?php endwhile; ?>
    <?php else: ?>
      <div style="text-align: center; padding: 20px; color: var(--text-muted);">
        <p style="margin-bottom: 12px; color:var(--bg-nav);"><?php echo Icons::bed(48); ?></p>
        <p style="font-weight: 600; font-size: 1.1rem; margin-bottom: 8px;">You don't have any active booking to cancel.</p>
        <p style="font-size: 0.9rem; margin-bottom: 20px;">Browse available rooms to submit a booking.</p>
        <a href="floorplan.php" class="btn-submit" style="text-decoration:none; display:inline-block;">Browse Rooms</a>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>