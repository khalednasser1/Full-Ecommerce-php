<?php include 'includes/header.php'; ?>

<style>
    .product-img {
        width: 100%;
        height: 250px;
        object-fit: contain;
        background-color: #f8f9fa;
        padding: 10px;
    }

    .card {
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
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
    }

    #backToTop:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        #backToTop {
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
        }
    }
</style>

<div class="bg-light py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <h1 class="display-5 fw-bold text-dark">Fresh Collection 2026</h1>
                <h1 class=" fw-bold text-dark">
                    <i class="fas fa-mobile-screen-button "></i>
                    <i class="fas fa-headphones-simple"></i>
                    <i class="fas fa-keyboard"></i>
                    <i class="fas fa-plug"></i>
                    <i class="fas fa-truck-fast"></i>
                </h1>
                <p class="lead text-muted">Quality products delivered to your door. Explore our latest arrivals today.</p>
                <div class="mt-4">
                    <a href="#shop" class="btn btn-primary px-4 py-2 fw-bold">Shop Now</a>
                    <a href="contact.php" class="btn btn-outline-secondary px-4 py-2 ms-md-2">Contact Us</a>
                    <a href="about.php" class="btn btn-outline-secondary px-4 py-2 ms-md-2">About Us</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" id="shop">
    <div class="row">
        <?php
        $search = $_GET['q'] ?? '';


        $stmt = $pdo->query("SELECT * FROM products WHERE name LIKE '%$search%'");
        $products = $stmt->fetchAll(); // هنا السحر: جلبنا كل المنتجات في مصفوفة واحدة


        if (count($products) > 0):
            foreach ($products as $row): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="images/<?php echo $row['image']; ?>" class="card-img-top product-img" style="height:200px; object-fit:contain;" alt="Product">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold"><?php echo substr($row['name'], 0, 20); ?></h6>
                            <p class="text-primary fw-bold mb-3">$<?php echo number_format($row['price'], 2); ?></p>

                            <div class="mt-auto text-center">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="add_to_cart.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>&price=<?php echo $row['price']; ?>"
                                        class="btn btn-outline-dark rounded-pill w-100 fw-bold py-2 m-1">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary rounded-pill w-100 py-2 m-1" disabled>
                                        Login to Buy
                                    </button>
                                <?php endif; ?>

                                <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary w-100 fw-bold py-2 rounded-pill shadow-sm m-1">
                                    <i class="far fa-eye me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No products found for "<?php echo htmlspecialchars($search); ?>"</h3>
                <a href="index.php" class="btn btn-link">Show all products</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<button type="button" id="backToTop" class="btn btn-primary shadow-lg" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>

<?php include 'includes/footer.php'; ?>