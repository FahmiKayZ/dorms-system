<?php
session_start();
include("includes/connection.php");

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = mysqli_real_escape_string($connect, trim($_POST['name'] ?? ''));
    $studentId       = mysqli_real_escape_string($connect, trim($_POST['ID'] ?? ''));
    $email           = mysqli_real_escape_string($connect, trim($_POST['email'] ?? ''));
    $gender          = mysqli_real_escape_string($connect, $_POST['gender'] ?? '');
    $password        = mysqli_real_escape_string($connect, $_POST['password'] ?? '');
    $confirmPassword = mysqli_real_escape_string($connect, $_POST['confirmPassword'] ?? '');

    if ($name == '' || $studentId == '' || $email == '' || $gender == '' || $password == '' || $confirmPassword == '') {
        $error = "Please fill in all fields.";
    } elseif ($password != $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $check = mysqli_query($connect, "SELECT * FROM student WHERE studentID='$studentId'");

        if (mysqli_num_rows($check) > 0) {
            $error = "Student ID already registered.";
        } else {
            $sql = "INSERT INTO student (studentID, studentName, studentEmail, studentPassword, studentGender, collegeStatus) 
                    VALUES ('$studentId', '$name', '$email', '$password', '$gender', 'Pending')";
            mysqli_query($connect, $sql);
            
            mysqli_query($connect, "INSERT INTO eligibility (studentID, status) VALUES ('$studentId', 'Pending')");

            $success = true;
            header("refresh:2;url=login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register – D.O.R.M.S.</title>
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
    padding: 40px 20px;
  }

  .register-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 40px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 10px 30px var(--shadow);
  }

  .register-logo {
    text-align: center;
    font-size: 2rem;
    font-weight: 800;
    color: var(--bg-nav);
    margin-bottom: 8px;
    text-decoration: none;
    display: block;
  }

  .sub {
    text-align: center;
    color: var(--text-muted);
    font-size: 0.95rem;
    margin-bottom: 24px;
  }

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

  .alert {
    padding: 12px;
    border-radius: var(--radius);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    border: 1px solid;
  }

  .alert-error {
    background: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
  }

  .alert-success {
    background: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
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

<div class="register-card">
  <a href="index.php" class="register-logo"><?php echo Icons::home(28); ?> D.O.R.M.S<span>.</span></a>
  <p class="sub">Create your student account to get started</p>

  <?php if ($error): ?>
    <div class="alert alert-error"><?php echo Icons::warning(); ?> <?php echo htmlspecialchars($error); ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success"><?php echo Icons::check(); ?> Account created successfully! Redirecting to login...</div>
  <?php endif; ?>

  <form method="POST" action="register.php">
    <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" placeholder="e.g. John Doe" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
    </div>

    <div class="form-group">
      <label for="ID">Student ID</label>
      <input type="text" id="ID" name="ID" placeholder="e.g. 2026123456" required value="<?php echo isset($_POST['ID']) ? htmlspecialchars($_POST['ID']) : ''; ?>">
    </div>

    <div class="form-group">
      <label for="email">Student Email</label>
      <input type="email" id="email" name="email" placeholder="example@student.uitm.edu.my" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
    </div>

    <div class="form-group">
      <label for="gender">Gender</label>
      <select id="gender" name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
      </select>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="••••••••" required minlength="8">
        <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Toggle password visibility">
          <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </button>
      </div>
    </div>

    <div class="form-group">
      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="••••••••" required minlength="8">
    </div>

    <button type="submit" class="form-submit">Register</button>
  </form>

  <div class="footer-links">
    Already have an account? <a href="login.php">Log in here</a>
  </div>
</div>

<script>
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