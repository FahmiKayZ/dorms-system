<?php
session_start();
require 'includes/connection.php';

// If already logged in, redirect to respective dashboard
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'student') {
        header("Location: dashboard.php");
    } else {
        header("Location: admin_dashboard.php");
    }
    exit();
}

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connect, trim($_POST['username']));
    $password = mysqli_real_escape_string($connect, trim($_POST['password']));
    $role = $_POST['login_role'] ?? 'student';

    if ($role === 'student') {
        $sql = "SELECT * FROM student WHERE studentID='$username' AND studentPassword='$password'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = [
                'role' => 'student',
                'studentID' => $row['studentID'],
                'name' => $row['studentName'],
                'email' => $row['studentEmail']
            ];
            $_SESSION['studentID'] = $row['studentID'];
            $_SESSION['studentName'] = $row['studentName'];
            header("Location: dashboard.php");
            exit();
        }
        $loginError = "Incorrect Student ID or Password.";
    } else {
        $sql = "SELECT * FROM admin WHERE adminID='$username' AND adminPassword='$password'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = [
                'role' => 'admin',
                'adminID' => $row['adminID'],
                'name' => $row['adminName']
            ];
            $_SESSION['adminID'] = $row['adminID'];
            $_SESSION['adminName'] = $row['adminName'];
            header("Location: admin_dashboard.php");
            exit();
        }
        $loginError = "Incorrect Admin ID or Password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/homepage.css">
<style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: var(--bg);
  }

  .login-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 40px;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 10px 30px var(--shadow);
  }

  .login-logo {
    text-align: center;
    font-size: 2rem;
    font-weight: 800;
    color: var(--bg-nav);
    margin-bottom: 24px;
    text-decoration: none;
    display: block;
  }

  /* Sliding Tab Selector */
  .tab-container {
    display: flex;
    position: relative;
    background: #e9ecef;
    padding: 4px;
    border-radius: 30px;
    margin-bottom: 28px;
  }

  .tab-btn {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    padding: 10px 0;
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--text-muted);
    cursor: pointer;
    z-index: 2;
    transition: color 0.25s ease;
  }

  .tab-btn.active {
    color: var(--white);
  }

  .tab-slider {
    position: absolute;
    width: calc(50% - 4px);
    height: calc(100% - 8px);
    top: 4px;
    left: 4px;
    background: var(--bg-nav);
    border-radius: 26px;
    z-index: 1;
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Password wrapper */
  .password-wrapper {
    position: relative;
  }

  .password-wrapper input {
    padding-right: 48px;
  }

  .toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    padding: 4px;
  }

  .toggle-password:hover {
    color: var(--text-heading);
  }

  .error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: var(--radius);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    border: 1px solid #f5c6cb;
  }

  .footer-links {
    margin-top: 24px;
    text-align: center;
    font-size: 0.9rem;
    color: var(--text-muted);
  }

  .footer-links a {
    color: var(--bg-nav);
    text-decoration: none;
    font-weight: 600;
  }

  .footer-links a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<div class="login-card">
  <a href="index.php" class="login-logo"><?php echo Icons::home(28); ?> D.O.R.M.S<span>.</span></a>
  
  <div class="tab-container">
    <button type="button" class="tab-btn active" onclick="setRole('student')">Student</button>
    <button type="button" class="tab-btn" onclick="setRole('admin')">Admin</button>
    <div class="tab-slider" id="slider"></div>
  </div>

  <?php if ($loginError): ?>
    <div class="error-message"><?php echo Icons::warning(); ?> <?php echo htmlspecialchars($loginError); ?></div>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <input type="hidden" name="login_role" id="login_role" value="student">
    
    <div class="form-group">
      <label for="username" id="username_label">Student ID</label>
      <input type="text" id="username" name="username" placeholder="e.g. 2026123456" required autocomplete="username">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
        <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Toggle password visibility">
          <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </button>
      </div>
    </div>

    <button type="submit" name="login" class="form-submit">Sign In</button>
  </form>

  <div class="footer-links" id="register_footer">
    Don't have an account? <a href="register.php">Register here</a>
  </div>
</div>

<script>
  function setRole(role) {
    const roleInput = document.getElementById('login_role');
    const label = document.getElementById('username_label');
    const input = document.getElementById('username');
    const registerFooter = document.getElementById('register_footer');
    const slider = document.getElementById('slider');
    const btns = document.querySelectorAll('.tab-btn');

    roleInput.value = role;

    if (role === 'student') {
      label.textContent = 'Student ID';
      input.placeholder = 'e.g. 2026123456';
      registerFooter.style.display = 'block';
      slider.style.transform = 'translateX(0)';
      btns[0].classList.add('active');
      btns[1].classList.remove('active');
    } else {
      label.textContent = 'Admin ID';
      input.placeholder = 'e.g. admin01';
      registerFooter.style.display = 'none';
      slider.style.transform = 'translateX(100%)';
      btns[1].classList.add('active');
      btns[0].classList.remove('active');
    }
  }

  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const isHidden = passwordInput.type === 'password';
    
    passwordInput.type = isHidden ? 'text' : 'password';
    
    if (isHidden) {
      // Switch to eye-off icon
      eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
      // Switch to eye icon
      eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
  }
</script>
</body>
</html>
