<?php
$conn = new mysqli("localhost", "root", "", "weirdough"); 

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT name, description , price, image_url FROM cookies");
$cookies = [];

if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $cookies[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WeirDough Shop</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <style>
      /* Existing styles from your page */
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;
      }

      body {
        background-image: url("background.png");
        background-repeat: repeat;
        min-height: 100vh;
        padding-bottom: 90px;
      }

      header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
        z-index: 2; /* ensure it appears over the video */
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
        text-decoration: none;
        display: inline-block;
        text-align: center;
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
        cursor: pointer;
      }

      .sidebar ul li a {
        text-decoration: none;
        color: inherit;
        display: block;
      }

      .close-btn {
        background: #e6d1ec;
        border: none;
        font-size: 24px;
        font-weight: bold;
        color: #000;
        float: right;
        cursor: pointer;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        line-height: 30px;
        text-align: center;
        padding: 0;
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

      /* --- Scrolling Announcement Bar Styles --- */
      .announcement-bar-container {
        background-color: #222; /* Dark background */
        color: #fff; /* White text */
        overflow: hidden; /* Hide overflowing text */
        padding: 10px 0;
        white-space: nowrap; /* Prevent text from wrapping */
      }

      .announcement-bar-content {
        display: inline-block; /* Allow for scrolling */
        padding-left: 100%; /* Start off-screen */
        animation: scroll-announcement 30s linear infinite; /* Adjust speed as needed */
      }

      .announcement-item {
        display: inline-block;
        margin: 0 20px;
        color: #fff;
      }

      .announcement-separator {
        color: #e6d1ec; /* Light purple separator */
        margin: 0 10px;
        font-size: 1.5em; /* Make the circles bigger */
        line-height: 1; /* Adjust line height for better vertical centering */
      }

      @keyframes scroll-announcement {
        0% {
          transform: translateX(0%);
        }
        100% {
          transform: translateX(-100%);
        }
      }

      /* --- BUILD YOUR OWN BOX Styles --- */
      .video-banner-container {
        position: relative;
        width: 100%;
        height: 400px; /* Adjust height as needed */
        overflow: hidden;
      }

      .background-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .video-overlay-content {
        position: absolute;
        right: 40px;
        bottom: 20px;
        z-index: 2;
      }

      .triple-image-container {
        left: 50%;
        bottom: 150px;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: center;
        position: absolute;
        z-index: 2;
      }

      .box-image {
        height: 110px;
        transition: transform 0.3s ease;
        border-radius: 12px;
      }

      .box-image-middle {
        transform: scale(1.1);
        z-index: 1;
      }

      .cookie-tab {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 15px 0;
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.6);
        z-index: 999;
      }

      .cookie-slot {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .cookie-slot img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
      }
      #buildyourownbox3 {
        margin-top: 70px; /* increase this number to lower it more */
      }

      .add-to-cart-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #000;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 20px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease-in-out;
      }

      .add-to-cart-button:hover {
        transform: scale(1.05);
      }

      .ing-image-wrapper {
        display: flex;
        justify-content: flex-start;
        padding: 40px;
        margin-top: -60px; /* optional: bring it closer to video */
      }

      .ing-image {
        max-width: 300px;
        height: auto;
        border-radius: 20px;
      }
      .cart-controls {
        position: fixed;
        bottom: 20px;
        right: 20px;
        left: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
        align-items: center;
        z-index: 1001;
      }

      .box-size-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
      }
      .box-size-button {
        padding: 10px 18px;
        border: 2px solid #000;
        background-color: white;
        color: #000;
        font-weight: bold;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
      }

      .box-size-button:hover,
      .box-size-button.selected {
        background-color: #000;
        color: white;
      }

      .add-to-cart-button {
        background-color: #000;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 20px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
      }

      .add-to-cart-button:hover {
        transform: scale(1.05);
      }


footer {
  width: 100vw;
  background-color: #e6d1ec;
  text-align: center;
  padding: 40px 20px;
  margin-top: 60px;
  position: relative;
  z-index: 0;
}

    footer img {
      margin: 0 10px;
    }

    footer a {
      color: #000;
      text-decoration: none;
    }

    footer .legal {
      font-size: 14px;
      color: #000;
      margin-top: 20px;
    }
    
    </style>
  </head>
  <body>
    <div class="announcement-bar-container">
      <div class="announcement-bar-content">
        <span class="announcement-item">FREE SHIPPING OVER SR100</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">NOM NOM NEEDS COOKIES</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">FREE SHIPPING OVER SR100</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">COOKIES BEAT FLOWERS</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">FREE SHIPPING OVER SR100</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">INDULGE YOUR CRAVINGS</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">MORE YUMMY TREATS HERE!</span>
        <span class="announcement-separator">•</span>
        <span class="announcement-item">GRAB YOUR COOKIES NOW!</span>
      </div>
    </div>

    <div class="video-banner-container">
      <header>
        <button class="menu-button" onclick="openMenu()">☰ Menu</button>
        <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo" />
      </header>

      <video autoplay muted loop playsinline class="background-video">
        <source src="video.mp4" type="video/mp4" />
        Your browser does not support the video tag.
      </video>

      <div class="video-overlay-content triple-image-container">
        <img src="buildyourownbox.png" alt="Box 1" class="box-image" />
        <img
          src="buildyourownbox2.png"
          alt="Box 2"
          class="box-image box-image-middle"
        />
        <img
          id="buildyourownbox3"
          img
          src="buildyourownbox3.png"
          alt="Box 3"
          class="box-image"
        />
      </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
      <button class="close-btn" onclick="closeMenu()">×</button>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="Promotion.php">Promotion</a></li>
        <li><a href="policy.php">Policy</a></li>
        <li><a href="signup.php">Signup</a></li>
        <li><a href="shoppingcart.php">Cart</a></li>
        </ul>
    </div>

    <div
      style="
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
        margin-top: 60px;
      "
    >
      <?php foreach ($cookies as $cookie): ?>
  <div style="text-align: center; color: rgb(0, 0, 0); max-width: 200px">
    <img
      src="<?= $cookie['image_url'] ?>"
      alt="<?= $cookie['name'] ?>"
      style="width: 100%; border-radius: 50%"
    />
    <h3><?= $cookie['name'] ?></h3>
    <p>(<?= $cookie['description'] ?>)</p>
    <p><strong>SR<?= number_format($cookie['price'], 2) ?></strong></p>
    <div
      style="
        display: flex;
        justify-content: center;
        gap: 10px;
        align-items: center;
        background: #ffffff;
        padding: 8px 12px;
        border-radius: 25px;
      "
    >
      <button class="plus-button">+</button>
      <button class="minus-button">-</button>
    </div>
  </div>
<?php endforeach; ?>

    <div id="cookieTab" class="cookie-tab"></div>

    <div class="cart-controls">
      <div class="box-size-options">
        <button class="box-size-button" data-size="6">6</button>
        <button class="box-size-button" data-size="12">12</button>
        <button class="box-size-button" data-size="custom">Custom</button>
      </div>

      <button
        class="add-to-cart-button"
        onclick="location.href='shoppingcart.php'"
      >
        Add to Cart
      </button>
    </div>

    <!-- Footer -->
<footer>
    <div>
      <a href="https://www.facebook.com/itsweirdough/?locale=cx_PH" target="_blank"><img src="icon1.png" alt="Facebook" width="40" /></a>
      <a href="https://www.instagram.com/itsweirdoughsa/?hl=en" target="_blank"><img src="icon2.png" alt="Instagram" width="40" /></a>
      <a href="https://www.linkedin.com/company/weirdough-bakehouse/?originalSubdomain=ae" target="_blank"><img src="icon3.png" alt="LinkedIn" width="40" /></a>
      <a href="https://www.facebook.com/messages/t/726246864387992" target="_blank"><img src="icon4.png" alt="Messenger" width="40" /></a>
      <a href="https://www.pinterest.com/resta309/weirdough/" target="_blank"><img src="icon5.png" alt="Pinterest" width="40" /></a>
    </div>

    <div style="margin: 20px 0;">
      <img src="weirdough-logo.png" alt="WeirDough Logo" style="height: 100px;" />
    </div>

    <div class="legal">
      © 2025 all rights reserved.<br />
      <a href="#">Privacy policy</a> |
      <a href="#">Terms and Conditions</a> |
      <a href="#">Non-edible Cookie Preferences</a>
    </div>
  </footer>
    <script>
      window.addEventListener("DOMContentLoaded", () => {
        renderCookieSlots(0); // Default box size
      });

      function openMenu() {
        document.getElementById("sidebar").classList.add("open");
        document.getElementById("overlay").classList.add("active");
      }

      function closeMenu() {
        document.getElementById("sidebar").classList.remove("open");
        document.getElementById("overlay").classList.remove("active");
      }

      document.getElementById("overlay").addEventListener("click", closeMenu);

      const cookieTab = document.getElementById("cookieTab");

      function renderCookieSlots(count) {
        cookieTab.innerHTML = "";
        for (let i = 0; i < count; i++) {
          const slot = document.createElement("div");
          slot.classList.add("cookie-slot");
          addRemoveClickToSlot(slot);
          cookieTab.appendChild(slot);
        }
      }

      function addRemoveClickToSlot(slot) {
        slot.addEventListener("click", () => {
          const img = slot.querySelector("img");
          if (img) {
            const cookieName = getCookieNameFromImage(img.src);
            removeCookieFromStorage(cookieName);
            slot.innerHTML = "";
          }
        });
      }

      function getCookieNameFromImage(src) {
        const cookies =
          JSON.parse(localStorage.getItem("selectedCookies")) || [];
        const found = cookies.find((c) => c.image === src);
        return found ? found.name : null;
      }

      function removeCookieFromStorage(name, image) {
  fetch("cart_1.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ name, image, action: "remove" }),
  });
}

     function saveCookieToStorage(name, image) {
  fetch("cart_1.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ name, image, action: "add" }),
  });
}


      function setupMinusButtons() {
        document.querySelectorAll(".minus-button").forEach((button) => {
          button.disabled = false;
          button.onclick = () => {
            const cookieContainer = button.closest("div").parentElement;
            const cookieImage = cookieContainer.querySelector("img").src;
            const cookieName = cookieContainer.querySelector("h3").innerText;

removeCookieFromStorage(cookieName, cookieImage);
            // Remove one matching slot
            const cookieSlots = document.querySelectorAll(".cookie-slot");
            const match = Array.from(cookieSlots).find((slot) => {
              const img = slot.querySelector("img");
              return img && img.src === cookieImage;
            });

            if (match) {
              match.innerHTML = "";
            }
          };
        });
      }

      let selectedBoxSize = null;

      document.querySelectorAll(".box-size-button").forEach((btn) => {
        btn.addEventListener("click", () => {
          document
            .querySelectorAll(".box-size-button")
            .forEach((b) => b.classList.remove("selected"));
          btn.classList.add("selected");
          selectedBoxSize = btn.dataset.size;

          localStorage.setItem("selectedBoxSize", selectedBoxSize);

          if (selectedBoxSize !== "custom") {
            limitSelection(parseInt(selectedBoxSize));
          } else {
            enableCustomSelection();
          }
        });
      });

      function limitSelection(maxCookies) {
        renderCookieSlots(maxCookies);

        document.querySelectorAll(".plus-button").forEach((button) => {
          button.disabled = false;
          button.onclick = () => {
            const cookieSlots = document.querySelectorAll(".cookie-slot");
            const currentCount = Array.from(cookieSlots).filter(
              (slot) => slot.children.length > 0
            ).length;

            if (currentCount >= maxCookies) {
              alert(`You've reached the limit of ${maxCookies} cookies.`);
              return;
            }

            const cookieContainer = button.closest("div").parentElement;
            const cookieImage = cookieContainer.querySelector("img").src;
            const cookieName = cookieContainer.querySelector("h3").innerText;

            const emptySlot = Array.from(cookieSlots).find(
              (slot) => slot.children.length === 0
            );
            if (emptySlot) {
              const img = document.createElement("img");
              img.src = cookieImage;
              emptySlot.appendChild(img);
              addRemoveClickToSlot(emptySlot);
              saveCookieToStorage(cookieName, cookieImage);
            }
          };
        });

        setupMinusButtons();
      }

      function enableCustomSelection() {
        cookieTab.innerHTML = "";

        document.querySelectorAll(".plus-button").forEach((button) => {
          button.disabled = false;
          button.onclick = () => {
            const cookieContainer = button.closest("div").parentElement;
            const cookieImage = cookieContainer.querySelector("img").src;
            const cookieName = cookieContainer.querySelector("h3").innerText;

            const slot = document.createElement("div");
            slot.classList.add("cookie-slot");
            const img = document.createElement("img");
            img.src = cookieImage;
            slot.appendChild(img);
            addRemoveClickToSlot(slot);
            cookieTab.appendChild(slot);

            saveCookieToStorage(cookieName, cookieImage);
          };
        });

        setupMinusButtons();
      }
    </script>
  </body>
</html>
