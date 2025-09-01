<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$pdo = get_pdo_connection();

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: projects.php');
    exit;
}

$projects = $pdo->query('SELECT * FROM projects ORDER BY sort_order, created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6f8; }

        .admin-container { 
            max-width: 1100px; 
            margin: 90px auto 40px; 
            padding: 0 20px; }

        .header { 
            display:flex; 
            justify-content: space-between; 
            align-items:center; 
            margin-bottom: 16px; 
        }

        table { 
            width:100%; 
            border-collapse: collapse;
            background:#fff; 
            border-radius: 12px; 
            overflow:hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }

        th, td { 
            padding: 12px 14px;
            border-bottom: 1px solid #eee; 
            text-align:left; 
        }

        th { 
            background:#fafbfc; 
            color:#2c3e50; 
        }

        td {
        color:#212529;  /* Darker, Bootstrap-like text color */
        }

        .btn { 
            background:#667eea; 
            color:#fff; 
            padding:8px 12px; 
            border-radius:8px; 
            text-decoration:none; 
        }

        .btn.secondary { 
            background:#6c757d; 
        }

        .btn.danger { 
            background:#dc3545; 
        }

    </style>

</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h2>Projects</h2>

            <div>
                <a class="btn secondary" href="dashboard.php">Back</a>
                <a class="btn" href="project_edit.php">Add Project</a>
            </div>

        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Tech</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $p): ?>
                <tr>
                    <td><?php echo (int)$p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['title']); ?></td>
                    <td><?php echo htmlspecialchars($p['tech_stack']); ?></td>
                    <td><?php echo $p['featured'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a class="btn" href="project_edit.php?id=<?php echo (int)$p['id']; ?>">Edit</a>
                        <a class="btn danger" href="?delete=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete this project?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>




