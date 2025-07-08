<?php
// Initialize the session
session_start();

$loggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$userName = $loggedIn ? htmlspecialchars($_SESSION["name"]) : "";

$isAdmin = $loggedIn && isset($_SESSION["role"]) && $_SESSION["role"] === "admin";


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WeirDough Catering</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

  <style>
body::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('background.png');
  background-repeat: repeat;
  z-index: -1;
  pointer-events: none;
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
.menu-button:hover, .order-button:hover {
  transform: scale(1.05);
  transition: transform 0.2s ease-in-out;
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
.content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 60px 40px;
  transition: filter 0.3s ease;
}
.text-section {
  max-width: 600px;
  margin-top: 80px; 
}
.text-section h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 72px;
  font-weight: 900;
  line-height: 1;
  margin-bottom: 20px;
}
.text-section p {
  font-size: 18px;
  margin-bottom: 30px;
}
.cookie-img {
  position: absolute;
  bottom: -10px;
  right: -110px;
  height: 100vh;
  width: auto;
  max-width: 100%;
  object-fit: contain;
  z-index: 1;
  transform: scale(0.8);
}
.order-button.large {
  font-size: 16px;
  padding: 14px 28px;
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
  font-family: 'Poppins', sans-serif;
  font-weight: 900;
  font-size: 28px;
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
.container {
  position: relative;
  height: 100vh;        
  overflow: hidden;   
}
.blur-wrapper {
  transition: filter 0.3s ease;
  height: 100%;
}
.cookie-stack {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 40px; 
  padding: 60px 20px;
}
.cookie-stack img {
  width: 100%;
  max-width: 1200px; 
  border-radius: 30px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.welcome-message {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  margin-right: 20px;
}
.chatbot-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 350px;
  height: 500px;
  z-index: 10000;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  overflow: hidden;
}

  </style>
</head>
<body>

<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebar">
  <button class="close-btn" onclick="closeMenu()">×</button>
  <ul>
    <li><a href="shop.php">Shop</a></li>
    <li><a href="Promotion.php">Promotion</a></li>
    <li><a href="policy.php">Policy</a></li>
    <?php if (!$loggedIn): ?>
      <li><a href="login.php">Login</a></li>
      <li><a href="signup.php">Signup</a></li>
    <?php else: ?>
      <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
    <li><a href="shoppingcart.php">Cart</a></li>
    <?php if ($isAdmin): ?>
  <li><a href="admin_user_list.php">User Management</a></li>
  <li><a href="update-stock.php">Update Stock</a></li>
  
<?php endif; ?>


  </ul>
</div>

<header>
  <button class="menu-button" onclick="openMenu()">☰ Menu</button>
  <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo">
  <?php if ($loggedIn): ?>
    <span class="welcome-message">Welcome, <b><?php echo $userName; ?></b></span>
    <a href="logout.php" class="order-button" style="text-decoration: none;">Logout</a>
  <?php else: ?>
    <a href="login.php" class="order-button" style="text-decoration: none;">Log In</a>
  <?php endif; ?>
  
</header>

<div class="container">
  <div class="content" id="main-content">
    <div class="text-section">
    <img src="scrumptioustreat.png" alt="Scrumptious Treat" style="max-width: 100%; height: auto;">
    <p>Transform every occasion into a sweet celebration. Just select your nearest store and schedule your order in a few clicks.</p>
      <button class="order-button large" onclick="location.href='shop.php'">Order Now</button>
    </div>
    <img src="https://crumbl.video/cdn-cgi/image/width=1920,format=auto,quality=80/https://crumblcookies.com/_next/static/media/lgCateringHero.f01fc822.png" alt="Cookies" class="cookie-img">
  </div>
</div>

<div class="cookie-stack">

  <img src="cookie1.png" alt="Semi-Sweet Chocolate Chunk">
  <img src="cookie2.png" alt="Cookies & Cream Brownie">
  <img src="cookie3.png" alt="Turtle Cheesecake">
  <img src="cookie4.png" alt="Cake Batter">

</div>


<footer style="background-color: #E6D1EC; text-align: center; padding: 40px 20px;">
  <div style="margin-bottom: 20px;">
    <a href="https://www.facebook.com/itsweirdough/?locale=cx_PH" target="_blank"><img src="icon1.png" alt="Facebook" width="40" style="margin: 0 10px;"></a>
    <a href="https://www.instagram.com/itsweirdoughsa/?hl=en" target="_blank"><img src="icon2.png" alt="Instagram" width="40" style="margin: 0 10px;"></a>
    <a href="https://www.linkedin.com/company/weirdough-bakehouse/?originalSubdomain=ae" target="_blank"><img src="icon3.png" alt="LinkedIn" width="40" style="margin: 0 10px;"></a>
    <a href="https://www.facebook.com/messages/t/726246864387992" target="_blank"><img src="icon4.png" alt="Messenger" width="40" style="margin: 0 10px;"></a>
    <a href="https://www.pinterest.com/resta309/weirdough/" target="_blank"><img src="icon5.png" alt="Pinterest" width="40" style="margin: 0 10px;"></a>
  </div>
  <div style="margin-bottom: 20px;"><img src="weirdough-logo.png" alt="WeirDough Logo" style="height: 100px;"></div>
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
function toggleChatbot() {
  const chatbot = document.getElementById('chatbotContainer');
  const isVisible = chatbot.style.display === 'block';
  chatbot.style.display = isVisible ? 'none' : 'block';

  const toggleBtn = document.getElementById('chatbot-toggle');
  toggleBtn.textContent = isVisible ? 'Chat with us' : 'Close Chat';
}
</script>

<button id="chatbot-toggle" onclick="toggleChatbot()" style="
  position: fixed;
  bottom: 50px;
  right: 20px;
  z-index: 10001;
  background-color: #000;
  color: white;
  border: none;
  border-radius: 25px;
  padding: 12px 20px;
  font-size: 14px;
  cursor: pointer;
">Chat with us</button>

<div class="chatbot-container" id="chatbotContainer" style="display: none;">
  <iframe
    src="https://www.chatbase.co/chatbot-iframe/4TyjYLyr46W1y2SNwxYyv"
    width="350"
    height="500"
    frameborder="0"
  ></iframe>
</div>
</body>
</html>

