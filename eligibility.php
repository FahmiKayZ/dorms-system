<?php
include("includes/connection.php");

$result = "";

if (isset($_POST['check'])) {
    $studentID = mysqli_real_escape_string($connect, $_POST['studentID']);
    $sql = mysqli_query(
        $connect,
        "SELECT * FROM eligibility WHERE studentID='$studentID'"
    );

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);

        if ($row['status'] == "YES") {
            $result = '
            <div class="alert alert-success" style="margin-top:20px;">
                <h2 style="font-size:1.25rem; font-weight:700; margin-bottom:6px;">' . Icons::check() . ' Eligible</h2>
                <p style="font-size:0.9rem; line-height:1.4;">Congratulations! You are eligible to apply for accommodation. You may now log in to proceed with your room booking application.</p>
            </div>';
        } elseif ($row['status'] == "Pending") {
            $result = '
            <div class="alert" style="margin-top:20px; background:#fff3cd; color:#856404; border-color:#ffeeba;">
                <h2 style="font-size:1.25rem; font-weight:700; margin-bottom:6px;">' . Icons::clock() . ' Pending</h2>
                <p style="font-size:0.9rem; line-height:1.4;">Your eligibility status is currently under review. Please wait for approval from the College Administration Office.</p>
            </div>';
        } elseif ($row['status'] == "NO") {
            $result = '
            <div class="alert alert-error" style="margin-top:20px;">
                <h2 style="font-size:1.25rem; font-weight:700; margin-bottom:6px;">' . Icons::cross() . ' Not Eligible</h2>
                <p style="font-size:0.9rem; line-height:1.4;">Sorry, you are currently not eligible to apply for accommodation. Please contact the College Administration Office for further assistance.</p>
            </div>';
        }
    } else {
        $result = '
        <div class="alert alert-error" style="margin-top:20px;">
            <h2 style="font-size:1.25rem; font-weight:700; margin-bottom:6px;">Student Not Found</h2>
            <p style="font-size:0.9rem;">Please enter a valid, registered Student ID.</p>
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Check Eligibility – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/homepage.css">
<style>
  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: var(--bg);
  }
  .content-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
  }
</style>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-brand">
    <div class="nav-brand-icon"><?php echo Icons::home(24); ?></div>
    <span class="nav-brand-text">D.O.R.M.S<span>.</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="eligibility.php" class="active">Check Eligibility</a></li>
  </ul>
  <div class="nav-actions">
    <a href="login.php" class="btn-login">Log In</a>
    <a href="register.php" class="btn-primary">Register</a>
  </div>
</nav>

<div class="content-wrapper">
  <div class="form-container" style="margin: 0; width: 100%; max-width: 480px;">
    <div class="form-header">
      <h2>Check Eligibility</h2>
      <p style="color:var(--text-muted); font-size:0.9rem;">Enter your student identifier below to check your university accommodation eligibility status.</p>
    </div>

    <form method="POST">
      <div class="form-group">
        <label for="studentID">Student ID</label>
        <input type="text" id="studentID" name="studentID" placeholder="e.g. 2026123456" required autocomplete="off">
      </div>
      <button type="submit" name="check" class="form-submit">Verify Eligibility</button>
      
      <?php echo $result; ?>
    </form>
  </div>
</div>

</body>
</html>