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
<title>About Us – D.O.R.M.S.</title>
<link rel="icon" type="image/png" href="images/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/homepage.css">
<style>
  /* About page specific styles */
  .about-hero {
    max-width: 900px;
    margin: 0 auto;
    padding: 80px 40px 40px;
    text-align: center;
  }
  .about-hero h1 {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--text-heading);
    letter-spacing: -0.02em;
    margin-bottom: 20px;
  }
  .about-hero p {
    font-size: 1.1rem;
    color: var(--text-body);
    max-width: 640px;
    margin: 0 auto;
    line-height: 1.7;
  }
  .about-section {
    max-width: 1100px;
    margin: 80px auto;
    padding: 0 40px;
  }
  .about-section h2 {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-heading);
    text-align: center;
    margin-bottom: 40px;
    letter-spacing: -0.02em;
  }
  .mission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
  }
  .mission-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 36px 30px;
    box-shadow: 0 4px 20px var(--shadow);
  }
  .mission-card h3 {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--bg-nav);
    margin-bottom: 12px;
  }
  .mission-card p {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
  }
  .info-strip {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 40px;
    box-shadow: 0 4px 20px var(--shadow);
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
    text-align: center;
  }
  .info-strip div h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-heading);
    margin-bottom: 6px;
  }
  .info-strip div p {
    font-size: 0.9rem;
    color: var(--text-muted);
  }
  .back-home {
    display: flex;
    justify-content: center;
    margin: 60px 0 20px;
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

<!-- ── ABOUT HERO ── -->
<section class="about-hero">
  <span class="hero-eyebrow">UITMKT KOLEJ KERAWANG</span>
  <h1>About D.O.R.M.S.</h1>
  <p>
    D.O.R.M.S. (Digital Occupancy And Room Management System) was built to make
    campus accommodation simple, transparent, and accessible for every student.
    From checking eligibility to booking a room and tracking approval status,
    everything is handled online — no more long queues or paper forms.
  </p>
</section>

<!-- ── MISSION / VISION ── -->
<section class="about-section">
  <h2>Our Mission</h2>
  <div class="mission-grid">
    <div class="mission-card">
      <h3>Simplify</h3>
      <p>Replace manual, paper-based room applications with a fast, guided online process students can complete in minutes.</p>
    </div>
    <div class="mission-card">
      <h3>Centralize</h3>
      <p>Give students and administrators one shared platform to manage rooms, applications, and support requests.</p>
    </div>
    <div class="mission-card">
      <h3>Improve Access</h3>
      <p>Make eligibility checks and room availability transparent, so every student knows exactly where they stand.</p>
    </div>
  </div>
</section>

<!-- ── SYSTEM INFO ── -->
<section class="about-section">
  <h2>The System</h2>
  <div class="info-strip">
    <div>
      <h4>Built For</h4>
      <p>UITMKT Kolej Kerawang students</p>
    </div>
    <div>
      <h4>Access</h4>
      <p>Available online, 24/7</p>
    </div>
    <div>
      <h4>Support</h4>
      <p>Guest support tickets for any issue</p>
    </div>
  </div>
</section>

<div class="back-home">
  <a href="index.php" class="btn-ghost"><?php echo Icons::home(18); ?> Back to Home</a>
</div>

<footer>
  &copy; <?php echo date('Y'); ?> <span class="brand">D.O.R.M.S.</span> — UITMKT Kolej Kerawang
</footer>

</body>
</html>