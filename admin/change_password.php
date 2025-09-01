<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Checking if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $message = 'All fields are required!';
        $messageType = 'error';
    }
    elseif ($newPassword !== $confirmPassword) {
        $message = 'New passwords do not match!';
        $messageType = 'error';
    }
    elseif (strlen($newPassword) < 6) {
        $message = 'New password must be at least 6 characters!';
        $messageType = 'error';
    }
    else {

        try {
            $pdo = get_pdo_connection();
            
            // Getting current admin info

            $stmt = $pdo->prepare('SELECT password_hash FROM admins WHERE id = ?');
            $stmt->execute([$_SESSION['admin_id']]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($currentPassword, $admin['password_hash'])) {

                // Updating the password
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE admins SET password_hash = ? WHERE id = ?');
                $stmt->execute([$newHash, $_SESSION['admin_id']]);
                
                $message = 'Password updated successfully!';
                $messageType = 'success';

            }
            else {
                $message = 'Current password is incorrect!';
                $messageType = 'error';
            }

        }
        catch (Exception $e) {
            $message = 'Error updating password: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .admin-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .admin-nav {
            background: #333;
            padding: 15px 0;
            margin-bottom: 30px;
        }
        .admin-nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .admin-nav h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            background: #007bff;
        }
        .admin-nav a:hover {
            background: #0056b3;
        }
        
        /* Password toggle styles */

        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-input-wrapper input {
            padding-right: 60px;
        }
        .password-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s;
            font-size: 16px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        .password-toggle:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
        }
        .password-toggle.show {
            color: #007bff;
            background: rgba(0, 123, 255, 0.15);
        }
    </style>
</head>


<body>
    <nav class="admin-nav">
        <div class="container">
            <h1>Admin Panel</h1>
            <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <h2>Change Password</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">

            <div class="form-group">
                <label for="current_password">Current Password:</label>

                <div class="password-input-wrapper">
                    <input type="password" id="current_password" name="current_password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">

                <label for="new_password">New Password:</label>

                <div class="password-input-wrapper">
                    <input type="password" id="new_password" name="new_password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">

                <label for="confirm_password">Confirm New Password:</label>

                <div class="password-input-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                        <i class="fas fa-eye"></i>
                    </button>

                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">Change Password</button>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>

        </form>
    </div>
    
    <script>
        
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.nextElementSibling;
            const icon = toggle.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
                toggle.classList.add('show');
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
                toggle.classList.remove('show');
            }
        }
    </script>
</body>
</html>
