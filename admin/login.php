<?php

session_start();

require_once __DIR__ . '/../includes/db.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Checking for remember me cookie
if (empty($_SESSION['admin_id']) && !empty($_COOKIE['remember_me'])) {
    $pdo = get_pdo_connection();
    
    // Retrieve token from cookie
    list($selector, $validator) = explode(':', $_COOKIE['remember_me']);
    
    // Check if token exists in database
    $stmt = $pdo->prepare('SELECT * FROM auth_tokens WHERE selector = ? AND expires >= NOW()');
    $stmt->execute([$selector]);
    $token = $stmt->fetch();
    
    if ($token && password_verify($validator, $token['validator_hash'])) {
        // Valid token - get admin data and log in
        $stmt = $pdo->prepare('SELECT id, name, email FROM admins WHERE id = ?');
        $stmt->execute([$token['admin_id']]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header('Location: dashboard.php');
            exit;
        }
    }
    
    // If token is invalid, clear the cookie
    setcookie('remember_me', '', time() - 3600, '/');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember_me = isset($_POST['remember_me']);

    if ($email && $password) {
        $pdo = get_pdo_connection();
        $stmt = $pdo->prepare('SELECT id, name, email, password_hash FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);

        $admin = $stmt->fetch();

        // In my login processing code:
if ($admin && password_verify($password, $admin['password_hash'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    
    // Handle "Remember Me" functionality
    if ($remember_me) {
        // Generate a secure token
        $selector = bin2hex(random_bytes(12));
        $validator = bin2hex(random_bytes(32));
        $validator_hash = password_hash($validator, PASSWORD_DEFAULT);
        $expires = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30); // 30 days
        
        // Store token in database
        $stmt = $pdo->prepare('INSERT INTO auth_tokens (selector, validator_hash, admin_id, expires) VALUES (?, ?, ?, ?)');
        $stmt->execute([$selector, $validator_hash, $admin['id'], $expires]);
        
        // Set cookie with selector:validator (30 days expiration)
        setcookie('remember_me', $selector . ':' . $validator, time() + 60 * 60 * 24 * 30, '/');
    }
    
    header('Location: dashboard.php');
    exit;
}
        
        else {
            $error = 'Invalid email or password';
        }
    } else {
        $error = 'Please enter email and password';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { 
            background:#f4f6f8;
         }

        .login-wrapper { 
            max-width: 420px; 
            margin: 120px auto;
             background: #fff; 
             padding: 30px; 
             border-radius: 16px;
              box-shadow: 0 10px 30px rgba(0,0,0,0.08);
             }

        .login-wrapper h1 { 
            font-size: 1.6rem; 
            margin-bottom: 1rem; 
            color:#2c3e50; 
        }

        .login-wrapper .form-group { 
            margin-bottom: 1rem; 
        }

        .login-wrapper input { 
            width: 100%;
             padding: 12px 14px;
              border: 2px solid #e9ecef;
               border-radius: 10px; 
               font-size: 1rem; 
            }

        .login-wrapper button { 
            width: 100%; 
            padding: 12px; 
            border: none; 
            border-radius: 10px;
             background: #667eea; color:#fff; 
             font-weight:600; 
             cursor:pointer; 
            }

        .login-wrapper button:hover { 
            background:#5568d6; 
        }

        .error { 
            background:#ffe3e3;
             color:#c62828;
              padding:10px 12px; 
              border-radius:10px; 
              margin-bottom:12px;
             }
        
        /* Password toggle styles */
        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-wrapper input {
            width: 100%;
            padding-right: 40px; /* leave space for the eye icon */
            box-sizing: border-box;
        }

        .password-input-wrapper .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6c757d;
            font-size: 18px;
            padding: 0;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
            height: auto;
        }

        .password-toggle:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
        }
        .password-toggle.show {
            color: #007bff;
            background: rgba(0, 123, 255, 0.15);
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .remember-me input {
            width: auto;
            margin-right: 8px;
        }
        
        /* FIX: Changed text color to be more visible */
        .remember-me label {
            color: #5a6268; /* Darker gray for better visibility */
            font-size: 0.95rem;
            cursor: pointer;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="login-wrapper">
        <h1><i class="fas fa-shield-alt"></i> Admin Login</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <div class="password-input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="remember-me">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Keep me logged in</label>
            </div>

            <button type="submit">Sign In</button>
            <p style="margin-top:10px;color:#6c757d;font-size:0.9rem;">Default: admin@example.com / admin123</p>
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