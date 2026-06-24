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
    <li><a href="index.php" class="active">Home</a></li>
    <li><a href="rooms.php">Your Rooms</a></li>
    <li><a href="support.php">Support</a></li>
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
</section>

<!-- ── STATS BAR ── -->
<div class="stats-bar">
  <div class="stat"><div class="stat-num">200+</div><div class="stat-label">Rooms Available</div></div>
  <div class="stat"><div class="stat-num">4</div><div class="stat-label">Blocks / Wings</div></div>
  <div class="stat"><div class="stat-num">24 / 7</div><div class="stat-label">Support</div></div>
  <div class="stat"><div class="stat-num">100%</div><div class="stat-label">Online Booking</div></div>
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
</body>
</html>