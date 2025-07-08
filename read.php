<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "SELECT * FROM users WHERE id = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $name = $row["name"];
                $email = $row["email"];
                $role = $row["role"];
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "<script>alert('Oops! Something went wrong.');</script>";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User | WeirDough Admin</title>
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .profile-container {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            backdrop-filter: blur(5px);
            margin: 30px;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        .profile-title {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .profile-subtitle {
            color: var(--dark);
            opacity: 0.7;
            margin-bottom: 30px;
        }
        
        .profile-details {
            margin-bottom: 30px;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .detail-label {
            width: 120px;
            font-weight: 600;
            color: var(--primary);
        }
        
        .detail-value {
            flex: 1;
        }
        
        .role-badge {
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .role-admin {
            background: #FFEAA7;
            color: #E17055;
        }
        
        .role-user {
            background: #D6EAF8;
            color: #2980B9;
        }
        
        .role-guest {
            background: #D5F5E3;
            color: #27AE60;
        }
        
        .action-btns {
            display: flex;
            gap: 15px;
            justify-content: center;
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
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a3a6f;
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
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h1 class="profile-title"><?php echo htmlspecialchars($name); ?></h1>
            <p class="profile-subtitle">User Details</p>
        </div>
        
        <div class="profile-details">
            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value"><?php echo htmlspecialchars($email); ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Role</div>
                <div class="detail-value">
                    <span class="role-badge role-<?php echo htmlspecialchars($role); ?>">
                        <?php echo ucfirst(htmlspecialchars($role)); ?>
                    </span>
                </div>
            </div>
            
            
        </div>
        
        <div class="action-btns">
            <a href="update.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
            <a href="admin_user_list.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>