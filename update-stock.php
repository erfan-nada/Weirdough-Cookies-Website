<?php
session_start();

// Check admin access
$loggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$isAdmin = $loggedIn && isset($_SESSION["role"]) && $_SESSION["role"] === "admin";
if (!$isAdmin) {
    header("Location: index.php");
    exit;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "weirdough");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle update
$success = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);
    $name = $conn->real_escape_string($_POST["name"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $price = floatval($_POST["price"]);
    $stock = intval($_POST["stock"]);

    $stmt = $conn->prepare("UPDATE cookies SET name=?, description=?, price=?, stock=? WHERE id=?");
    $stmt->bind_param("ssdii", $name, $description, $price, $stock, $id);
    $success = $stmt->execute();
    $stmt->close();
}

// Get cookies
$cookies = $conn->query("SELECT * FROM cookies");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Update Cookies</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
    <style>
      <?php include 'style.css'; ?>

      body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background: linear-(135deg, #f7a1cc, #6d4b87);
        min-height: 100vh;
        color: #3a006f;
      }

      /* Back button */
      .back-btn {
        display: inline-block;
        margin: 30px 40px 10px;
        padding: 10px 22px;
        background-color: #6d4b87;
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s ease;
      }
      .back-btn:hover {
        background-color:rgb(100, 43, 144);
      }

h1 {
  text-align: center;
  margin:50px;
  font-weight: 900;
  font-size: 3rem;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #6d4b87; /* bright pink */
  text-shadow:
    3px 3px 0 #6d4b87,   /* purple shadow */
    -2px -2px 0rgb(127, 45, 213); /* lighter pink shadow */
  transform: rotate(-3deg);
  font-family: 'Comic Sans MS', cursive, sans-serif;
  animation: bounce 1.5s infinite ease-in-out;
}
body{
    background-image: url("background.png");
}




      .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        padding: 0 40px 60px;
        max-width: 1400px;
        margin: 0 auto 60px;
      }

      .card {
        background: rgba(255 255 255 / 0.9);
        padding: 25px 20px;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease-in-out;
      }

      .card:hover {
        transform: translateY(-5px);
          }

      .card label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #3a006f;
      }

      .card input,
      .card textarea {
        width: 90%;
        padding: 12px;
        margin-bottom: 16px;
        border-radius: 12px;
        border: 1px solid #ddd;
        font-size: 14px;
        background-color: #fafafa;
        transition: border 0.2s;
      }

      .card input:focus,
      .card textarea:focus {
        border-color: #6d4b87;
        outline: none;
        background-color: #fff;
      }

      .card button {
        background-color: #6d4b87;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        font-size: 15px;
        transition: background-color 0.3s ease;
        width: 90%;
        align-self: center;
      }

      .card button:hover {
        background-color:rgb(88, 30, 133);
      }

      .success {
        text-align: center;
        background: #e6ffed;
        color:rgb(11, 49, 11);
        padding: 16px;
        margin: 20px auto 40px;
        max-width: 600px;
        border-left: 6px solidrgb(22, 80, 22);
        border-radius: 10px;
        font-size: 15px;
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
      background-color: rgb(88, 30, 133);;
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
    </style>
</head>
<body>
      <header>
          <img src="weirdough-logo.png" alt="WeirDough Logo" class="logo">
          <a href="index.php" class="order-button">Back to Home Page!</a>
  </header>


<h1>Manage Cookies</h1>

<?php if ($success): ?>
    <div class="success">Cookie updated successfully!</div>
<?php endif; ?>

<div class="grid">
    <?php while ($row = $cookies->fetch_assoc()): ?>
        <form class="card" method="POST" action="update-stock.php">
            <input type="hidden" name="id" value="<?= $row['id'] ?>" />
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required />

            <label>Description:</label>
            <textarea name="description" rows="3" required><?= htmlspecialchars($row['description']) ?></textarea>

            <label>Price:</label>
            <input type="number" name="price" step="0.01" value="<?= $row['price'] ?>" required />

            <label>Stock:</label>
            <input type="number" name="stock" value="<?= $row['stock'] ?>" required />

            <button type="submit">Update</button>
        </form>
    <?php endwhile; ?>
</div>

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

</body>
</html>
