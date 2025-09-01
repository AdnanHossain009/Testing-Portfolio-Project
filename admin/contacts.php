<?php

session_start();

require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$pdo = get_pdo_connection();

$rows = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
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
         vertical-align: top;
         }

    th { 
        background:#fafbfc;
         color:#2c3e50;
         }

    /* Fix: Adding dark color for table data */
    td { 
        color: #495057; /* Dark gray for readability */
    }
    
    /* Optional making alternating rows for better readability */
    tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tr:hover {
        background-color: #e3f2fd;
    }
    
    .btn { 
    background:#667eea; 
    color:#fff; 
    padding:8px 12px; 
    border-radius:8px; 
    text-decoration:none;
     }
     
    .btn.secondary { background:#6c757d; }
</style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="admin-container">

        <div class="header">
            <h2>Contacts</h2>
            <div>
                <a class="btn secondary" href="dashboard.php">Back</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>When</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($r['name']); ?></td>
                    <td><?php echo htmlspecialchars($r['email']); ?></td>
                    <td><?php echo htmlspecialchars($r['subject']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($r['message'])); ?></td>
                </tr>

                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>




