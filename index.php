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
<title>D.O.R.M.S. – Digital Occupancy And Room Management System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/homepage.css">
<style>
  /* Extra page specific styles */
  .step-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }
  .step {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    padding: 30px 20px;
    border-radius: var(--radius);
    text-align: center;
    box-shadow: 0 4px 15px var(--shadow);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }
  .step span {
    width: 40px;
    height: 40px;
    background: var(--bg-nav);
    color: var(--white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.1rem;
  }
  .step h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-heading);
  }
  .step p {
    font-size: 0.9rem;
    color: var(--text-muted);
  }
  .faq-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 800px;
    margin: 40px auto 0 auto;
  }
  .faq-item {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    padding: 24px;
    border-radius: var(--radius);
    box-shadow: 0 4px 10px var(--shadow);
  }
  .faq-item h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-heading);
    margin-bottom: 8px;
  }
  .faq-item p {
    font-size: 0.95rem;
    color: var(--text-body);
  }
  .support-section {
    max-width: 800px;
    margin: 80px auto;
    padding: 40px;
    background: linear-gradient(135deg, rgba(0, 158, 96, 0.05) 0%, rgba(78, 202, 110, 0.05) 100%);
    border: 1px solid rgba(0, 158, 96, 0.15);
    border-radius: var(--radius);
    text-align: center;
    box-shadow: 0 4px 20px var(--shadow);
  }
  .support-section h2 {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--text-heading);
    margin-bottom: 12px;
  }
  .support-section p {
    font-size: 1.05rem;
    color: var(--text-body);
    margin-bottom: 24px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }
  .stats-bar {
    background: var(--bg-surface);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 40px 0;
    margin-top: 80px;
  }
  .stats {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    text-align: center;
  }
  .stat-item h3 {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--bg-nav);
    margin-bottom: 4px;
  }
  .stat-item p {
    font-size: 0.9rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
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
    <li><a href="#features">Features</a></li>
    <li><a href="#steps">How It Works</a></li>
    <li><a href="#faq">FAQ</a></li>
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

<!-- ── HERO ── -->
<section class="hero">
  <div class="hero-content">
    <span class="hero-eyebrow">KOLEJ KERAWANG</span>

    <h1 class="hero-headline">
      Your Home,<br>
      at a better <em>Place.</em>
    </h1>

    <p class="hero-body">
      Book, manage, and track your university room entirely online.
      Simple applications, instant confirmations, and real-time room availability — all in one place.
    </p>

    <div class="hero-cta">
      <?php if ($isLoggedIn): ?>
        <a href="dashboard.php" class="btn-primary">Book a Room</a>
      <?php else: ?>
        <a href="login.php" class="btn-primary">Book a Room</a>
      <?php endif; ?>
      <a href="eligibility.php" class="btn-ghost">Check Eligibility</a>
    </div>
  </div>

  <div class="hero-visual">
    <div class="img-cluster">
      <div class="floating-card card-one">
        <span><?php echo Icons::bed(32); ?></span>
        <h4>200+ Rooms</h4>
        <p>Available</p>
      </div>

      <div class="floating-card card-two">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></span>
        <h4>Fast Booking</h4>
        <p>Less than 2 Minutes</p>
      </div>

      <div class="floating-card card-three">
        <span><?php echo Icons::shield(32); ?></span>
        <h4>Secure System</h4>
        <p>Safe & Reliable</p>
      </div>
      
      <div class="img-card img-secondary">
        <div class="img-placeholder">
          <div style="color: var(--primary);"><?php echo Icons::dashboard(60); ?></div>
          <strong>D.O.R.M.S.</strong>
          <small>Modern Dormitory</small>
        </div>
      </div>

      <div class="img-card img-main">
        <div class="img-placeholder">
          <div style="color: var(--primary);"><?php echo Icons::home(80); ?></div>
          <strong>Accommodation</strong>
          <small>Fast • Secure • Easy</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Why Choose D.O.R.M.S. ── -->
<section id="features" class="features">
  <h2>Why Choose D.O.R.M.S.</h2>
  <div class="feature-grid">
    <div class="feature-card">
      <div class="icon" style="color: var(--bg-nav);"><?php echo Icons::dashboard(40); ?></div>
      <h3>Real-Time Availability</h3>
      <p>View room occupancy levels and floor plans instantly before making a booking.</p>
    </div>

    <div class="feature-card">
      <div class="icon" style="color: var(--bg-nav);"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
      <h3>Fast Booking</h3>
      <p>Book your bed space online within minutes without long queue and paperwork.</p>
    </div>

    <div class="feature-card">
      <div class="icon" style="color: var(--bg-nav);"><?php echo Icons::shield(40); ?></div>
      <h3>Secure System</h3>
      <p>Your booking information is protected and securely stored in our system.</p>
    </div>

    <div class="feature-card">
      <div class="icon" style="color: var(--bg-nav);"><?php echo Icons::check(40); ?></div>
      <h3>Easy Management</h3>
      <p>Track your approval status and manage or cancel bookings directly from your dashboard.</p>
    </div>
  </div>
</section>

<!-- ── How It Works ── -->
<section id="steps" class="steps">
  <h2>How It Works</h2>
  <div class="step-container">
    <div class="step">
      <span>1</span>
      <h3>Register</h3>
      <p>Create your student account with valid credentials.</p>
    </div>

    <div class="step">
      <span>2</span>
      <h3>Login</h3>
      <p>Sign in using your student portal login details.</p>
    </div>

    <div class="step">
      <span>3</span>
      <h3>Select Room</h3>
      <p>Browse floor levels and choose your preferred room and bed.</p>
    </div>

    <div class="step">
      <span>4</span>
      <h3>Book</h3>
      <p>Submit and confirm your booking instantly.</p>
    </div>
  </div>
</section>

<!-- ── FAQ ── -->
<section id="faq" class="faq">
  <h2>Frequently Asked Questions</h2>
  <div class="faq-grid">
    <div class="faq-item">
      <h3>Can I book more than one room?</h3>
      <p>No. Each student is restricted to exactly one active room booking at a time.</p>
    </div>

    <div class="faq-item">
      <h3>Can I cancel my booking?</h3>
      <p>Yes. You can cancel your active booking directly through your student dashboard before the semester starts.</p>
    </div>

    <div class="faq-item">
      <h3>How do I know if my booking is approved?</h3>
      <p>You can check the status of your reservation under the "My Booking" tab on your student dashboard.</p>
    </div>
  </div>
</section>

<!-- ── SUPPORT CENTER ── -->
<section class="support-section">
  <h2>Need Help?</h2>
  <p>Having trouble registering, logging in, or checking your college eligibility status? Submit a guest support ticket to get assistance.</p>
  <a href="guest_support.php" class="btn-primary"><?php echo Icons::mail(); ?> Submit Support Ticket</a>
</section>

<!-- ── STATS BAR ── -->
<div class="stats-bar">
  <div class="stats">
    <div class="stat-item">
      <h3><?php echo Icons::check(24); ?></h3>
      <p>Eligibility Check</p>
    </div>

    <div class="stat-item">
      <h3 id="blockCounter">0</h3>
      <p>Residential Blocks</p>
    </div>

    <div class="stat-item">
      <h3>24/7</h3>
      <p>System Access</p>
    </div>

    <div class="stat-item">
      <h3 id="bookingCounter">0%</h3>
      <p>Online Booking</p>
    </div>
  </div>
</div>

<script>
let counterStarted = false;

function animateCounter(id, start, end, duration, suffix = '') {
  const obj = document.getElementById(id);
  let current = start;
  const increment = (end - start) / (duration / 16);
  const timer = setInterval(() => {
    current += increment;
    if (current >= end) {
      current = end;
      clearInterval(timer);
    }
    obj.textContent = Math.floor(current) + suffix;
  }, 16);
}

const statsBar = document.querySelector('.stats-bar');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting && !counterStarted) {
      counterStarted = true;
      animateCounter("blockCounter", 0, 2, 600, "");
      animateCounter("bookingCounter", 0, 100, 1400, "%");
    }
  });
}, {
  threshold: 0.5
});

observer.observe(statsBar);
</script>
</body>
</html>