<?php
session_start();
require_once "config.php";

// Admin access check
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeirDough - Admin Dashboard</title>
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
            background-image:url("background.png");
            background-size: cover;
            background-repeat: repeat;
            margin: 0;
            padding: 0;
            color: var(--dark);
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--secondary);
        }
        
        .admin-title {
            color: var(--primary);
            font-size: 2.5rem;
            margin: 0;
            font-weight: 700;
        }
        
        .admin-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 50px;
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
            border: 2px solid var(--primary);
        }
        
        .btn-primary:hover {
            background: transparent;
            color: var(--primary);
            transform: translateY(-3px);
        }
        
        .btn-secondary {
            background: var(--accent);
            color: white;
            border: 2px solid var(--accent);
        }
        
        .btn-secondary:hover {
            background: transparent;
            color: var(--accent);
            transform: translateY(-3px);
        }
        
        .user-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }
        
        .user-table thead th {
            background: var(--primary);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .user-table th:first-child {
            border-radius: 15px 0 0 15px;
        }
        
        .user-table th:last-child {
            border-radius: 0 15px 15px 0;
        }
        
        .user-table tbody tr {
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .user-table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .user-table td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .user-table td:first-child {
            border-radius: 15px 0 0 15px;
        }
        
        .user-table td:last-child {
            border-radius: 0 15px 15px 0;
        }
        
        .role-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
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
            gap: 10px;
        }
        
        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }
        
        .view-btn {
            background: #3498DB;
        }
        
        .edit-btn {
            background: #2ECC71;
        }
        
        .delete-btn {
            background: #E74C3C;
        }
        
        .action-btn:hover {
            transform: scale(1.1) rotate(10deg);
        }
        
        .search-bar {
            margin-bottom: 30px;
            position: relative;
        }
        
        .search-bar input {
            width: 94%;
            padding: 15px 20px;
            border-radius: 50px;
            border: 2px solid var(--secondary);
            font-size: 1rem;
            padding-left: 50px;
            transition: all 0.3s ease;
        }
        
        .search-bar input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(109, 75, 135, 0.2);
        }
        
        .search-bar i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 10px 0;
        }
        
        .stat-label {
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 1.5rem;
        }
        
        .users-icon {
            background: rgba(109, 75, 135, 0.1);
            color: var(--primary);
        }
        
        .admins-icon {
            background: rgba(255, 159, 67, 0.1);
            color: var(--accent);
        }
        
        .active-icon {
            background: rgba(46, 204, 113, 0.1);
            color: #2ECC71;
        }
        
        .inactive-icon {
            background: rgba(231, 76, 60, 0.1);
            color: #E74C3C;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title"><i class="fas fa-user-cog"></i> User Dashboard</h1>
            <div class="admin-actions">
                <a href="create.php" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Back to Site
                </a>
            </div>
        </div>
        
        <div class="stats-cards">
            <?php
            // Get user statistics
            $total_users = mysqli_query($link, "SELECT COUNT(*) FROM users")->fetch_row()[0];
            $admins = mysqli_query($link, "SELECT COUNT(*) FROM users WHERE role='admin'")->fetch_row()[0];
            $active_users = 0;
            $inactive_users = $total_users; // all users considered inactive

            ?>
            
            <div class="stat-card">
                <div class="icon-circle users-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value"><?php echo $total_users; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            
            <div class="stat-card">
                <div class="icon-circle admins-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-value"><?php echo $admins; ?></div>
                <div class="stat-label">Administrators</div>
            </div>
            
            <div class="stat-card">
                <div class="icon-circle active-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-value"><?php echo $active_users; ?></div>
                <div class="stat-label">Active Users</div>
            </div>
            
            <div class="stat-card">
                <div class="icon-circle inactive-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-value"><?php echo $inactive_users; ?></div>
                <div class="stat-label">Inactive Users</div>
            </div>
        </div>
        
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search users by name, email or role...">
        </div>
        
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, name, email, role FROM users";
                if ($result = mysqli_query($link, $sql)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>#" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td><span class='role-badge role-" . htmlspecialchars($row['role']) . "'>" . 
                             ucfirst(htmlspecialchars($row['role'])) . "</span></td>";
                        echo "<td>";
                        echo "<div class='action-btns'>";
                        echo "<a href='read.php?id=" . $row['id'] . "' class='action-btn view-btn' title='View'><i class='fas fa-eye'></i></a>";
                        echo "<a href='update.php?id=" . $row['id'] . "' class='action-btn edit-btn' title='Edit'><i class='fas fa-edit'></i></a>";
                        echo "<a href='delete.php?id=" . $row['id'] . "' class='action-btn delete-btn' title='Delete'><i class='fas fa-trash'></i></a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Simple search functionality
        document.querySelector('.search-bar input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.user-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
<?php mysqli_close($link); ?>