<?php include 'includes/header.php'; ?>

<style>
    /* Global Styles */
    :root {
        --accent-blue: #0062ff;
        --soft-gray: #f8f9fa;
        --text-dark: #1a1d20;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background-color: #fcfcfc;
        color: var(--text-dark);
    }

    /* Hero Section */
    .hero-banner {
        background: linear-gradient(135deg, #ffffff 0%, #f1f4f9 100%);
        padding: 80px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 50px;
    }

    .hero-title {
        font-size: 3.2rem;
        font-weight: 800;
        letter-spacing: -1.5px;
        color: var(--text-dark);
    }

    /* Product Card Design */
    .product-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .img-wrapper {
        height: 240px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 16px 16px 0 0;
    }

    .product-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .btn-action {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px;
        transition: 0.2s;
    }

    .price-tag {
        font-size: 1.25rem;
        color: var(--accent-blue);
        font-weight: 700;
    }

    /* Back to Top */
    #backToTop {
        display: none;
        position: fixed;
        bottom: 40px;
        right: 40px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--accent-blue);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(0,98,255,0.3);
        z-index: 1000;
    }
</style>

<div class="hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title mb-3">Premium Tech Solutions</h1>
                <p class="lead text-muted mb-4">Discover the latest in high-performance hardware and accessories. Engineered for the future.</p>
                <div class="d-flex gap-3">
                    <a href="#shop" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">Explore Shop</a>
                    <a href="about.php" class="btn btn-outline-dark btn-lg px-4 rounded-pill">Our Story</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-end">
                 <i class="fas fa-microchip fa-10x text-primary opacity-10"></i>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5" id="shop">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <?php 
                $search = $_GET['q'] ?? '';
                echo !empty($search) ? 'Results for: "' . htmlspecialchars($search) . '"' : 'Featured Arrivals'; 
                ?>
            </h2>
            <hr class="w-25">
        </div>
    </div>

    <div class="row justify-content-center">
        <?php
        // Secure query using PDO
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY id DESC");
        $stmt->execute(["%$search%"]);
        $products = $stmt->fetchAll();

        if (count($products) > 0):
            foreach ($products as $row): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <div class="img-wrapper">
                            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
                                 class="product-img" alt="Product">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-dark mb-1">
                                <?php echo htmlspecialchars(substr($row['name'], 0, 35)); ?>
                            </h5>
                            <p class="price-tag mb-4">$<?php echo number_format($row['price'], 2); ?></p>
                            
                            <div class="mt-auto d-grid gap-2">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="add_to_cart.php?id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>&price=<?php echo $row['price']; ?>"
                                        class="btn btn-primary btn-action shadow-sm">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-secondary btn-action">
                                        Login to Purchase
                                    </a>
                                <?php endif; ?>
                                <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-action border">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="col-md-8 text-center py-5">
                <i class="fas fa-search fa-5x text-light mb-4"></i>
                <h3 class="text-muted">No products found</h3>
                <p>We couldn't find anything matching "<?php echo htmlspecialchars($search); ?>".</p>
                <a href="index.php" class="btn btn-primary rounded-pill mt-3 px-5">Refresh Catalog</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<button id="backToTop"><i class="fas fa-chevron-up"></i></button>

<script>
    const btt = document.getElementById("backToTop");
    window.onscroll = () => {
        if (window.scrollY > 500) btt.style.display = "block";
        else btt.style.display = "none";
    };
    btt.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
</script>

<?php include 'includes/footer.php'; ?>