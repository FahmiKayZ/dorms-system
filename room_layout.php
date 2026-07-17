<?php
session_start();

include "includes/connection.php";
$isLoggedIn = isset($_SESSION['user']);
$userName   = $isLoggedIn ? htmlspecialchars($_SESSION['user']['name']) : '';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>College Layout – D.O.R.M.S.</title>
<link rel="icon" type="image/png" href="images/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/homepage.css">
<style>
  /* Room Layout page specific styles */
  .layout-hero {
    max-width: 900px;
    margin: 0 auto;
    padding: 70px 40px 20px;
    text-align: center;
  }
  .layout-hero h1 {
    font-size: 2.6rem;
    font-weight: 800;
    color: var(--text-heading);
    letter-spacing: -0.02em;
    margin-bottom: 12px;
  }
  .layout-hero p {
    font-size: 1.05rem;
    color: var(--text-body);
    line-height: 1.6;
  }
  .layout-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 40px;
  }
  .floor-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px var(--shadow);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .floor-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 158, 96, 0.06);
    border-color: rgba(0, 158, 96, 0.15);
  }
  .floor-card h4 {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--text-heading);
    margin-bottom: 16px;
  }
  .layout-img {
    width: 100%;
    border-radius: 8px;
    border: 1px solid var(--border);
    display: block;
  }
  .back-bottom {
    display: flex;
    justify-content: center;
    margin: 40px 0 20px;
  }
</style>
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar">
  <a href="index.php" class="nav-brand">
    <div class="nav-brand-icon"><?php echo Icons::home(24); ?></div>
    <span class="nav-brand-text">D.O.R.M.S<span>.</span></span>
  </a>

  <ul class="nav-links">
    <li><a href="index.php#features">Features</a></li>
    <li><a href="index.php#steps">How It Works</a></li>
    <li><a href="about.php">About Us</a></li>
    <li><a href="index.php#faq">FAQ</a></li>
  </ul>

  <div class="nav-actions">
    <?php if ($isLoggedIn): ?>
      <div class="user-pill">
        <div class="av"><?= strtoupper(substr($userName,0,1)) ?></div>
        <span><?= $userName ?></span>
      </div>
      <?php if ($_SESSION['user']['role'] === 'student'): ?>
        <a href="dashboard.php" class="btn-ghost">Dashboard</a>
      <?php else: ?>
        <a href="admin_dashboard.php" class="btn-ghost">Admin Panel</a>
      <?php endif; ?>
      <a href="?logout=1" class="btn-logout">Log out</a>
    <?php else: ?>
      <a href="login.php" class="btn-login">Log In</a>
      <a href="register.php" class="btn-primary">Register</a>
    <?php endif; ?>
  </div>
</nav>

<!-- ── LAYOUT HERO ── -->
<section class="layout-hero">
  <span class="hero-eyebrow">UITMKT KOLEJ KERAWANG</span>
  <h1>College Layout</h1>
  <p>Browse the floor plans below to see room arrangements before you book.</p>
</section>

<!-- ── FLOOR PLANS ── -->
<div class="layout-container">

  <div class="floor-card">
    <h4>Ground Floor</h4>
    <img src="images/layout/ground.jpeg" class="layout-img">
  </div>

  <div class="floor-card">
    <h4>Level 1</h4>
    <img src="images/layout/level1.jpg" class="layout-img">
  </div>

  <div class="floor-card">
    <h4>Level 2</h4>
    <img src="images/layout/level2.jpg" class="layout-img">
  </div>

  <div class="floor-card">
    <h4>Level 3 (Sutera Only)</h4>
    <img src="images/layout/level3.jpg" class="layout-img">
  </div>

  <div class="back-bottom">
    <a href="index.php" class="btn-primary"><?php echo Icons::home(18); ?> Back to Home</a>
  </div>

</div>

<footer>
  &copy; <?php echo date('Y'); ?> <span class="brand">D.O.R.M.S.</span> — UITMKT Kolej Kerawang
</footer>

</body>
</html>