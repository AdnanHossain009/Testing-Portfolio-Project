<?php
session_start();

require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$pdo = get_pdo_connection();

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM certificates WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: certificates.php');
    exit;
}

$rows = $pdo->query('SELECT * FROM certificates ORDER BY sort_order, issue_date DESC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Certificates</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body {
             background:#f4f6f8;
             }
    
        .admin-container { 
            max-width: 1100px; 
            margin: 90px auto 40px; 
            padding: 0 20px; 
        }

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

        .btn { background:#667eea; color:#fff; padding:8px 12px; border-radius:8px; text-decoration:none; }

        .btn.secondary { background:#6c757d; }

        .btn.danger { background:#dc3545; }

    </style>
</head>

<body>

    <div class="admin-container">
        <div class="header">

            <h2>Certificates</h2>
            <div>
                <a class="btn secondary" href="dashboard.php">Back</a>
                <a class="btn" href="certificate_edit.php">Add</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Issuer</th>
                    <th>Issued</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($rows as $r): ?>

                <tr>
                    <td><?php echo (int)$r['id']; ?></td>
                    <td><?php echo htmlspecialchars($r['name']); ?></td>
                    <td><?php echo htmlspecialchars($r['issuer']); ?></td>
                    <td><?php echo htmlspecialchars($r['issue_date']); ?></td>
                    <td>

                        <a class="btn" href="certificate_edit.php?id=<?php echo (int)$r['id']; ?>">Edit</a>
                        <a class="btn danger" href="?delete=<?php echo (int)$r['id']; ?>" onclick="return confirm('Delete this item?');">Delete</a>
                    </td>

                </tr>
                
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>




