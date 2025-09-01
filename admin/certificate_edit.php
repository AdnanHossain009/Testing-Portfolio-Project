<?php
session_start();

require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$pdo = get_pdo_connection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$row = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM certificates WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $issuer = trim($_POST['issuer'] ?? '');
    $issue_date = $_POST['issue_date'] ?? null;
    $credential_url = trim($_POST['credential_url'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($id) {

        $stmt = $pdo->prepare('UPDATE certificates SET name=?, issuer=?, issue_date=?, credential_url=?, sort_order=? WHERE id=?');
        $stmt->execute([$name, $issuer, $issue_date, $credential_url, $sort_order, $id]);

    }
    
    else {
        $stmt = $pdo->prepare('INSERT INTO certificates (name, issuer, issue_date, credential_url, sort_order) VALUES (?,?,?,?,?)');

        $stmt->execute([$name, $issuer, $issue_date, $credential_url, $sort_order]);

        $id = (int)$pdo->lastInsertId();
    }

    header('Location: certificates.php');

    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Certificate</title>
    <link rel="stylesheet" href="../assets/css/style.css">


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


        input[type="text"], input[type="url"], input[type="date"], textarea, input[type="number"] { width:100%; padding:10px 12px; border:2px solid #e9ecef; border-radius:10px; }
        textarea { min-height: 120px; }

        .actions { 
            margin-top:12px;
             display:flex; gap:8px;
             }

        .btn { 
            background:#667eea; 
            color:#fff; padding:10px 14px;
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

            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Certificate</h2>
            <form method="post">

                <div class="row">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" required>
                </div>

                <div class="row">
                    <label>Issuer</label>
                    <input type="text" name="issuer" value="<?php echo htmlspecialchars($row['issuer'] ?? ''); ?>">
                </div>

                <div class="row">
                    <label>Issue Date</label>
                    <input type="date" name="issue_date" value="<?php echo htmlspecialchars($row['issue_date'] ?? ''); ?>">
                </div>

                <div class="row">
                    <label>Credential URL</label>
                    <input type="url" name="credential_url" value="<?php echo htmlspecialchars($row['credential_url'] ?? ''); ?>">
                </div>

                <div class="row">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo (int)($row['sort_order'] ?? 0); ?>">
                </div>

                <div class="actions">
                    <a class="btn secondary" href="certificates.php">Cancel</a>
                    <button class="btn" type="submit">Save</button>
                </div>

                
            </form>
        </div>
    </div>
</body>
</html>




