<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WeirDough Policy</title>
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
      position: absolute;
      top: 0;
      width: 100%;
      z-index: 2;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
    }

    .logo {
      height: 70px;
    }

    .menu-button {
      background-color: #000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease-in-out;
    }

    .menu-button:hover {
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

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      font-size: 28px;
      font-weight: bold;
      margin: 20px 0;
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

    .policy-section {
      padding: 120px 40px 60px;
      max-width: 1000px;
      margin: 0 auto;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .policy-section h1 {
      font-size: 36px;
      margin-bottom: 20px;
      color: #000;
    }

    .policy-section h2 {
      font-size: 24px;
      margin-top: 30px;
      margin-bottom: 10px;
      color: #000;
    }

    .policy-section p {
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }

    footer {
      background-color: #E6D1EC;
      text-align: center;
      padding: 40px 20px;
      margin-top: 60px;
    }

    footer img {
      margin: 0 10px;
    }
  </style>
</head>
<body>

<div class="overlay" id="overlay"></div>
<div class="sidebar" id="sidebar">
  <button class="close-btn" onclick="closeMenu()">×</button>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="shop.html">Shop</a></li>
    <li><a href="Promotion.php">Promotion</a></li>
    <li><a href="policy.php">Policy</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="signup.php">Signup</a></li>
    <li><a href="shoppingcart.php">Cart</a></li>
  </ul>
</div>

<header>
  <button class="menu-button" onclick="openMenu()">☰ Menu</button>
  <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo">
</header>

<section class="policy-section">
  <h1>Our Policies</h1>

  <h2>Privacy Policy</h2>
  <p>WeirDough respects your privacy. We collect only necessary information to process your orders and enhance your experience. Your data will never be sold or shared without your permission.</p>

  <h2>Terms and Conditions</h2>
  <p>By using our website, you agree to our terms, including pricing, availability, and refunds. All orders are subject to confirmation and availability.</p>

  <h2>Cookie Policy</h2>
  <p>We use cookies to improve website performance and offer you a better browsing experience. You can manage your cookie preferences through your browser settings.</p>

  <h2>Refund Policy</h2>
  <p>If you're not satisfied with your order, please contact our support within 48 hours. Refunds or replacements will be issued based on the nature of the concern.</p>
</section>

<footer>
  <div style="margin-bottom: 20px;">
    <a href="https://www.facebook.com/itsweirdough/?locale=cx_PH" target="_blank">
      <img src="icon1.png" alt="Facebook" width="40">
    </a>
    <a href="https://www.instagram.com/itsweirdoughsa/?hl=en" target="_blank">
      <img src="icon2.png" alt="Instagram" width="40">
    </a>
    <a href="https://www.linkedin.com/company/weirdough-bakehouse/?originalSubdomain=ae" target="_blank">
      <img src="icon3.png" alt="LinkedIn" width="40">
    </a>
    <a href="https://www.facebook.com/messages/t/726246864387992" target="_blank">
      <img src="icon4.png" alt="Messenger" width="40">
    </a>
    <a href="https://www.pinterest.com/resta309/weirdough/" target="_blank">
      <img src="icon5.png" alt="Pinterest" width="40">
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
</script>
</body>
</html>
