<?php

session_start();

require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$pdo = get_pdo_connection();


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$row = null;

if ($id) {

    $stmt = $pdo->prepare('SELECT * FROM education WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $degree = trim($_POST['degree'] ?? '');
    $institution = trim($_POST['institution'] ?? '');
    $start_year = (int)($_POST['start_year'] ?? 0);
    $end_year = (int)($_POST['end_year'] ?? 0);
    $details = trim($_POST['details'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($id) {

        $stmt = $pdo->prepare('UPDATE education SET degree=?, institution=?, start_year=?, end_year=?, details=?, sort_order=? WHERE id=?');
        $stmt->execute([$degree, $institution, $start_year, $end_year, $details, $sort_order, $id]);

    }
    
    else {
        $stmt = $pdo->prepare('INSERT INTO education (degree, institution, start_year, end_year, details, sort_order) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$degree, $institution, $start_year, $end_year, $details, $sort_order]);
        $id = (int)$pdo->lastInsertId();
    }

    header('Location: education.php');
    exit;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Education</title>
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
            
        .row label { font-weight:600; 
            color:#2c3e50; 
        }

        input[type="text"], textarea, input[type="number"] { 
            width:100%; 
            padding:10px 12px; 
            border:2px solid #e9ecef; 
            border-radius:10px; 
        }


        textarea { 
            min-height: 120px; 
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

        .btn.secondary { 
            background:#6c757d;
         }


    </style>
</head>



<body>

    <div class="admin-container">

        <div class="card">

            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Education</h2>


            <form method="post">

                <div class="row">
                    <label>Degree</label>
                    <input type="text" name="degree" value="<?php echo htmlspecialchars($row['degree'] ?? ''); ?>" required>
                </div>


                <div class="row">
                    <label>Institution</label>
                    <input type="text" name="institution" value="<?php echo htmlspecialchars($row['institution'] ?? ''); ?>" required>
                </div>


                <div class="row">
                    <label>Start Year</label>
                    <input type="number" name="start_year" value="<?php echo (int)($row['start_year'] ?? 0); ?>" min="1900" max="2100">
                </div>


                <div class="row">
                    <label>End Year</label>
                    <input type="number" name="end_year" value="<?php echo (int)($row['end_year'] ?? 0); ?>" min="1900" max="2100">
                </div>


                <div class="row">
                    <label>Details</label>
                    <textarea name="details"><?php echo htmlspecialchars($row['details'] ?? ''); ?></textarea>
                </div>


                <div class="row">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo (int)($row['sort_order'] ?? 0); ?>">
                </div>


                <div class="actions">
                    <a class="btn secondary" href="education.php">Cancel</a>
                    <button class="btn" type="submit">Save</button>
                </div>

                
            </form>
        </div>
    </div>
</body>
</html>




