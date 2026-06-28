<?php
session_start();

$isLoggedIn = isset($_SESSION['user']);
$userName   = $isLoggedIn ? htmlspecialchars($_SESSION['user']['name']) : '';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $demo = [
        'admin'   => ['password' => 'admin123',   'name' => 'Administrator'],
        'student' => ['password' => 'student123', 'name' => 'Demo Student'],
    ];
    if (isset($demo[$u]) && $demo[$u]['password'] === $p) {
        $_SESSION['user'] = ['username' => $u, 'name' => $demo[$u]['name']];
        header('Location: index.php');
        exit;
    }
    $loginError = 'Incorrect username or password.';
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

</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar">
  <a href="index.php" class="nav-brand">
    <div class="nav-brand-icon">🏠</div>
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
      <a href="?logout=1" class="btn-logout">Log out</a>
    <?php else: ?>
      <a href="#" class="btn-login" onclick="openModal(); return false;">Log In</a>
      <a href="register.php" class="btn-primary">Register</a>
    <?php endif; ?>
  </div>
</nav>

<!-- ── HERO ── -->
<section class="hero">
  <div class="hero-content">
    <span class="hero-eyebrow">University Accommodation</span>

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
        <a href="book-rooms.php" class="btn-primary">Book a Room</a>
      <?php else: ?>
        <a href="login.php" class="btn-primary">Book a Room</a>
      <?php endif; ?>
      <a href="eligibility.php" class="btn-ghost">Check Eligibility</a>
    </div>
  </div>

  <div class="hero-visual">

    <div class="img-cluster">
        <div class="floating-card card-one">
    <span>🛏️</span>
    <h4>200+ Rooms</h4>
    <p>Available</p>
</div>

<div class="floating-card card-two">
    <span>⚡</span>
    <h4>Fast Booking</h4>
    <p>Less than 2 Minutes</p>
</div>

<div class="floating-card card-three">
    <span>🛡️</span>
    <h4>Secure System</h4>
    <p>Safe & Reliable</p>
</div>
        <div class="img-card img-secondary">

            <div class="img-placeholder">

                <div style="font-size:60px;">🏢</div>

                <strong>D.O.R.M.S.</strong>

                <small>Modern Dormitory</small>

            </div>
        </div>

        <div class="img-card img-main">

            <div class="img-placeholder">

                <div style="font-size:90px;">🏠</div>

                <strong>University Accommodation</strong>

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
            <div class="icon">🏢</div>
            <h3>Real-Time Availability</h3>
            <p>View room availability instantly before making a booking.</p>
        </div>

        <div class="feature-card">
            <div class="icon">⚡</div>
            <h3>Fast Booking</h3>
            <p>Book your room online within minutes without paperwork.</p>
        </div>

        <div class="feature-card">
            <div class="icon">🔒</div>
            <h3>Secure System</h3>
            <p>Your booking information is protected and securely stored.</p>
        </div>

        <div class="feature-card">
            <div class="icon">✅</div>
            <h3>Easy Management</h3>
            <p>Manage and cancel your booking anytime through your dashboard.</p>
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
<p>Create your student account.</p>
</div>

<div class="step">
<span>2</span>
<h3>Login</h3>
<p>Access your dashboard.</p>
</div>

<div class="step">
<span>3</span>
<h3>Select Room</h3>
<p>Browse available rooms.</p>
</div>

<div class="step">
<span>4</span>
<h3>Book</h3>
<p>Confirm your booking instantly.</p>
</div>

</div>

</section>

<!-- ── FAQ ── -->
 <section id="faq" class="faq">

<h2>Frequently Asked Questions</h2>

<div class="faq-item">

<h3>Can I book more than one room?</h3>

<p>No. Each student can only have one active room booking.</p>

</div>

<div class="faq-item">

<h3>Can I cancel my booking?</h3>

<p>Yes. Students can cancel their booking through the dashboard.</p>

</div>

<div class="faq-item">

<h3>How do I know if my booking is approved?</h3>

<p>Your booking status will be displayed in the My Booking page.</p>

</div>

</section>

<!-- ── STATS BAR ── -->
<div class="stats-bar">

    <div class="stat">
        <div class="stat-num" id="roomCounter">200+</div>
        <div class="stat-label">Rooms Available</div>
    </div>

    <div class="stat">
        <div class="stat-num" id="blockCounter">4</div>
        <div class="stat-label">Blocks / Wings</div>
    </div>

    <div class="stat">
        <div class="stat-num">24 / 7</div>
        <div class="stat-label">Support</div>
    </div>

    <div class="stat">
        <div class="stat-num" id="bookingCounter">100%</div>
        <div class="stat-label">Online Booking</div>
    </div>

</div>

<!-- ── FOOTER ── -->
<footer>
  <span>&copy; <?= date('Y') ?> <span class="brand">D.O.R.M.S.</span> — Digital Occupancy And Room Management System</span>
  <span>All rights reserved.</span>
</footer>

<!-- ── LOGIN MODAL ── -->
<div class="overlay" id="loginOverlay" role="dialog" aria-modal="true" aria-labelledby="modalH">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()" aria-label="Close">&times;</button>
    <h2 id="modalH">Welcome back</h2>
    <p class="sub">Log in to manage your room booking.</p>

    <?php if ($loginError): ?>
      <p class="error"><?= htmlspecialchars($loginError) ?></p>
    <?php endif; ?>

    <form method="POST" action="auth.php">
      <div class="field">
        <label for="u">Username</label>
        <input type="text" id="u" name="username" placeholder="e.g. student" required autocomplete="username">
      </div>
      <div class="field">
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" placeholder="••••••••" required autocomplete="current-password">
      </div>
      <div class="login-role">
    <label>
        <input type="radio" name="login_role" value="student" checked>
        <span>Student</span>
    </label>

    <label>
        <input type="radio" name="login_role" value="admin">
        <span>Admin</span>
    </label>
</div>
      <button type="submit" name="login" class="btn-primary">Log In</button>
    </form>

  </div>
</div>

<script>
function openModal()  { document.getElementById('loginOverlay').classList.add('open'); document.getElementById('u').focus(); }
function closeModal() { document.getElementById('loginOverlay').classList.remove('open'); }

document.getElementById('loginOverlay').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

<?php if ($loginError): ?>openModal();<?php endif; ?>
</script>

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

            animateCounter("roomCounter", 0, 200, 1200, "+");
            animateCounter("blockCounter", 0, 4, 800, "");
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
