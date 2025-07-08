<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

$name = $email = $password = $role = "";
$errors = ['name' => '', 'email' => '', 'password' => '', 'role' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $errors['name'] = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $errors['email'] = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $errors['password'] = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $errors['password'] = "Password must be at least 8 characters.";
    } else {
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    }
    
    // Validate role
    if (empty(trim($_POST["role"]))) {
        $errors['role'] = "Please select a role.";
    } else {
        $role = trim($_POST["role"]);
    }
    
    if (empty(array_filter($errors))) {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
         
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_password, $param_role);
            
            $param_name = $name;
            $param_email = $email;
            $param_password = $password;
            $param_role = $role;
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: admin_user_list.php?success=user_created");
                exit();
            } else {
                echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User | WeirDough Admin</title>
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
        
        .form-container {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            backdrop-filter: blur(5px);
            margin: 30px;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-title {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .form-subtitle {
            color: var(--dark);
            opacity: 0.7;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border-radius: 12px;
            border: 2px solid var(--secondary);
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(109, 75, 135, 0.2);
        }
        
        .error-message {
            color: #E74C3C;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }
        
        .has-error .form-control {
            border-color: #E74C3C;
        }
        
        .btn {
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            width: 100%;
        }
        
        .btn-primary:hover {
            background: #5a3a6f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(109, 75, 135, 0.3);
        }
        
        .btn-secondary {
            background: var(--secondary);
            color: var(--dark);
            width: 100%;
            margin-top: 15px;
        }
        
        .btn-secondary:hover {
            background: #d4b8e0;
            transform: translateY(-2px);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 40px;
            cursor: pointer;
            color: var(--primary);
        }
        
        .role-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236d4b87' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title"><i class="fas fa-user-plus"></i> Add New User</h1>
            <p class="form-subtitle">Fill in the details to create a new account</p>
        </div>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo !empty($errors['name']) ? 'has-error' : ''; ?>">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="error-message"><?php echo $errors['name']; ?></span>
            </div>
            
            <div class="form-group <?php echo !empty($errors['email']) ? 'has-error' : ''; ?>">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="error-message"><?php echo $errors['email']; ?></span>
            </div>
            
            <div class="form-group <?php echo !empty($errors['password']) ? 'has-error' : ''; ?>">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                <span class="error-message"><?php echo $errors['password']; ?></span>
            </div>
            
            <div class="form-group <?php echo !empty($errors['role']) ? 'has-error' : ''; ?>">
                <label class="form-label">User Role</label>
                <select name="role" class="form-control role-select">
                    <option value="">Select a role</option>
                    <option value="admin" <?php echo $role == 'admin' ? 'selected' : ''; ?>>Administrator</option>
                    <option value="customer" <?php echo $role == 'customer' ? 'selected' : ''; ?>>Customer</option>
                    <option value="guest" <?php echo $role == 'guest' ? 'selected' : ''; ?>>Guest</option>
                </select>
                <span class="error-message"><?php echo $errors['role']; ?></span>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create User
            </button>
            
            <a href="admin_user_list.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </form>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
        
        // Real-time validation
        document.querySelector('form').addEventListener('input', function(e) {
            if (e.target.name === 'name' && e.target.value.length > 0) {
                e.target.classList.remove('is-invalid');
                document.querySelector('[name="name"] + .error-message').textContent = '';
            }
            // Add similar validation for other fields
        });
    </script>
</body>
</html>