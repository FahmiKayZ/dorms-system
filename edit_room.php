<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

$id = mysqli_real_escape_string($connect, $_GET['id']);

if (isset($_POST['update'])) {
    $blockName = mysqli_real_escape_string($connect, $_POST['blockName']);
    $floorLevel = (int)$_POST['floorLevel'];
    $roomCapacity = (int)$_POST['roomCapacity'];
    $roomStatus = mysqli_real_escape_string($connect, $_POST['roomStatus']);

    mysqli_query($connect, "UPDATE room SET
        blockName='$blockName',
        floorLevel='$floorLevel',
        roomCapacity='$roomCapacity',
        roomStatus='$roomStatus'
        WHERE roomID='$id'");

    header("Location: admin_rooms.php");
    exit();
}

$row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM room WHERE roomID='$id'"));
if (!$row) {
    die("Room not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Room – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <a href="admin_dashboard.php" class="sidebar-header"><?php echo Icons::dashboard(24); ?> D.O.R.M.S.<span>.</span></a>
  <ul class="sidebar-menu">
    <li><a href="admin_dashboard.php"><?php echo Icons::dashboard(); ?> Dashboard</a></li>
    <li><a href="admin_students.php"><?php echo Icons::users(); ?> Manage Students</a></li>
    <li class="active"><a href="admin_rooms.php"><?php echo Icons::home(); ?> Manage Rooms</a></li>
    <li><a href="admin_eligibility.php"><?php echo Icons::check(); ?> Eligibility Approvals</a></li>
    <li><a href="admin_support.php"><?php echo Icons::ticket(); ?> Support Tickets</a></li>
  </ul>
  <div class="sidebar-footer">
    <a href="index.php?logout=1" class="action-btn btn-delete" style="width:100%; justify-content:center; padding: 10px; display:flex; align-items:center; gap:8px;" onclick="return confirm('Are you sure you want to log out of D.O.R.M.S. Admin?')"><?php echo Icons::logout(); ?> Log Out</a>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="page-header">
    <div>
      <h1 style="display:flex; align-items:center; gap:10px;"><?php echo Icons::edit(28); ?> Edit Room: <?php echo htmlspecialchars($row['roomNumber']); ?></h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Modify room specifications, block placement, bed counts, and occupancy status.</p>
    </div>
    <a href="admin_rooms.php" class="add-btn" style="background:#e9ecef; color:var(--text-heading); border:1px solid var(--border);">← Back to Rooms</a>
  </div>

  <div class="panel" style="max-width: 600px;">
    <form method="POST">
      <div class="form-group">
        <label for="blockName">Block Name</label>
        <select id="blockName" name="blockName" required>
          <option value="Kasa" <?php echo ($row['blockName'] === 'Kasa') ? 'selected' : ''; ?>>Kasa (Male Block)</option>
          <option value="Sutera" <?php echo ($row['blockName'] === 'Sutera') ? 'selected' : ''; ?>>Sutera (Female Block)</option>
        </select>
      </div>

      <div class="form-group">
        <label for="floorLevel">Floor Level</label>
        <input type="number" id="floorLevel" name="floorLevel" min="1" max="10" value="<?php echo htmlspecialchars($row['floorLevel']); ?>" required>
      </div>

      <div class="form-group">
        <label for="roomCapacity">Room Bed Capacity</label>
        <input type="number" id="roomCapacity" name="roomCapacity" min="1" max="8" value="<?php echo htmlspecialchars($row['roomCapacity']); ?>" required>
      </div>

      <div class="form-group">
        <label for="roomStatus">Room Availability Status</label>
        <select id="roomStatus" name="roomStatus" required>
          <option value="Available" <?php echo ($row['roomStatus'] === 'Available') ? 'selected' : ''; ?>>Available</option>
          <option value="Full" <?php echo ($row['roomStatus'] === 'Full') ? 'selected' : ''; ?>>Full</option>
          <option value="Maintenance" <?php echo ($row['roomStatus'] === 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
        </select>
      </div>

      <button type="submit" name="update" class="btn-save" style="width:100%; padding:14px; margin-top:10px; display:flex; align-items:center; justify-content:center; gap:8px;"><?php echo Icons::edit(); ?> Save Changes</button>
    </form>
  </div>
</div>

</body>
</html>