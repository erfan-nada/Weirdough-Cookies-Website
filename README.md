
# 🍪 Weirdough Cookies Website

A full-stack e-commerce web platform for **Weirdough Cookies**, a Saudi-based brand specializing in hand-crafted cookies. This application enables users to browse products, place online orders, track deliveries, and engage with the brand through loyalty features, promotions, and more.

---

## 🚀 Features

- 🛒 Add-to-cart, remove, and update cart items
- 👤 User registration, login, and guest checkout
- 🧾 Order history and live tracking
- 🧩 Product customization (e.g., flavors, toppings)
- 💳 Gift card purchase and redemption
- 🎫 Coupon system and loyalty program
- 🌍 Multi-language support and mobile-friendly design
- 📍 Store locator using Google Maps API
- 💬 Live chat and contact form
- 📝 Product reviews and recommendations
- 📈 Admin dashboard for managing stock, orders, and content
- 🛡️ Secure login, cookie policy consent, and HTTPS support

---

## 🧰 Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **APIs:** Google Maps API, Email service
- **Hosting Recommendation:** InfinityFree / Localhost
- **Project Management:** Trello  
  🔗 [Project Board](https://trello.com/b/SfhC7x8e/weird-dough)

---

## 📁 Project Structure


<pre> <code> /weirdough/ ├── client/ # Frontend website files ├── server/ # Backend PHP scripts ├── database/ # SQL schema and seed files ├── assets/ # Images and media files ├── docs/ │ └── Weirdough_SRS.pdf # Software Requirements Specification └── README.md # Project documentation </code> </pre>



---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/yourusername/weirdough.git
cd weirdough
```

### 2️⃣ Database Setup

1. Create a MySQL database named `weirdough`
2. Import the SQL schema using phpMyAdmin or MySQL CLI:
```bash
mysql -u root -p weirdough < database/weirdough.sql
```

### 3️⃣ Configure Backend

- Set up database credentials in `/server/config.php`:
```php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "weirdough";
```

### 4️⃣ Launch the App

- Serve the project using XAMPP, InfinityFree, or any PHP-supported host.
- Access the frontend from your browser:
```
http://localhost/weirdough/client/
```

---

## ▶️ Usage Guide

### For Customers:
- Browse cookies and combos
- Customize flavors and ingredients
- Place orders for delivery or pickup
- Create an account or use guest checkout
- Earn loyalty points, apply coupons
- Review products and track orders

### For Admins:
- Login to the admin dashboard
- Add, remove, or update products and inventory
- Manage user orders and promotions
- View system logs and contact inquiries

---

## 🧪 Testing Checklist

- ✅ Mobile responsiveness on iOS and Android
- ✅ Guest checkout and account flows
- ✅ Product reviews submission and moderation
- ✅ Loyalty program calculation and redemption
- ✅ Admin inventory and order updates
- ✅ Gift card purchase and application
- ✅ Map location detection (Google Maps)
- ✅ Error handling and security enforcement

---

## 📄 Documentation

- 📘 [Software Requirements Specification (SRS)](./docs/Weirdough_SRS.pdf)

Includes:
- Functional & non-functional requirements
- Class diagrams and domain models
- Operational scenarios
- Timeline (Gantt chart) and budget estimates

---

## ⏱️ Development Timeline

| Task                    | Hours |
|-------------------------|-------|
| User Auth + Registration| 10    |
| Product Browsing        | 12    |
| Online Ordering System  | 18    |
| Store Locator           | 8     |
| Loyalty & Promo System  | 12    |
| Content Management      | 20    |
| **Total**               | **80h** (~2 weeks FT) |

---

## 👨‍👩‍👧‍👦 Team

Developed by students of MSA University, supervised by **Dr. Mohamed Labib**:

- Erfan Nada  
- Rwan Haitham  
- Salah Elabd 
- Fajr Reda  
- Mohammed Ammar  

---

## 📜 License

This project is released for educational purposes.  
All code and content are original or properly attributed. Redistribution is allowed with credit to the authors.

---

## 🔗 References

- [Weirdough on Instagram](https://www.instagram.com/itsweirdoughsa/?hl=en)  
- [Google Maps API Docs](https://developers.google.com/maps/documentation)  
- Pecinovsky, R. (2013). *OOP - Learn Object-Oriented Thinking and Programming*
