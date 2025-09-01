<?php

session_start();

require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$pdo = get_pdo_connection();

// Ensure a profile row exists

$pdo->exec('INSERT INTO profile (full_name, title) SELECT "Adnan Hossain Siraz", "Full Stack Developer" WHERE NOT EXISTS (SELECT 1 FROM profile)');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'title' => trim($_POST['title'] ?? ''),
        'about' => trim($_POST['about'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'location' => trim($_POST['location'] ?? ''),
        'github' => trim($_POST['github'] ?? ''),
        'linkedin' => trim($_POST['linkedin'] ?? ''),
        'twitter' => trim($_POST['twitter'] ?? ''),
        'instagram' => trim($_POST['instagram'] ?? ''),
    ];

    $stmt = $pdo->prepare('UPDATE profile SET full_name=:full_name, title=:title, about=:about, email=:email, phone=:phone, location=:location, github=:github, linkedin=:linkedin, twitter=:twitter, instagram=:instagram ORDER BY id ASC LIMIT 1');
    $stmt->execute($data);
}


$profile = $pdo->query('SELECT * FROM profile ORDER BY id ASC LIMIT 1')->fetch();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body { 
            background:#f4f6f8;
         }

        .admin-container { 
            max-width: 1000px; 
            margin: 90px auto 40px; 
            padding: 0 20px;
         }

        .card { 
            background:#fff;
             border-radius:16px; 
             padding:20px; 
             box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
            }

            
        .grid { 
            display:grid; 
            grid-template-columns:1fr 1fr; 
            gap:14px; 
        }

        .grid .full { 
            grid-column: 1 / -1; 
        }

        label { 
            font-weight:600; 
            color:#2c3e50; 
        }

        input, textarea { 
            width:100%; 
            padding:10px 12px; 
            border:2px solid #e9ecef; 
            border-radius:10px; 
        }

        textarea { 
            min-height: 140px; 
        }

        .actions { 
            margin-top:12px; 
            display:flex;
             gap:8px; 
            }
            
        .btn { 
            background:#667eea; 
            color:#fff; 
            padding:10px 14px; 
            border-radius:8px; 
            text-decoration:none; 
            border:none; 
            cursor:pointer;
         }


        .btn.secondary { background:#6c757d; }
    </style>
</head>

<body>

    <div class="admin-container">
        <div class="card">

            <h2>Edit Profile</h2>

            <form method="post">
                <div class="grid">

                    <div>
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($profile['full_name'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($profile['title'] ?? ''); ?>" required>
                    </div>

                    <div class="full">
                        <label>About</label>
                        <textarea name="about"><?php echo htmlspecialchars($profile['about'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="text" name="email" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>">
                    </div>

                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
                    </div>

                    <div>
                        <label>Location</label>
                        <input type="text" name="location" value="<?php echo htmlspecialchars($profile['location'] ?? ''); ?>">
                    </div>

                    <div class="full">
                        <label>GitHub</label>
                        <input type="text" name="github" value="<?php echo htmlspecialchars($profile['github'] ?? ''); ?>">
                    </div>

                    <div class="full">
                        <label>LinkedIn</label>
                        <input type="text" name="linkedin" value="<?php echo htmlspecialchars($profile['linkedin'] ?? ''); ?>">
                    </div>

                    <div class="full">
                        <label>Twitter</label>
                        <input type="text" name="twitter" value="<?php echo htmlspecialchars($profile['twitter'] ?? ''); ?>">
                    </div>

                    <div class="full">
                        <label>Instagram</label>
                        <input type="text" name="instagram" value="<?php echo htmlspecialchars($profile['instagram'] ?? ''); ?>">
                    </div>

                </div>

                <div class="actions">
                    <a class="btn secondary" href="dashboard.php">Back</a>
                    <button class="btn" type="submit">Save</button>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>




