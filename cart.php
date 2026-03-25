<?php 

include 'includes/header.php'; 

if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $_SESSION['cart'][$id]['qty'] = max(1, (int)$qty);
    }
    
}
?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --accent-color: #0071e3;
    }

    body { background-color: #f5f5f7; }

    .cart-container {
        max-width: 1000px;
        margin-top: 60px;
    }

    .cart-card {
        border: none;
        border-radius: 20px;
        background: var(--glass-bg);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table thead {
        background-color: #fbfbfd;
        color: #86868b;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .table th, .table td {
        padding: 25px;
        vertical-align: middle;
        border-color: #f2f2f2;
    }

    .qty-input {
        width: 70px;
        border-radius: 10px;
        border: 1px solid #d2d2d7;
        padding: 5px 10px;
        text-align: center;
        font-weight: 600;
    }

    .product-name-cart {
        font-weight: 700;
        color: #1d1d1f;
        font-size: 1.1rem;
    }

    .subtotal-price {
        font-weight: 700;
        color: var(--accent-color);
    }

    /* Summary Section */
    .cart-summary {
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .btn-checkout {
        background-color: var(--accent-color);
        color: white;
        border-radius: 50px;
        font-weight: 700;
        padding: 15px 30px;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        background-color: #0077ed;
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 113, 227, 0.2);
    }

    .empty-cart-ui {
        padding: 100px 0;
        text-align: center;
    }
</style>

<div class="container cart-container mb-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">Review Your Bag <i class="fas fa-shopping-bag ms-2 text-primary"></i></h2>
        <a href="index.php" class="text-decoration-none fw-bold"><i class="fas fa-arrow-left me-1"></i> Continue Shopping</a>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST">
        <div class="card cart-card mb-4">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $id => $item):
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <span class="product-name-cart"><?php echo htmlspecialchars($item['name']); ?></span>
                            </td>
                            <td class="text-center text-muted">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="text-center">
                                <input type="number" name="qty[<?php echo $id; ?>]" 
                                       value="<?php echo $item['qty']; ?>" 
                                       min="1" class="qty-input">
                            </td>
                            <td class="text-center subtotal-price">$<?php echo number_format($subtotal, 2); ?></td>
                            <td class="text-center">
                                <a href="remove_item.php?id=<?php echo $id; ?>" class="btn btn-link text-danger p-0">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="cart-summary">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="fw-bold">Total</h4>
                        <h4 class="fw-bold text-primary">$<?php echo number_format($total, 2); ?></h4>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" name="update_cart" class="btn btn-outline-dark rounded-pill fw-bold">
                            Update Quantities
                        </button>
                        <a href="checkout.php" class="btn btn-checkout mt-2 shadow">
                            Checkout <i class="fas fa-chevron-right ms-2"></i>
                        </a>
                    </div>
                    <p class="text-center text-muted mt-3 small">
                        <i class="fas fa-shield-alt me-1"></i> Secure & Encrypted Payment
                    </p>
                </div>
            </div>
        </div>
    </form>
    
    <?php else: ?>
    <div class="empty-cart-ui bg-white rounded-5 shadow-sm border">
        <div class="mb-4">
            <i class="fas fa-cart-arrow-down fa-5x text-light-emphasis"></i>
        </div>
        <h2 class="fw-bold">Your Bag is Empty</h2>
        <p class="text-muted fs-5">Seems like you haven't added any tech goodies yet.</p>
        <a href="index.php" class="btn btn-primary-premium btn-premium btn-lg mt-3 px-5 py-3 rounded-pill shadow">
            Start Shopping
        </a>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>