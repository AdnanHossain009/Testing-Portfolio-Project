<?php

session_start();

require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$pdo = get_pdo_connection();

// Fetch counts

$counts = [
    'projects' => (int)$pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
    'education' => (int)$pdo->query('SELECT COUNT(*) FROM education')->fetchColumn(),
    'certificates' => (int)$pdo->query('SELECT COUNT(*) FROM certificates')->fetchColumn(),
    'contacts' => (int)$pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn(),
];

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>

        body { 
            background:#f4f6f8; 
        }

        .admin-container { 
            max-width: 1100px; 
            margin: 90px auto 40px; 
            padding: 0 20px;
         }

        .admin-header { 
            display:flex; 
            justify-content: space-between;
            align-items:center; 
            margin-bottom: 20px; 
        }

        .admin-header h1 { 
            font-size:1.6rem;
             color:#2c3e50; 
            }


        .logout { 
            color:#fff; 
            background:#dc3545; 
            border:none;
             padding:10px 14px;
              border-radius:8px; 
              text-decoration:none; 
            }

        .card-grid { 
            display:grid; 
            grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); 
            gap: 16px; 
        }

        .card { 
            background:#fff; 
            border-radius:16px; 
            padding:20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
         }

        .card h3 { 
            margin-bottom:6px; 
            color:#2c3e50; 
        }

        .card p {
    color: #6c757d; /* Medium gray instead of light gray */
    font-weight: 500; /* Slightly bolder */
    margin-bottom: 8px;
    font-size: 0.95rem;
    }

        .actions { 
            margin-top: 10px; 
            display:flex; gap: 8px; 
            flex-wrap: wrap; }

        .actions a { 
            background:#667eea; 
            color:#fff; 
            padding:8px 12px; 
            border-radius:8px; 
            text-decoration:none; 
            font-size:0.9rem; 
        }

        .actions a.secondary { background:#6c757d; }

    </style>
</head>

<body>

    <div class="admin-container">
        <div class="admin-header">

            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
            <a class="logout" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>

        </div>

        <div class="card-grid">
            <div class="card">

                <h3><i class="fas fa-diagram-project"></i> Projects</h3>

                <p><?php echo $counts['projects']; ?> total</p>

                <div class="actions">
                    <a href="projects.php">Manage</a>
                    <a class="secondary" href="project_edit.php">Add New</a>
                </div>

            </div>

            <div class="card">


                <h3><i class="fas fa-user-graduate"></i> Education</h3>
                <p><?php echo $counts['education']; ?> total</p>
                <div class="actions">
                    <a href="education.php">Manage</a>
                    <a class="secondary" href="education_edit.php">Add New</a>
                </div>

            </div>

            <div class="card">

                <h3><i class="fas fa-certificate"></i> Certificates</h3>
                <p><?php echo $counts['certificates']; ?> total</p>
                <div class="actions">
                    <a href="certificates.php">Manage</a>
                    <a class="secondary" href="certificate_edit.php">Add New</a>
                </div>

            </div>

            <div class="card">
                <h3><i class="fas fa-address-card"></i> Profile</h3>
                <p>Update profile & socials</p>
                <div class="actions">
                    <a href="profile.php">Edit Profile</a>
                </div>

            </div>

            <div class="card">
                <h3><i class="fas fa-inbox"></i> Contacts</h3>
                <p><?php echo $counts['contacts']; ?> messages</p>
                <div class="actions">
                    <a href="contacts.php">View</a>
                </div>

            </div>

            <div class="card">

                <h3><i class="fas fa-key"></i> Account</h3>
                <p>Change password</p>
                <div class="actions">
                    <a href="change_password.php">Change Password</a>
                    
                </div>

            </div>

        </div>
    </div>
</body>
</html>




