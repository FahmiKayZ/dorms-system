<?php
session_start();

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

include("includes/connection.php");

$roomID = $_GET['roomID'] ?? '';
$bedNumber = isset($_GET['bed']) ? (int)$_GET['bed'] : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Booking – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
  <div class="logo"><?php echo Icons::home(24); ?> D.O.R.M.S.</div>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="floorplan.php" class="active">Rooms</a>
    <a href="mybooking.php">My Booking</a>
    <a href="support.php">Support</a>
  </div>
  <a href="room_details.php?room=<?php echo urlencode($roomID); ?>" class="btn-logout" style="background:#e9ecef; color:var(--text-body);">← Back</a>
</nav>

<div class="container" style="max-width:600px;">
  <div class="card">
    <h1 style="font-size:2rem; font-weight:800; text-align:center; margin-bottom:12px;">Confirm Reservation</h1>
    <p style="color:var(--text-muted); text-align:center; font-size:0.95rem; margin-bottom:28px;">
      You are about to book the following bed allocation. Please review the details before confirming.
    </p>

    <div class="booking-meta" style="grid-template-columns:1fr; gap:16px; margin-bottom:28px; background:var(--bg); border:1px solid var(--border);">
      <div style="display:flex; justify-content:space-between; align-items:center; padding: 4px 0; border-bottom:1px solid var(--border);">
        <span style="font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase;">Room Number</span>
        <strong style="font-size:1.2rem; color:var(--text-heading);">Room <?php echo htmlspecialchars($roomID); ?></strong>
      </div>
      <div style="display:flex; justify-content:space-between; align-items:center; padding: 4px 0;">
        <span style="font-weight:600; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase;">Bed Position</span>
        <strong style="font-size:1.2rem; color:var(--text-heading);">Bed <?php echo htmlspecialchars($bedNumber); ?></strong>
      </div>
    </div>

    <div style="background:rgba(0, 158, 96, 0.04); border:1px solid rgba(0, 158, 96, 0.15); padding:16px; border-radius:8px; font-size:0.9rem; color:var(--text-body); margin-bottom:28px; display:flex; align-items:center; gap:8px;">
      <span><?php echo Icons::lightbulb(); ?></span>
      <span><strong>Note:</strong> Once confirmed, this bed reservation will be submitted for administrative approval. You can check the approval status under "My Booking" at any time.</span>
    </div>

    <form action="savebooking.php" method="POST">
      <input type="hidden" name="roomID" value="<?php echo htmlspecialchars($roomID); ?>">
      <input type="hidden" name="bedNumber" value="<?php echo $bedNumber; ?>">
      <button type="submit" class="btn-submit" style="width:100%; padding:14px; font-size:1rem;">Confirm & Book Reservation</button>
    </form>
  </div>
</div>

</body>
</html>