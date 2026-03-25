<?php include 'includes/header.php'; ?>

<style>

    .product-img {
        width: 100%;
        height: 250px;
        object-fit: contain;
        background-color: #ffffff;
        padding: 15px;
        transition: transform 0.5s ease;
    }

    .card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
    }

    .card:hover .product-img {
        transform: scale(1.05);
    }

    #backToTop {
        display: none;
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: #0d6efd;
        color: white;
        cursor: pointer;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    #backToTop:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        #backToTop {
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
        }
    }
</style>

<div class="bg-light py-5 mb-5 shadow-sm">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-md-7 text-center text-md-start">
                <h1 class="display-4 fw-bold text-dark mb-3">TechGear Collection 2026</h1>
                <div class="h2 mb-4 text-primary">
                    <i class="fas fa-mobile-screen-button me-2"></i>
                    <i class="fas fa-headphones-simple me-2"></i>
                    <i class="fas fa-keyboard me-2"></i>
                    <i class="fas fa-plug me-2"></i>
                    <i class="fas fa-truck-fast text-success"></i>
                </div>
                <p class="lead text-muted mb-4">أفضل المنتجات التقنية بين يديك. جودة، ضمان، وسرعة في التوصيل.</p>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                    <a href="#shop" class="btn btn-primary btn-lg px-4 fw-bold rounded-pill shadow">Shop Now</a>
                    <a href="contact.php" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">Contact Us</a>
                </div>
            </div>
            <div class="col-md-5 d-none d-md-block text-center">
                <i class="fas fa-laptop-code fa-10x text-primary opacity-25"></i>
            </div>
        </div>
    </div>
</div>

<div class="container" id="shop">
    <div class="row mb-4">
        <div class="col-12 border-bottom pb-2">
            <h3 class="fw-bold">
                <?php echo isset($_GET['q']) && !empty($_GET['q']) ? 'Search Results for: "' . htmlspecialchars($_GET['q']) . '"' : 'Featured Products'; ?>
            </h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <?php
        $search = $_GET['q'] ?? '';

        // الأمان: استخدام Prepared Statements لحماية الداتا بيز
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY id DESC");
        $stmt->execute(["%$search%"]);
        $products = $stmt->fetchAll();

        if (count($products) > 0):
            foreach ($products as $row): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative overflow-hidden">
                             <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold text-dark mb-2">
                                <?php echo htmlspecialchars(substr($row['name'], 0, 40)); ?>...
                            </h6>
                            <div class="mb-3">
                                <span class="h5 text-primary fw-bold">$<?php echo number_format($row['price'], 2); ?></span>
                            </div>

                            <div class="mt-auto d-grid gap-2">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="add_to_cart.php?id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>&price=<?php echo $row['price']; ?>"
                                        class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm">
                                        <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-secondary rounded-pill py-2">
                                        Login to Buy
                                    </a>
                                <?php endif; ?>

                                <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-light rounded-pill fw-bold py-2 border">
                                    <i class="far fa-eye me-1"></i> Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-search-minus fa-5x text-light-emphasis"></i>
                </div>
                <h3 class="text-muted mb-4">No products found for "<?php echo htmlspecialchars($search); ?>"</h3>
                <p class="text-muted">Try searching for something else or browse our full collection.</p>
                <a href="index.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow">Show All Products</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<button type="button" id="backToTop" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>

    let mybutton = document.getElementById("backToTop");
    window.onscroll = function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    };
    mybutton.onclick = function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };
</script>

<?php include 'includes/footer.php'; ?>