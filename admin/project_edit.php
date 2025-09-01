<?php

session_start();

require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
     header('Location: login.php');
      exit; 
    }

$pdo = get_pdo_connection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    $project = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tech_stack = trim($_POST['tech_stack'] ?? '');

    $live_url = trim($_POST['live_url'] ?? '');
    $source_url = trim($_POST['source_url'] ?? '');
    $icon = trim($_POST['icon'] ?? 'fas fa-code');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($id) {

        $stmt = $pdo->prepare('UPDATE projects SET title=?, description=?, tech_stack=?, live_url=?, source_url=?, icon=?, featured=?, sort_order=? WHERE id=?');
        $stmt->execute([$title, $description, $tech_stack, $live_url, $source_url, $icon, $featured, $sort_order, $id]);
    }
    
    else {
        $stmt = $pdo->prepare('INSERT INTO projects (title, description, tech_stack, live_url, source_url, icon, featured, sort_order) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([$title, $description, $tech_stack, $live_url, $source_url, $icon, $featured, $sort_order]);
        $id = (int)$pdo->lastInsertId();
    }

    header('Location: projects.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Project</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <style>

        body { 
            background:#f4f6f8; 
        }

        .admin-container { 
            max-width: 900px; 
            margin: 90px auto 40px; 
            padding: 0 20px; 
        }


        .card { 
            background:#fff;
             border-radius:16px; 
             padding:20px; 
             box-shadow: 0 10px 30px rgba(0,0,0,0.08);
             }


        .row { 
            display:grid; 
            grid-template-columns:1fr; 
            gap:12px; 
        }

        .row label { 
            font-weight:600; 
            color:#2c3e50; 
        }

        input[type="text"], input[type="url"], textarea, input[type="number"] { 
            width:100%; 
            padding:10px 12px;
            border:2px solid #e9ecef; 
            border-radius:10px;
         }


        textarea { 
            min-height: 120px;
         }
         
        .actions { margin-top:12px; 
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

        .btn.secondary { 
            background:#6c757d; 
        }

    </style>
</head>

<body>

    <div class="admin-container">

        <div class="card">

            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Project</h2>

            <form method="post">

                <div class="row">
                    <label>Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($project['title'] ?? ''); ?>" required>
                </div>

                <div class="row">
                    <label>Description</label>
                    <textarea name="description" required><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                </div>

                <div class="row">
                    <label>Tech Stack (comma separated)</label>
                    <input type="text" name="tech_stack" value="<?php echo htmlspecialchars($project['tech_stack'] ?? ''); ?>">
                </div>

                <div class="row">
                    <label>Live URL</label>
                    <input type="url" name="live_url" value="<?php echo htmlspecialchars($project['live_url'] ?? ''); ?>">
                </div>

                <div class="row">
                    <label>Source URL</label>
                    <input type="url" name="source_url" value="<?php echo htmlspecialchars($project['source_url'] ?? ''); ?>">
                </div>

                <div class="row">
                    <label>Icon (Font Awesome class)</label>
                    <input type="text" name="icon" value="<?php echo htmlspecialchars($project['icon'] ?? 'fas fa-code'); ?>">
                </div>

                <div class="row">
                    <label>Featured</label>
                    <input type="checkbox" name="featured" <?php echo !empty($project['featured']) ? 'checked' : ''; ?>>
                </div>

                <div class="row">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo (int)($project['sort_order'] ?? 0); ?>">
                </div>

                <div class="actions">
                    <a class="btn secondary" href="projects.php">Cancel</a>
                    <button class="btn" type="submit">Save</button>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>




