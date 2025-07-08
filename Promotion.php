<?php
$host = "localhost"; // or your host
$user = "root"; // your DB username
$password = ""; // your DB password
$dbname = "weirdough";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the promotions
$sql = "SELECT img, promoType, discountAmount, expiryDate, promoCode FROM promotion";
$result = $conn->query($sql);

$promotions = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $promotions[] = $row;
    }
} else {
    echo "<p style='text-align:center;'>No promotions available.</p>";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WeirDough Promotions</title>
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

    .promos-section {
      padding: 50px 40px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .promo-card {
      position: relative;
      height: 300px;
      background-size: cover;
      background-position: center;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: transform 0.3s ease-in-out;
    }

    .promo-card:hover {
      transform: scale(1.05);
    }

    .promo-code {
      position: absolute;
      bottom: 0;
      width: 100%;
      background: rgba(0,0,0,0.6);
      color: white;
      padding: 15px;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
    }

    .copy-msg {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
      color: green;
      display: none;
    }

    .slideshow-wrapper {
      position: relative;
      width: 100%;
      max-width: 100%;
      height: 400px;
      overflow: hidden;
      z-index: 0;
    }

    .slideshow-track {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 1s ease-in-out;
    }

    .slide-img {
      width: 100vw;
      height: 100%;
      object-fit: cover;
      flex-shrink: 0;
    }
    .discount {
  display: block;
  font-size: 14px;
  color: #FFD700;
  margin-top: 5px;
}
  </style>
</head>
<body>
<div class="slideshow-wrapper">
  <div class="slideshow-track">
    <img src="s1.png" class="slide-img">
    <img src="s2.png" class="slide-img">
    <img src="s3.png" class="slide-img">
  </div>
</div>

<div class="overlay" id="overlay"></div>
<div class="sidebar" id="sidebar">
  <button class="close-btn" onclick="closeMenu()">×</button>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="shop.php">Shop</a></li>
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

<style>
  /* ... existing styles ... */
  .discount {
    display: block;
    font-size: 14px;
    color: #FFD700;
    margin-top: 5px;
  }
</style>

<!-- ... existing code ... -->

<section class="promos-section">
  <?php foreach ($promotions as $promo): ?>
    <div class="promo-card" style="background-image: url('<?php echo htmlspecialchars($promo['img']); ?>');">
      <div class="promo-code">
        USE CODE: <?php echo htmlspecialchars($promo['promoCode']); ?><br>
        <span class="discount"><?php echo htmlspecialchars($promo['discountAmount']); ?>% OFF</span><br>
        <span style="font-size:12px; color:#fff;">Expires: <?php echo htmlspecialchars($promo['expiryDate']); ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</section>



<div class="copy-msg" id="copyMsg">Promo code copied!</div>


<footer style="background-color: #E6D1EC; text-align: center; padding: 40px 20px; margin-top: 100px;">
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

const track = document.querySelector('.slideshow-track');
const slides = document.querySelectorAll('.slide-img');
const totalSlides = slides.length;
track.style.width = `${100 * totalSlides}vw`;
let currentSlide = 0;
function showSlide() {
  currentSlide = (currentSlide + 1) % totalSlides;
  track.style.transform = `translateX(-${currentSlide * 100}vw)`;
}
setInterval(showSlide, 3000);

// Copy promo code feature
const promoCards = document.querySelectorAll('.promo-card');
const copyMsg = document.getElementById('copyMsg');
promoCards.forEach(card => {
  card.addEventListener('click', () => {
    const code = card.querySelector('.promo-code').innerText.replace('USE CODE: ', '').trim();
    navigator.clipboard.writeText(code).then(() => {
      copyMsg.style.display = 'block';
      setTimeout(() => {
        copyMsg.style.display = 'none';
      }, 2000);
    });
  });
});
</script>
</body>
</html>
