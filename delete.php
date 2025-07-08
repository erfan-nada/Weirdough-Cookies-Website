<?php
session_start();
require_once "config.php";

// Check if user is logged in and an admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

// Handle deletion
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $sql = "DELETE FROM users WHERE id = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_POST["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            header("location: admin_user_list.php");
            exit();
        } else {
            echo "<script>alert('Oops! Something went wrong.');</script>";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} elseif (empty(trim($_GET["id"]))) {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Deletion | WeirDough Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6d4b87;
            --secondary: #E6D1EC;
            --accent: #FF9F43;
            --light: #FFF5F5;
            --dark: #2C3A47;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: var(--dark);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .confirm-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .confirm-header {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .confirm-icon {
            font-size: 3rem;
            color: #E74C3C;
            margin-bottom: 15px;
        }

        .confirm-text {
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background: #E74C3C;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: #d4b8e0;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <div class="confirm-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="confirm-header">Confirm Deletion</div>
        <div class="confirm-text">
            Are you sure you want to permanently delete this user? This action cannot be undone.
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars(trim($_GET["id"])); ?>">
            <div class="btn-group">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Yes, Delete
                </button>
                <a href="admin_user_list.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>
