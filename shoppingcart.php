<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopping Cart | WeirDough Shop</title>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet"/>
  <style>
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
      position: relative;
    }

    header {
      position: relative; /* changed from absolute */
      top: 0;
      left: 0;
      width: 100%;
      display: flex;
      align-items: center;
      padding: 20px 40px;
      z-index: 3;
      
    }

    /* --- Scrolling Announcement Bar Styles --- */
    .announcement-bar-container {
      background-color: #222; /* Dark background */
      color: #fff; /* White text */
      overflow: hidden; /* Hide overflowing text */
      padding: 10px 0;
      white-space: nowrap; /* Prevent text from wrapping */
      position: sticky;
  top: 0;
  z-index: 1000;
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
      z-index: 4;
    }

    .menu-button:hover,
    .order-button:hover {
      transform: scale(1.05);
    }

    .logo {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      height: 60px;
      z-index: 4;
    }

    .cart-container {
      max-width: 600px;
      margin: 100px auto 40px;
      background-color: rgba(255,255,255,0.95);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .cart-container h2 {
      color: #d2691e;
      text-align: center;
      margin-bottom: 20px;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 10px;
    }

    .cart-item h3 {
      font-size: 18px;
    }

    .cart-item p {
      font-size: 14px;
      color: #666;
    }

    .total {
      text-align: right;
      font-size: 20px;
      font-weight: bold;
      margin: 20px 0;
    }

    .checkout-button {
      display: inline-block;
      background-color: #000;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease-in-out;
      margin-top: 15px;
    }

    .checkout-button:hover {
      transform: scale(1.05);
    }

    footer {
      background-color: #e6d1ec;
      text-align: center;
      padding: 40px 20px;
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

    /* Sidebar styles */
    .sidebar {
  position: fixed;
  top: 0;
  left: -300px; /* hide off-screen by default */
  width: 300px;
  height: 100vh;
  background-color: #fff;
  box-shadow: 2px 0 12px rgba(0, 0, 0, 0.15);
  padding: 30px 20px;
  z-index: 1000;
  transition: left 0.3s ease;
  font-family: "Poppins", sans-serif;
  border-radius: 0 0 0 20px;
}

.sidebar.open {
  left: 0;
}

.sidebar ul {
  list-style: none;
  margin-top: 50px;
  padding: 0;
}

.sidebar ul li {
  font-size: 24px;
  font-weight: 700;
  margin: 20px 0;
  cursor: pointer;
}

.sidebar ul li a {
  color: #000;
  text-decoration: none;
  display: block;
  padding: 8px 10px;
  border-radius: 12px;
  transition: background-color 0.2s ease, color 0.2s ease;
}
.cart-item.sold-out {
  opacity: 0.6;
}
.sidebar ul li a:hover {
  background-color: #e6d1ec; /* your light purple from announcement bar */
  color: #000;
}

.close-btn {
  background: #e6d1ec; /* same purple shade */
  border: none;
  font-size: 24px;
  font-weight: 700;
  color: #000;
  cursor: pointer;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  line-height: 36px;
  text-align: center;
  float: right;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  transition: background-color 0.2s ease;
}

.close-btn:hover {
  background-color: #d2b5d9; /* slightly darker purple */
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.4);
  z-index: 999;
  display: none;
  transition: opacity 0.3s ease;
}

.overlay.active {
  display: block;
  opacity: 1;
}
.shipping-payment-container {
  background: #fff;
  padding: 25px 35px;
  border-radius: 20px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  max-width: 600px;
  margin: 30px auto 0;
  font-family: "Poppins", sans-serif;
  color: #222;
  border: 2px solid #e6d1ec; /* Light purple border */
}

.shipping-payment-container label {
  display: flex;
  align-items: center;
  font-weight: 600;
  font-size: 17px;
  margin-bottom: 15px;
  cursor: pointer;
  color: #444;
  transition: color 0.3s ease;
}

.shipping-payment-container label:hover {
  color:rgb(210, 115, 194); /* Your orange accent */
}

.shipping-payment-container input[type="radio"] {
  appearance: none;
  -webkit-appearance: none;
  width: 22px;
  height: 22px;
  border: 2px solidrgb(188, 97, 167);
  border-radius: 50%;
  margin-right: 12px;
  position: relative;
  cursor: pointer;
  transition: background-color 0.3s ease, border-color 0.3s ease;
}

.shipping-payment-container input[type="radio"]:checked {
  background-color:rgb(210, 115, 194);
  border-color:rgb(210, 115, 194);
}

.shipping-payment-container select {
  width: 100%;
  padding: 12px 15px;
  font-size: 16px;
  border-radius: 15px;
  border: 2px solid #e6d1ec;
  outline: none;
  cursor: pointer;
  transition: border-color 0.3s ease;
  color: #444;
}


.shipping-payment-container select:focus {
  border-color:rgb(210, 115, 194);
}

.shipping-payment-container .fee {
  font-weight: 700;
  color:rgb(210, 115, 194);
  margin-top: -12px;
  margin-bottom: 20px;
  text-align: right;
  font-size: 14px;
}


  </style>
</head>
<body>

  <div class="announcement-bar-container">
    <div class="announcement-bar-content">
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
      <span class="announcement-separator">•</span>
      <span class="announcement-item">ALMOST THERE! COMPLETE YOUR ORDER NOW.</span>
    </div>
  </div>

  <header>
    <button class="menu-button" onclick="openMenu()">☰ Menu</button>
    <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo" />
  </header>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <button class="close-btn" onclick="closeMenu()">×</button>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="Promotion.php">Promotion</a></li>
      <li><a href="policy.php">Policy</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="signup.php">Signup</a></li>
      <li><a href="shoppingcart.php">Cart</a></li>
    </ul>
  </div>

  <!-- Overlay -->
  <div id="overlay"></div>

  <div
    style="
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px;
      margin-top: 60px;
    "
  ></div>

  <div class="cart-container">
  <img src="yourcart.png" alt="Your Shopping Cart" style="display: block; margin: 0 auto 20px; max-width: 50%; height: auto;" />

    <div id="cart-items"></div>
    <div style="margin-bottom: 20px;">
  <label for="promo-code"><strong>Promo Code:</strong></label><br/>
  <input type="text" id="promo-code" placeholder="Enter promo code (e.g. DOUGHS33)" 
         style="width: 100%; padding: 10px; margin-top: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
  <button onclick="applyPromo()" 
          style="margin-top: 10px; padding: 10px 20px; border-radius: 20px; background-color: #000; color: #fff; font-weight: bold; border: none;">
    Apply
  </button>
  <div id="promo-feedback" style="margin-top: 10px; color: green;"></div>
</div>
<div class="total" id="cart-total">Total: 48.75 SR</div>


<div class="shipping-payment-container" style="margin-top: 30px;">

  <div style="margin-bottom: 20px;">
    <label><strong>Shipping Method:</strong></label><br/>
    <input type="radio" id="pickup" name="shipping" value="pickup" checked />
    <label for="pickup">Pickup (Free)</label><br/>
    <input type="radio" id="delivery" name="shipping" value="delivery" />
    <label for="delivery">Delivery (Add SR 20.00)</label>
  </div>
<div id="address-field" style="display: none; margin-bottom: 20px;">
  <label><strong>Delivery Address:</strong></label><br/>

  <input type="text" id="street" name="street" placeholder="Street Name" 
         style="width: 100%; padding: 10px; margin-top: 10px; margin-bottom: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />

  <input type="text" id="city" name="city" placeholder="City" 
         style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />

  <input type="text" id="apartment" name="apartment" placeholder="Apartment Number (optional)" 
         style="width: 100%; padding: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
</div>



  <div style="margin-bottom: 20px;">
    <label for="payment"><strong>Payment Method:</strong></label><br/>
    <select id="payment" name="payment" style="padding: 6px; border-radius: 6px; width: 200px;">
      <option value="cash">Cash on Delivery</option>
      <option value="paypal">PayPal</option>
      <option value="credit-card">Credit Card</option>
    </select>
    <div id="credit-card-fields" style="display: none; margin-top: 15px;">
  <input type="text" placeholder="Cardholder Name" id="cc-name" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
  <input type="text" placeholder="Card Number" id="cc-number" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
  <input type="text" placeholder="Expiry Date (MM/YY)" id="cc-expiry" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
  <input type="text" placeholder="CVV" id="cc-cvv" style="width: 100%; padding: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
</div>

<div id="paypal-fields" style="display: none; margin-top: 15px;">
  <input type="email" placeholder="PayPal Email" id="paypal-email" style="width: 100%; padding: 10px; border-radius: 12px; border: 2px solid #e6d1ec;" />
</div>

  </div>

</div>





    <div style="text-align: center;">
<button class="checkout-button" onclick="checkout()">Checkout</button>
    </div>
  </div>

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

  const paymentSelect = document.getElementById('payment');
  const ccFields = document.getElementById('credit-card-fields');
  const paypalFields = document.getElementById('paypal-fields');

  paymentSelect.addEventListener('change', function () {
    const value = this.value;

    ccFields.style.display = value === 'credit-card' ? 'block' : 'none';
    paypalFields.style.display = value === 'paypal' ? 'block' : 'none';
  });    

      function closeConfirmation() {
    document.getElementById('confirmation-modal').style.display = 'none';
  }

  async function checkout() {
    // Get selected shipping method
    const shippingMethod = document.querySelector('input[name="shipping"]:checked')?.value || 'pickup';
    let fullAddress = "Pickup at store";

    // If delivery, validate address fields
    if (shippingMethod === 'delivery') {
      const street = document.getElementById('street')?.value.trim();
      const city = document.getElementById('city')?.value.trim();
      const apartment = document.getElementById('apartment')?.value.trim();

      if (!street || !city) {
        alert("Please enter both street name and city.");
        return;
      }

      fullAddress = `${street}, ${apartment ? 'Apt ' + apartment + ', ' : ''}${city}`;
    }

    // Get selected payment method
    const paymentMethod = document.getElementById('payment').value;
    let paymentDetails = "";

    if (paymentMethod === 'credit-card') {
      const name = document.getElementById('cc-name').value.trim();
      const number = document.getElementById('cc-number').value.trim();
      const expiry = document.getElementById('cc-expiry').value.trim();
      const cvv = document.getElementById('cc-cvv').value.trim();

      if (!name || !number || !expiry || !cvv) {
        alert("Please fill in all credit card fields.");
        return;
      }

      paymentDetails = `Credit Card ending in ****${number.slice(-4)} (Exp: ${expiry})`;

    } else if (paymentMethod === 'paypal') {
      const email = document.getElementById('paypal-email').value.trim();
      if (!email) {
        alert("Please enter your PayPal email.");
        return;
      }

      paymentDetails = `PayPal (${email})`;

    } else if (paymentMethod === 'cash') {
      paymentDetails = "Cash on delivery";
    } else {
      alert("Please select a payment method.");
      return;
    }

    // Get cart total
    const totalAmountElement = document.getElementById('cart-total');
let totalAmount = totalAmountElement?.textContent || "58.3125SR";

// Remove "Total :" and any spaces after it
totalAmount = totalAmount.replace(/Total\s*:\s*/i, '');


    // Display confirmation modal
    const orderDetailsText = `
      <strong>Shipping Method:</strong> ${shippingMethod}<br/>
      <strong>Address:</strong> ${fullAddress}<br/>
      <strong>Payment Method:</strong> ${paymentDetails}<br/>
      <strong>Total:</strong> ${totalAmount}
    `;

    document.getElementById('order-details').innerHTML = orderDetailsText;
    document.getElementById('confirmation-modal').style.display = 'flex';
  }


const DELIVERY_FEE = 20.00;
const addressField = document.getElementById('address-field');

document.querySelectorAll('input[name="shipping"]').forEach(radio => {
  radio.addEventListener('change', () => {
    addressField.style.display = radio.value === 'delivery' ? 'block' : 'none';
    renderCart(); // also updates total
  });
});
// Show/hide delivery address fields
document.querySelectorAll('input[name="shipping"]').forEach((el) => {
  el.addEventListener('change', () => {
    const addressField = document.getElementById('address-field');
    addressField.style.display = el.value === 'delivery' ? 'block' : 'none';
  });
});

// Show/hide payment fields
document.getElementById('payment').addEventListener('change', function () {
  const value = this.value;
  document.getElementById('credit-card-fields').style.display = value === 'credit-card' ? 'block' : 'none';
  document.getElementById('paypal-fields').style.display = value === 'paypal' ? 'block' : 'none';
});

function renderCart() {
  const cartItemsContainer = document.getElementById('cart-items');
  const cartTotalEl = document.getElementById('cart-total');
  const checkoutButton = document.querySelector('.checkout-button');
  const shippingMethod = document.querySelector('input[name="shipping"]:checked')?.value || 'pickup';

  fetch("get_cart.php")
    .then((res) => res.json())
    .then((data) => {
      if (data.status !== "success") {
        cartItemsContainer.innerHTML = "<p>Failed to load cart.</p>";
        checkoutButton.disabled = true;
        return;
      }

      let total = 0;
      let hasSoldOutItem = false;

      cartItemsContainer.innerHTML = ''; 

      data.cart.forEach(cookie => {
        if (cookie.stock == 0) {
          hasSoldOutItem = true;
        }

        const item = document.createElement('div');
        item.className = 'cart-item';

        const soldOutMessage = cookie.stock == 0
          ? `<p style="color: red; font-weight: bold; font-size: 14px;">Sold Out</p>`
          : '';

        item.innerHTML = `
          <div>
            <h3>${cookie.name}</h3>
            <p>Quantity: ${cookie.quantity}</p>
            ${soldOutMessage}
          </div>
          <div>
            <h3>${(cookie.price * cookie.quantity).toFixed(2)} SR</h3>
          </div>
        `;

        if (cookie.stock == 0) item.classList.add('sold-out');

        cartItemsContainer.appendChild(item);
        total += cookie.price * cookie.quantity;
      });

      // Add delivery fee if delivery selected
      if (shippingMethod === 'delivery') {
        total += DELIVERY_FEE;
      }

      let totalText = `Total: ${total.toFixed(2)} SR`;
      if (shippingMethod === 'delivery') {
        totalText += ` (Includes Delivery Fee of ${DELIVERY_FEE.toFixed(2)} SR)`;
      }

      cartTotalEl.innerText = totalText;

      // Disable checkout button if any sold out item found
      checkoutButton.disabled = hasSoldOutItem;
      checkoutButton.style.opacity = hasSoldOutItem ? 0.5 : 1;
      checkoutButton.style.cursor = hasSoldOutItem ? 'not-allowed' : 'pointer';
    })
    .catch((err) => {
      console.error(err);
      cartItemsContainer.innerHTML = "<p>Error loading cart.</p>";
      checkoutButton.disabled = true;
      checkoutButton.style.opacity = 0.5;
      checkoutButton.style.cursor = 'not-allowed';
    });
}

// Add event listeners to shipping radios to update total dynamically
document.querySelectorAll('input[name="shipping"]').forEach(radio => {
  radio.addEventListener('change', renderCart);
});



// Run on page load
document.addEventListener('DOMContentLoaded', renderCart);
  window.onload = renderCart;

  function openMenu() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').classList.add('active');
  }

  function closeMenu() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('active');
  }

  let originalTotal = 0; // To store total before discount
  let discountPercent = 0;

  // Sample function to render items and update the total
  function renderCartItems() {
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById("cart-items");
    cartItemsContainer.innerHTML = "";
    let total = 0;

    cartItems.forEach(item => {
      const itemDiv = document.createElement("div");
      itemDiv.className = "cart-item";
      itemDiv.innerHTML = `
        <h3>${item.name}</h3>
        <p>${item.price} SR x ${item.quantity}</p>
        <p>${item.price * item.quantity} SR</p>
      `;
      cartItemsContainer.appendChild(itemDiv);
      total += item.price * item.quantity;
    });

    originalTotal = total; // save original
    updateTotalDisplay();
  }

  function applyPromo() {
    const code = document.getElementById("promo-code").value.trim().toUpperCase();
    const feedback = document.getElementById("promo-feedback");

    // Example: extract digits from code (e.g., DOUGHS33 → 33)
    const match = code.match(/\d{2}/);
    if (match) {
      discountPercent = parseInt(match[0]);
      if (discountPercent >= 1 && discountPercent <= 100) {
        feedback.textContent = `✔️ Promo applied: ${discountPercent}% OFF`;
        updateTotalDisplay();
      } else {
        feedback.textContent = "❌ Invalid discount percentage.";
      }
    } else {
      feedback.textContent = "❌ Invalid promo code.";
    }

  }

  function updateTotalDisplay() {
    const discountedTotal = originalTotal * (1 - discountPercent / 100);
    document.getElementById("cart-total").textContent = 
      `Total: 58.3125 SR(after ${discountPercent}% OFF)`;

  }

  function checkout() {
    alert("Proceeding to checkout. Total: " + document.getElementById("cart-total").textContent);
  }

  // Render cart on load
  renderCartItems();
  </script>
  
  <div id="confirmation-modal" style="display: none; position: fixed; top: 0; left: 0; 
  width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.7); 
  display: flex; justify-content: center; align-items: center; z-index: 9999;">
  <div style="background: #fff; padding: 30px 40px; border-radius: 20px; max-width: 500px; text-align: center; box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
    <h2 style="color:rgb(201, 122, 206);">Order Confirmed!</h2>
    <p id="order-details" style="margin: 20px 0; font-size: 16px;"></p>
    <button onclick="closeConfirmation()" style="background-color: #000; color: #fff; padding: 10px 20px; border-radius: 12px; border: none; cursor: pointer;">Close</button>
  </div>
</div>

</body>
</html>


