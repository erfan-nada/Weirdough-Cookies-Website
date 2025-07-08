<?php
// Include config file
require_once "config.php";

// Initialize variables
$id = $name = $email = $password = $role = "";
$name_err = $email_err = $password_err = "";

// Check if this is an update request
if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = trim($_GET['id']);

    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $name = $row['name'];
                $email = $row['email'];
                $role = $row['role'];
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden input value if updating
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
    }

    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } else {
        $name = $input_name;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = $input_email;
    }

    // Validate password (only if creating new or changing password)
    if (empty($id) || !empty(trim($_POST["password"]))) {
        $input_password = trim($_POST["password"]);
        if (empty($input_password)) {
            $password_err = "Please enter a password.";
        } elseif (strlen($input_password) < 8) {
            $password_err = "Password must be at least 8 characters.";
        } else {
            $password = password_hash($input_password, PASSWORD_DEFAULT);
        }
    }

    // Role
    $role = "customer";

    // Check input errors before database operation
    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        if (empty($id)) {
            // Check if email already exists
            $check_sql = "SELECT id FROM users WHERE email = ?";
            if ($check_stmt = mysqli_prepare($link, $check_sql)) {
                mysqli_stmt_bind_param($check_stmt, "s", $param_email);
                $param_email = $email;

                if (mysqli_stmt_execute($check_stmt)) {
                    mysqli_stmt_store_result($check_stmt);
                    if (mysqli_stmt_num_rows($check_stmt) > 0) {
                        $email_err = "An account with this email already exists.";
                    }
                } else {
                    echo "Error checking for existing email.";
                }
                mysqli_stmt_close($check_stmt);
            }
        }

        // If no new email conflict, proceed to insert or update
        if (empty($email_err)) {
            if (empty($id)) {
                // Create new record
                $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_password, $param_role);
                    $param_name = $name;
                    $param_email = $email;
                    $param_password = $password;
                    $param_role = $role;

                    if (mysqli_stmt_execute($stmt)) {
                        header("location: index.php");
                        exit();
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
                mysqli_stmt_close($stmt);
            } else {
                // Update existing record
                if (empty($password)) {
                    $sql = "UPDATE users SET name=?, email=?, role=? WHERE id=?";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_email, $param_role, $param_id);
                        $param_name = $name;
                        $param_email = $email;
                        $param_role = $role;
                        $param_id = $id;
                    }
                } else {
                    $sql = "UPDATE users SET name=?, email=?, password=?, role=? WHERE id=?";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssssi", $param_name, $param_email, $param_password, $param_role, $param_id);
                        $param_name = $name;
                        $param_email = $email;
                        $param_password = $password;
                        $param_role = $role;
                        $param_id = $id;
                    }
                }

                if (mysqli_stmt_execute($stmt)) {
    // Start session and store username
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["name"] = $name;

    header("location: index.php");
    exit();
}

            }
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo empty($id) ? 'Create' : 'Update'; ?> Account | WeirDough</title>
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

    .menu-button,
    .order-button {
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

    .signup-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 60px;
      padding: 40px;
      transition: all 1s ease-in-out;
      flex-direction: row;
    }

    .signup-wrapper.initial {
      flex-direction: column-reverse;
      opacity: 0;
      transform: translateY(50px);
    }

    .signup-wrapper.animate {
      flex-direction: row;
      opacity: 1;
      transform: translateY(0);
    }

    .signup-card {
      background-color: white;
      border-radius: 30px;
      padding: 40px 50px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .signup-card img {
      height: 80px;
      margin-bottom: 20px;
    }

    .signup-card h2 {
      font-size: 32px;
      margin-bottom: 20px;
      color: #6d4b87;
    }

    .signup-card input,
    .signup-card select {
      width: 100%;
      padding: 14px;
      margin: 10px 0 20px;
      border: 1px solid #ccc;
      border-radius: 15px;
      font-size: 16px;
    }

    .signup-card button {
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

    .signup-card button:hover {
      transform: scale(1.03);
    }

    .signup-card p {
      margin-top: 20px;
      font-size: 14px;
      color: #444;
    }

    .signup-card a {
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

    .action-buttons {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .btn-cancel {
      background-color: #ccc !important;
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
      <li><a href="login.php">Login</a></li>
      <li><a href="shoppingcart.php">Cart</a></li>
    </ul>
  </div>

  <header>
    <button class="menu-button" onclick="openMenu()">☰ Menu</button>
    <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo">
    <a href="login.php" class="order-button">Log In</a>
  </header>

  <div class="signup-wrapper initial">
    <div class="signup-card">
      <img src="weirdough-logo.png" alt="WeirDough Logo">
      <h2><?php echo empty($id) ? 'Create Your Account' : 'Update Account'; ?></h2>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="name" placeholder="Full Name" required value="<?php echo $name; ?>" 
               class="<?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
        <span class="error-message"><?php echo $name_err; ?></span>
        
        <input type="email" name="email" placeholder="Email" required value="<?php echo $email; ?>" 
               class="<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <span class="error-message"><?php echo $email_err; ?></span>
        
        <input type="password" name="password" placeholder="Password" <?php echo empty($id) ? 'required' : ''; ?> 
               class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <span class="error-message"><?php echo $password_err; ?></span>
        <?php if (!empty($id)): ?>
          <small style="display: block; margin-top: -15px; margin-bottom: 10px; text-align: left; color: #666;">
            Leave blank to keep current password
          </small>
        <?php endif; ?>
        
        
        
        <?php if (!empty($id)): ?>
          <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <?php endif; ?>
        
        <button type="submit"><?php echo empty($id) ? 'Sign Up' : 'Update'; ?></button>
        
        <?php if (!empty($id)): ?>
          <div class="action-buttons">
            <a href="index.php" class="btn btn-cancel" style="display: block; text-align: center; padding: 14px 0; border-radius: 25px;">Cancel</a>
          </div>
        <?php else: ?>
          <p>Already have an account? <a href="login.php">Log in</a></p>
        <?php endif; ?>
      </form>
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
      const wrapper = document.querySelector('.signup-wrapper');
      setTimeout(() => {
        wrapper.classList.remove('initial');
        wrapper.classList.add('animate');
      }, 100);
    });
  </script>
</body>
</html>