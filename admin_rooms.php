<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

$search = '';
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $sql = "
    SELECT * FROM room 
    WHERE roomNumber LIKE '%$search%' 
       OR blockName LIKE '%$search%' 
       OR floorLevel LIKE '%$search%' 
    ORDER BY roomID ASC
    ";
} else {
    $sql = "SELECT * FROM room ORDER BY roomID ASC";
}

$result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Rooms – D.O.R.M.S.</title>
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
      <h1 style="display:flex; align-items:center; gap:10px;"><?php echo Icons::home(28); ?> Manage Rooms</h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Add, edit, or delete student dormitory rooms and track occupancy stats.</p>
    </div>
    <a href="add_room.php" class="add-btn" style="display:flex; align-items:center; gap:6px;"><?php echo Icons::plus(); ?> Add New Room</a>
  </div>

  <div class="panel">
    <!-- Search form -->
    <form method="GET" style="display:flex; gap:12px; margin-bottom:24px;">
      <input type="text" name="search" placeholder="Search by Room Number, Block or Floor Level..." value="<?php echo htmlspecialchars($search); ?>" style="flex:1; padding:12px; border-radius:8px; border:1.5px solid var(--border); font-size:0.95rem; outline:none;">
      <button type="submit" class="add-btn" style="padding:12px 24px;">Search</button>
      <?php if ($search !== ''): ?>
        <a href="admin_rooms.php" class="action-btn btn-edit" style="text-decoration:none; display:flex; align-items:center; padding:12px 18px;">Clear</a>
      <?php endif; ?>
    </form>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Block</th>
            <th>Floor Level</th>
            <th>Capacity</th>
            <th>Occupancy Rate</th>
            <th>Status</th>
            <th style="text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): 
            $isAvailable = ($row['roomStatus'] === 'Available');
          ?>
            <tr>
              <td><strong><?php echo htmlspecialchars($row['roomID']); ?></strong></td>
              <td><?php echo htmlspecialchars($row['roomNumber']); ?></td>
              <td>Block <?php echo htmlspecialchars($row['blockName']); ?></td>
              <td>Level <?php echo htmlspecialchars($row['floorLevel']); ?></td>
              <td><?php echo htmlspecialchars($row['roomCapacity']); ?> Beds</td>
              <td>
                <span style="font-weight:600;"><?php echo htmlspecialchars($row['currentOccupancy']); ?> / <?php echo htmlspecialchars($row['roomCapacity']); ?></span>
                <div style="background:#e9ecef; width:80px; height:6px; border-radius:3px; overflow:hidden; margin-top:4px;">
                  <div style="background:<?php echo ($row['currentOccupancy'] >= $row['roomCapacity']) ? 'var(--danger)' : 'var(--primary)'; ?>; width:<?php echo (intval($row['currentOccupancy']) / intval($row['roomCapacity'])) * 100; ?>%; height:100%;"></div>
                </div>
              </td>
              <td>
                <span class="badge <?php echo $isAvailable ? 'badge-success' : 'badge-danger'; ?>">
                  <?php echo htmlspecialchars($row['roomStatus']); ?>
                </span>
              </td>
              <td style="text-align:right;">
                <a href="edit_room.php?id=<?php echo urlencode($row['roomID']); ?>" class="action-btn btn-edit"><?php echo Icons::edit(); ?> Edit</a>
                <a href="delete_room.php?id=<?php echo urlencode($row['roomID']); ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete room <?php echo htmlspecialchars($row['roomNumber']); ?>?\n\nThis action cannot be undone.');"><?php echo Icons::delete(); ?> Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
      <div style="background:#fff5f5; border:1px solid #fed7d7; padding:24px; border-radius:8px; text-align:center; color:#c53030; font-weight:700; margin-top:20px;">
        ⚠️ No rooms matching the search criteria were found.
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
