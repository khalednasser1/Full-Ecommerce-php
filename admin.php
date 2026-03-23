<?php

include 'includes/db.php';
include 'includes/header.php';

// 1. Add Product Logic (Upload)
if (isset($_POST['add_product'])) {
    $name  = $_POST['p_name'];
    $price = $_POST['p_price'];
    $img   = $_FILES['p_img']['name'];

    if (!empty($img)) {
        move_uploaded_file($_FILES['p_img']['tmp_name'], "images/" . $img);
        $stmt = $pdo->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $img]);
    }
}

?>

<div class="container mt-4">
    <h2 class="text-center mb-4 text-primary fw-bold">Admin Dashboard</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow border-0 p-3 mb-4">
                <h5 class="fw-bold border-bottom pb-2">Add New Product</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label class="small fw-bold">Product Name</label>
                        <input type="text" name="p_name" class="form-control" placeholder="Enter name" required>
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">Price ($)</label>
                        <input type="number" step="0.01" name="p_price" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Product Image</label>
                        <input type="file" name="p_img" class="form-control" required>
                    </div>
                    <button name="add_product" class="btn btn-success w-100 fw-bold">Upload Product 🚀</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow border-0 p-3 mb-4 text-center">
                <h5 class="fw-bold border-bottom pb-2">Inventory List</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $prods = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
                            foreach ($prods as $p):
                            ?>
                                <tr>
                                    <td><img src="images/<?= $p['image'] ?>" width="50" height="50" class="rounded shadow-sm" style="object-fit: cover;"></td>
                                    <td class="fw-bold"><?= $p['name']?></td>
                                    <td class="text-success fw-bold">$<?= number_format($p['price'], 2) ?></td>
                                    <td>
                                        <a href="admin.php?del_id=<?= $p['id']; ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                            Delete 🗑️
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    if (isset($_GET['del_id'])) {
                        $id = $_GET['del_id'];
                        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
                        $stmt->execute([$id]);
                        $p = $stmt->fetch();
                        if ($p) {
                            unlink("images/" . $p['image']);
                        }
                        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
                        $stmt->execute([$id]);
                        header('location:admin.php');
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card shadow border-0 p-3">
                <h5 class="fw-bold border-bottom pb-2 text-primary">Customer Orders</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Shipping Address</th>
                                <th>Total Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
                            if ($orders):
                                foreach ($orders as $o):
                            ?>
                                    <tr>
                                        <td class="fw-bold">#<?= $o['id'] ?></td>
                                        <td><?=  $o['customer_name'] ?></td>
                                        <td><?=  $o['phone'] ?></td>
                                        <td><?= $o['address'] ?></td>
                                        <td class="fw-bold text-success">$<?= number_format($o['total_amount'], 2) ?></td>
                                    </tr>
                            <?php
                                endforeach;
                            else:
                                echo "<tr><td colspan='5' class='text-center'>No orders found.</td></tr>";
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>