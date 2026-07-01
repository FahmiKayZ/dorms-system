<?php
session_start();

include("includes/connection.php");

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = trim($_POST['name'] ?? '');
    $studentId       = trim($_POST['ID'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $gender          = $_POST['gender'] ?? '';
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

   if (
    $name == '' ||
    $studentId == '' ||
    $email == '' ||
    $gender == '' ||
    $password == '' ||
    $confirmPassword == ''
) {
    $error = "Please fill in all fields.";
}elseif ($password != $confirmPassword) {
    $error = "Password does not match.";
}
else {

    $check = mysqli_query(
        $connect,
        "SELECT * FROM student
         WHERE studentID='$studentId'"
    );

    if(mysqli_num_rows($check)>0){

        $error = "Student ID already registered.";

    }else{

        $sql = "
        INSERT INTO student
        (
        studentID,
        studentName,
        studentEmail,
        studentPassword,
        studentGender,
        collegeStatus
        )
        VALUES
        (
        '$studentId',
        '$name',
        '$email',
        '$password',
        '$gender',
        'Pending'
        )
        ";

        mysqli_query($connect,$sql);
        
        mysqli_query($connect,"
      INSERT INTO eligibility
      (studentID,status)
      VALUES
      ('$studentId','Pending')
      ");

        $success = true;
        header("refresh:2;url=index.php");
      exit();
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
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg:            #50C878;  /* Emerald */
    --bg-surface:    #ffffff;  /* White — card surface */
    --accent:        #4eca6e;  /* Mantis Green */
    --btn-primary:   #3a9147;  /* Sea Green */
    --btn-primary-h: #2d7a3a;  /* Hunter Green */
    --text-heading:  #1f1f1f;  /* Eerie Black */
    --text-body:     #4a4a4a;  /* Davy's Gray */
    --text-muted:    #8a8a8a;  /* Dim Gray */
    --link-muted:    #b0b0b0;  /* Light Grey — used for the "Return to Home" link */
    --border:        #d4d4d4;  /* Light Gray */
    --error:         #d64545;  /* Indian Red */
    --radius:        10px;
  }

  body {
    font-family: 'Inter', sans-serif;
    background-color: var(--bg);
    color: var(--text-body);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
  }

  .register-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 40px 44px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.08);
  }

  .register-card h1 {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text-heading);
    text-align: center;
    margin-bottom: 4px;
  }

  .register-card .sub {
    text-align: center;
    font-size: 0.88rem;
    color: var(--text-muted);
    margin-bottom: 28px;
  }

  .alert {
    text-align: center;
    font-size: 0.88rem;
    padding: 10px 14px;
    border-radius: 8px;
    margin-bottom: 20px;
  }
  .alert-error   { background: #fbe9e9; color: var(--error); }
  .alert-success { background: #e6f7eb; color: var(--btn-primary-h); }

  .field { margin-bottom: 18px; }

  .field label {
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    margin-bottom: 6px;
  }

  .field input,
  .field select {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 9px;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: var(--text-heading);
    background: var(--bg-surface);
    outline: none;
    transition: border-color 0.18s;
  }
  .field input:focus,
  .field select:focus { border-color: var(--accent); }

  /* Password field needs a relative wrapper so the toggle button
     can be absolutely positioned inside the input, on the right edge */
  .password-wrapper {
    position: relative;
  }

  .password-wrapper input {
    padding-right: 44px; /* leave room so typed text doesn't run under the button */
  }

  .toggle-password {
    position: absolute;
    right: 4px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    border-radius: 6px;
    transition: color 0.15s, background 0.15s;
  }

  .toggle-password:hover {
    color: var(--text-heading);
    background: var(--bg);
  }

  .toggle-password svg {
    width: 20px;
    height: 20px;
  }

  .btn-row {
    display: flex;
    gap: 10px;
    margin-top: 24px;
  }

  button {
    flex: 1;
    padding: 12px;
    border-radius: 9px;
    font-family: 'Inter', sans-serif;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    border: none;
    transition: background 0.18s, color 0.18s;
  }

  .btn-primary { background: var(--btn-primary); color: #fff; }
  .btn-primary:hover { background: var(--btn-primary-h); }

  /* Wrapper block makes text-align: center work on the inline <a> below it */
  .return-link {
    text-align: center;
    margin-top: 16px;
  }

  .return-link a {
    color: var(--link-muted);     /* light grey */
    font-size: 0.92rem;
    text-decoration: none;
  }

  .return-link a:hover {
    color: var(--text-muted);     /* slightly darker grey on hover for feedback */
    text-decoration: underline;
  }

  footer {
    margin-top: 24px;
    text-align: center;
    font-size: 0.78rem;
    color: var(--text-muted);
  }
</style>
</head>
<body>

  <div>
    <div class="register-card">
      <h1>Registration</h1>
      <p class="sub">Create your D.O.R.M.S. account</p>

      <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php elseif ($success): ?>
        <div class="alert alert-success">Account created successfully!</div>
      <?php endif; ?>

      <form method="POST" action="register.php">
        <div class="field">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div class="field">
          <label for="ID">Student ID</label>
          <input type="text" id="ID" name="ID" required>
        </div>
        <div class="field">
    <label for="email">Student Email</label>
    <input type="email"
           id="email"
           name="email"
           placeholder="example@student.uitm.edu.my"
           required>
</div>

<div class="field">
    <label for="gender">Gender</label>

    <select id="gender" name="gender" required>

        <option value="">Select Gender</option>

        <option value="Male">Male</option>

        <option value="Female">Female</option>

    </select>
</div>

        <div class="field">
          <label for="password">Password</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password" required minlength="8">
            <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Show password">
              <!-- eye-open icon, swapped to eye-off via JS when toggled -->
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </button>
          </div>
        </div>
        <div class="field">
    <label for="confirmPassword">Confirm Password</label>

    <input type="password"
           id="confirmPassword"
           name="confirmPassword"
           required
           minlength="8">
</div>

        <div class="btn-row">
          <button type="submit" class="btn-primary">Submit</button>
        </div>

        <div class="return-link">
          <a href="index.php">Return to Home</a>
        </div>
      </form>
    </div>

    <footer>
      <p>Copyright &copy; <?= date('Y') ?> D.O.R.M.S. All rights reserved.</p>
    </footer>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('eyeIcon');

      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';

      // Swap the icon's inner markup between "eye" (visible) and "eye-off" (hidden)
      if (isHidden) {
        // showing password now -> use "eye-off" icon
        icon.innerHTML = `
          <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
          <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
          <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"></path>
          <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
        icon.closest('.toggle-password').setAttribute('aria-label', 'Hide password');
      } else {
        // hiding password again -> use normal "eye" icon
        icon.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        `;
        icon.closest('.toggle-password').setAttribute('aria-label', 'Show password');
      }
    }
  </script>

</body>
</html>