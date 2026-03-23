<?php 
include 'includes/header.php'; 

// 1. استلام الـ ID من الرابط
$id = $_GET['id'] ;

if (!$id) {
    echo "<div class='container mt-5'><h3>Product not found!</h3></div>";
    include 'includes/footer.php';
}

// 2. جلب بيانات المنتج ده بس
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<div class='container mt-5'><h3>Product not found!</h3></div>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="container mt-5 py-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 p-3">
                <img src="images/<?php echo $product['image']; ?>" class="img-fluid rounded" alt="Product Image" style="max-height: 500px; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Product Details</li>
                </ol>
            </nav>
            
            <h1 class="display-5 fw-bold text-dark"><?php echo $product['name']; ?></h1>
            <h3 class="text-primary fw-bold my-4">$<?php echo number_format($product['price'], 2); ?></h3>
            
            <p class="lead text-muted mb-5">
                <?php echo $product['description'] ?? 'No description available for this product yet.'; ?>
            </p>

            <div class="d-grid gap-2 d-md-block">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="add_to_cart.php?id=<?php echo $product['id']; ?>&name=<?php echo $product['name']; ?>&price=<?php echo $product['price']; ?>" 
                       class="btn btn-dark btn-lg px-5 py-3 fw-bold">
                       Add to Cart 🛒
                    </a>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg px-5 py-3" disabled>Login to Buy</button>
                <?php endif; ?>
                
                <a href="index.php" class="btn btn-outline-secondary btn-lg px-4 py-3 ms-md-2">↩ Back to Shop</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
