<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

$totalTickets = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM support_tickets"));
$totalPending = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM support_tickets WHERE status='Pending'"));
$totalProgress = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM support_tickets WHERE status='In Progress'"));
$totalResolved = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM support_tickets WHERE status='Resolved'"));
$totalHigh = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM support_tickets WHERE priority='High'"));

$search = '';
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $result = mysqli_query($connect, "
        SELECT * FROM support_tickets 
        WHERE student_name LIKE '%$search%' 
           OR student_id LIKE '%$search%' 
           OR subject LIKE '%$search%' 
        ORDER BY created_at DESC
    ");
} else {
    $result = mysqli_query($connect, "SELECT * FROM support_tickets ORDER BY created_at DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Support Tickets – D.O.R.M.S.</title>
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
    <li><a href="admin_rooms.php"><?php echo Icons::home(); ?> Manage Rooms</a></li>
    <li><a href="admin_eligibility.php"><?php echo Icons::check(); ?> Eligibility Approvals</a></li>
    <li class="active"><a href="admin_support.php"><?php echo Icons::ticket(); ?> Support Tickets</a></li>
  </ul>
  <div class="sidebar-footer">
    <a href="index.php?logout=1" class="action-btn btn-delete" style="width:100%; justify-content:center; padding: 10px; display:flex; align-items:center; gap:8px;" onclick="return confirm('Are you sure you want to log out of D.O.R.M.S. Admin?')"><?php echo Icons::logout(); ?> Log Out</a>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="page-header">
    <div>
      <h1 style="display:flex; align-items:center; gap:10px;"><?php echo Icons::ticket(28); ?> Support Ticket Management</h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Review, prioritize, and reply to student and guest support tickets.</p>
    </div>
  </div>

  <!-- STATS GRID -->
  <div class="stats-grid" style="margin-bottom: 30px;">
    <div class="stat-card">
      <div class="stat-info">
        <h3>Pending</h3>
        <p><?php echo $totalPending; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--warning);"><?php echo Icons::clock(36); ?></div>
    </div>
    
    <div class="stat-card">
      <div class="stat-info">
        <h3>In Progress</h3>
        <p><?php echo $totalProgress; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--info);"><?php echo Icons::gear(36); ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <h3>Resolved</h3>
        <p><?php echo $totalResolved; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--success);"><?php echo Icons::check(36); ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <h3>High Priority</h3>
        <p><?php echo $totalHigh; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--danger);"><?php echo Icons::fire(36); ?></div>
    </div>
  </div>

  <div class="panel">
    <!-- Search Form -->
    <form method="GET" style="display:flex; gap:12px; margin-bottom:24px;">
      <input type="text" name="search" placeholder="Search by Student Name, ID, or Ticket Subject..." value="<?php echo htmlspecialchars($search); ?>" style="flex:1; padding:12px; border-radius:8px; border:1.5px solid var(--border); font-size:0.95rem; outline:none;">
      <button type="submit" class="add-btn" style="padding:12px 24px;">Search</button>
      <?php if ($search !== ''): ?>
        <a href="admin_support.php" class="action-btn btn-edit" style="text-decoration:none; display:flex; align-items:center; padding:12px 18px;">Clear</a>
      <?php endif; ?>
    </form>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Ticket ID</th>
            <th>Requester Name</th>
            <th>Student ID</th>
            <th>Subject</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Created At</th>
            <th style="text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): 
            $status = $row['status'];
            $priority = $row['priority'];
            $statusBadge = 'badge-warning';
            if ($status === 'In Progress') $statusBadge = 'badge-info';
            if ($status === 'Resolved') $statusBadge = 'badge-success';

            $priorityBadge = 'badge-success';
            if ($priority === 'Medium') $priorityBadge = 'badge-warning';
            if ($priority === 'High') $priorityBadge = 'badge-danger';
          ?>
            <tr>
              <td><strong>#<?php echo htmlspecialchars($row['ticket_id']); ?></strong></td>
              <td><?php echo htmlspecialchars($row['student_name']); ?></td>
              <td><?php echo htmlspecialchars($row['student_id'] ? $row['student_id'] : 'Guest'); ?></td>
              <td><?php echo htmlspecialchars($row['subject']); ?></td>
              <td><span class="badge <?php echo $priorityBadge; ?>"><?php echo htmlspecialchars($priority); ?></span></td>
              <td><span class="badge <?php echo $statusBadge; ?>"><?php echo htmlspecialchars($status); ?></span></td>
              <td style="font-size:0.85rem; color:var(--text-muted);"><?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
              <td style="text-align:right;">
                <a href="view_ticket.php?id=<?php echo urlencode($row['ticket_id']); ?>" class="action-btn btn-resolve"><?php echo Icons::eye(); ?> View & Reply</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
      <div style="background:#fff5f5; border:1px solid #fed7d7; padding:24px; border-radius:8px; text-align:center; color:#c53030; font-weight:700; margin-top:20px; display:flex; align-items:center; justify-content:center; gap:8px;">
        <?php echo Icons::warning(); ?> No support tickets matching the search criteria were found.
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>