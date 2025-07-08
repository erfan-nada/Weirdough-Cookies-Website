<?php
session_start();
require_once "config.php";

// Initialize variables
$email = $password = "";
$email_err = $password_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If no errors, proceed
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password, $role);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role; // Optional — remove if you don't need to track it
                            header("location: index.php");
                            exit();
                        } else {
                            $password_err = "Invalid password.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WeirDough Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-image: url('background.png');
      background-repeat: repeat;
      min-height: 100vh;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      border-bottom: 1px solid #ccc;
    }

    .logo {
      height: 70px;
    }

    .menu-button, .order-button {
      background-color: #000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease-in-out;
    }

    .menu-button:hover,
    .order-button:hover {
      transform: scale(1.05);
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: -100%;
      width: 300px;
      height: 100%;
      background: #fff;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
      padding: 30px 20px;
      z-index: 1000;
      transition: left 0.3s ease;
    }

    .sidebar.open {
      left: 0;
    }

    .sidebar h2 {
      margin: 0 0 30px;
      font-size: 24px;
      font-weight: bold;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      font-size: 28px;
      font-weight: bold;
      margin: 20px 0;
      cursor: pointer;
    }

    .sidebar a {
      text-decoration: none;
      color: inherit;
      display: block;
    }

    .close-btn {
      background: #E6D1EC;
      border: none;
      font-size: 24px;
      font-weight: bold;
      color: #000;
      float: right;
      cursor: pointer;
      border-radius: 50%;
      width: 35px;
      height: 35px;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      z-index: 999;
      display: none;
    }

    .overlay.active {
      display: block;
    }

    .login-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 60px;
      padding: 40px;
      transition: all 1s ease-in-out;
      flex-direction: row;
    }

    .login-wrapper.initial {
      flex-direction: column-reverse;
      opacity: 0;
      transform: translateY(50px);
    }

    .login-wrapper.animate {
      flex-direction: row;
      opacity: 1;
      transform: translateY(0);
    }

    .login-card {
      background-color: white;
      border-radius: 30px;
      padding: 40px 50px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .login-card img {
      height: 80px;
      margin-bottom: 20px;
    }

    .login-card h2 {
      font-size: 32px;
      margin-bottom: 20px;
      color: #6d4b87;
    }

    .login-card input[type="text"],
    .login-card input[type="password"],
    .login-card select {
      width: 100%;
      padding: 14px;
      margin: 10px 0 20px;
      border: 1px solid #ccc;
      border-radius: 15px;
      font-size: 16px;
    }

    .login-card button {
      background-color: #6d4b87;
      color: white;
      padding: 14px 0;
      width: 100%;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .login-card button:hover {
      transform: scale(1.03);
    }

    .login-card p {
      margin-top: 20px;
      font-size: 14px;
      color: #444;
    }

    .login-card a {
      color: #6d4b87;
      text-decoration: none;
      font-weight: bold;
    }

    .girl-img {
      max-width: 500px;
      width: 100%;
      height: auto;
      transition: transform 1s ease-in-out;
    }

    /* Error message styling */
    .error-message {
      color: #ff0000;
      font-size: 12px;
      margin-top: -15px;
      margin-bottom: 10px;
      text-align: left;
    }

    .has-error {
      border-color: #ff0000 !important;
    }
  </style>
</head>

<body>
  <div class="overlay" id="overlay"></div>

  <div class="sidebar" id="sidebar">
    <button class="close-btn" onclick="closeMenu()">×</button>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="Promotion.php">Promotion</a></li>
      <li><a href="policy.php">Policy</a></li>
      <li><a href="signup.php">Signup</a></li>
      <li><a href="#">Cart</a></li>
    </ul>
  </div>

  <header>
    <button class="menu-button" onclick="openMenu()">☰ Menu</button>
    <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo">
    <a href="login.php" class="order-button">Log In</a>
  </header>

  <div class="login-wrapper initial">
    <div class="login-card">
      <img src="weirdough-logo.png" alt="WeirDough Logo">
      <h2>Welcome Back!</h2>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="email" placeholder="Email" required 
               class="<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" 
               value="<?php echo $email; ?>">
        <span class="error-message"><?php echo $email_err; ?></span>
        
        <input type="password" name="password" placeholder="Password" required 
               class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <span class="error-message"><?php echo $password_err; ?></span>
        
        
        <button type="submit">Log In</button>
      </form>
      <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
    <img src="girloncookie.png" alt="Girl on Cookie" class="girl-img" />
  </div>

  <!-- Footer -->
  <footer style="background-color: #E6D1EC; text-align: center; padding: 40px 20px;">
    <div style="margin-bottom: 20px;">
      <a href="https://www.facebook.com/itsweirdough/?locale=cx_PH" target="_blank">
        <img src="icon1.png" alt="Facebook" width="40" style="margin: 0 10px;">
      </a>
      <a href="https://www.instagram.com/itsweirdoughsa/?hl=en" target="_blank">
        <img src="icon2.png" alt="Instagram" width="40" style="margin: 0 10px;">
      </a>
      <a href="https://www.linkedin.com/company/weirdough-bakehouse/?originalSubdomain=ae" target="_blank">
        <img src="icon3.png" alt="LinkedIn" width="40" style="margin: 0 10px;">
      </a>
      <a href="https://www.facebook.com/messages/t/726246864387992" target="_blank">
        <img src="icon4.png" alt="Messenger" width="40" style="margin: 0 10px;">
      </a>
      <a href="https://www.pinterest.com/resta309/weirdough/" target="_blank">
        <img src="icon5.png" alt="Pinterest" width="40" style="margin: 0 10px;">
      </a>
    </div>
    
    <div style="margin-bottom: 20px;">
      <img src="weirdough-logo.png" alt="WeirDough Logo" style="height: 100px;">
    </div>
  
    <div style="font-size: 14px; color: #000;">
      © 2025 all rights reserved.<br>
      <a href="#" style="color: #000;">Privacy policy</a> | 
      <a href="#" style="color: #000;">Terms and Conditions</a> | 
      <a href="#" style="color: #000;">Non-edible Cookie Preferences</a>
    </div>
  </footer>

  <script>
    function openMenu() {
      document.getElementById('sidebar').classList.add('open');
      document.getElementById('overlay').classList.add('active');
    }

    function closeMenu() {
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('overlay').classList.remove('active');
    }

    document.getElementById('overlay').addEventListener('click', closeMenu);

    window.addEventListener('DOMContentLoaded', () => {
      const wrapper = document.querySelector('.login-wrapper');
      setTimeout(() => {
        wrapper.classList.remove('initial');
        wrapper.classList.add('animate');
      }, 100);
    });
  </script>
</body>
</html>