<?php
include 'includes/db.php';

// 1. Logic: Delete Product (Fisrt thing in the page)
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch();
    if ($p && !empty($p['image'])) {
        $filePath = __DIR__ . "/images/" . $p['image'];
        if (file_exists($filePath)) { unlink($filePath); }
    }
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    header('Location: admin.php');
    exit;
}

// 2. Logic: Add Product
if (isset($_POST['add_product'])) {
    $img = $_FILES['p_img']['name'];
    if (!empty($img)) {
        move_uploaded_file($_FILES['p_img']['tmp_name'], "images/" . $img);
        $stmt = $pdo->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['p_name'], $_POST['p_price'], $img]);
        header('Location: admin.php');
        exit;
    }
}

// 3. Stats
$total_prods = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$revenue = $pdo->query("SELECT SUM(total_amount) FROM orders")->fetchColumn();

include 'includes/header.php'; 
?>

<style>
    :root {
        --admin-accent: #0071e3;
        --card-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }

    body { background-color: #f5f5f7; color: #1d1d1f; }

    /* Stats Cards Styling */
    .stat-card {
        border: none;
        border-radius: 20px;
        background: #fff;
        padding: 25px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 15px;
    }

    /* Table & Forms Card */
    .admin-card {
        border: none;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: var(--card-shadow);
        padding: 30px;
        margin-bottom: 30px;
    }

    .table thead {
        background-color: #fbfbfd;
        color: #86868b;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .table td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f2f2f2; }

    /* Form Styling */
    .form-control {
        border-radius: 12px;
        padding: 12px;
        border: 1px solid #d2d2d7;
        background: #fbfbfd;
        font-size: 0.9rem;
    }
    .form-control:focus { border-color: var(--admin-accent); box-shadow: none; background: #fff; }

    .btn-admin {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .user-pill {
        background: #f5f5f7;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h1 class="fw-bold mb-0">Management Center</h1>
            <p class="text-muted">Welcome back, Administrator</p>
        </div>
        <div class="user-pill border shadow-sm">
            <i class="fas fa-circle text-success me-1 small"></i> System Online
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h6 class="text-muted mb-1">Products</h6>
                <h3 class="fw-bold mb-0"><?= $total_prods ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-success bg-opacity-10 text-success">
                    <i class="fas fa-wallet"></i>
                </div>
                <h6 class="text-muted mb-1">Revenue</h6>
                <h3 class="fw-bold mb-0">$<?= number_format($revenue ?? 0, 2) ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h6 class="text-muted mb-1">Orders</h6>
                <h3 class="fw-bold mb-0"><?= $total_orders ?></h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="admin-card">
                <h5 class="fw-bold mb-4">New Hardware</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Device Name</label>
                        <input type="text" name="p_name" class="form-control" placeholder="e.g. RTX 4090" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Price Tag ($)</label>
                        <input type="number" step="0.01" name="p_price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Hardware Photo</label>
                        <input type="file" name="p_img" class="form-control" required>
                    </div>
                    <button name="add_product" class="btn btn-primary btn-admin w-100 shadow-sm">
                        Add to Inventory <i class="fas fa-plus-circle ms-1"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="admin-card">
                <h5 class="fw-bold mb-4">Product Catalog</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $prods = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
                            foreach ($prods as $p): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="images/<?= $p['image'] ?>?v=<?=time()?>" width="40" height="40" class="rounded-3 me-3" style="object-fit:cover;">
                                        <span class="fw-bold"><?= htmlspecialchars($p['name']) ?></span>
                                    </div>
                                </td>
                                <td class="text-primary fw-600">$<?= number_format($p['price'], 2) ?></td>
                                <td class="text-end">
                                    <a href="admin.php?del_id=<?= $p['id'] ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Erase this item?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="admin-card shadow-sm border-0">
                <h5 class="fw-bold mb-4 text-info"><i class="fas fa-users-cog me-2"></i>Access List</h5>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="bg-light">
                            <tr><th>User</th><th>Email</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $users = $pdo->query("SELECT username, email FROM users ORDER BY id DESC LIMIT 5")->fetchAll();
                            foreach ($users as $u): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($u['username']) ?></td>
                                <td class="text-muted small"><?= htmlspecialchars($u['email']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card shadow-sm border-0">
                <h5 class="fw-bold mb-4 text-warning"><i class="fas fa-history me-2"></i>Recent Sales</h5>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="bg-light">
                            <tr><th>Order #</th><th>Value</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $orders = $pdo->query("SELECT id, total_amount FROM orders ORDER BY id DESC LIMIT 5")->fetchAll();
                            foreach ($orders as $o): ?>
                            <tr>
                                <td class="fw-bold text-dark">ID: <?= $o['id'] ?></td>
                                <td class="text-success fw-bold">$<?= number_format($o['total_amount'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>