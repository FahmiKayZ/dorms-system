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
    $sql = "SELECT * FROM student 
            WHERE studentID LIKE '%$search%' 
               OR studentName LIKE '%$search%' 
            ORDER BY studentName";
} else {
    $sql = "SELECT * FROM student ORDER BY studentName";
}

$result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Students – D.O.R.M.S.</title>
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
    <li class="active"><a href="admin_students.php"><?php echo Icons::users(); ?> Manage Students</a></li>
    <li><a href="admin_rooms.php"><?php echo Icons::home(); ?> Manage Rooms</a></li>
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
      <h1 style="display:flex; align-items:center; gap:10px;"><?php echo Icons::users(28); ?> Manage Students</h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Search and manage registered students and verify their college eligibility status.</p>
    </div>
  </div>

  <div class="panel">
    <!-- Search Form -->
    <form method="GET" style="display:flex; gap:12px; margin-bottom:24px;">
      <input type="text" name="search" placeholder="Search by Student ID or Name..." value="<?php echo htmlspecialchars($search); ?>" style="flex:1; padding:12px; border-radius:8px; border:1.5px solid var(--border); font-size:0.95rem; outline:none;">
      <button type="submit" class="add-btn" style="padding:12px 24px;">Search</button>
      <?php if ($search !== ''): ?>
        <a href="admin_students.php" class="action-btn btn-edit" style="text-decoration:none; display:flex; align-items:center; padding:12px 18px;">Clear</a>
      <?php endif; ?>
    </form>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Eligibility Status</th>
            <th style="text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): 
            $studentID = $row['studentID'];
            $check = mysqli_query($connect, "SELECT status FROM eligibility WHERE studentID='$studentID'");
            $status = "Pending";
            if (mysqli_num_rows($check) > 0) {
                $elig = mysqli_fetch_assoc($check);
                $status = $elig['status'];
            }
          ?>
            <tr>
              <td><strong><?php echo htmlspecialchars($row['studentID']); ?></strong></td>
              <td><?php echo htmlspecialchars($row['studentName']); ?></td>
              <td><?php echo htmlspecialchars($row['studentEmail']); ?></td>
              <td><?php echo htmlspecialchars($row['studentGender']); ?></td>
              <td>
                <?php if ($status === 'YES'): ?>
                  <span class="badge badge-success">Approved</span>
                <?php elseif ($status === 'NO'): ?>
                  <span class="badge badge-danger">Rejected</span>
                <?php else: ?>
                  <span class="badge badge-warning">Pending</span>
                <?php endif; ?>
              </td>
              <td style="text-align:right;">
                <a href="delete_student.php?id=<?php echo urlencode($row['studentID']); ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete student <?php echo htmlspecialchars($row['studentName']); ?>?\n\nThis will remove their profile and booking record.');"><?php echo Icons::delete(); ?> Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
      <div style="background:#fff5f5; border:1px solid #fed7d7; padding:24px; border-radius:8px; text-align:center; color:#c53030; font-weight:700; margin-top:20px;">
        ⚠️ No students matching the search criteria were found.
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>