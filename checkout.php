<?php 
// session_start(); 
include 'includes/header.php'; 

// التحقق من تسجيل الدخول أولاً
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to place an order!'); window.location='login.php';</script>";
    exit;
}

// لو الفورم اتبعت
if (isset($_POST['place_order'])) {
    $uid   = $_SESSION['user_id'];
    $name  = htmlspecialchars($_POST['full_name']);
    $addr  = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);

    if (empty($_SESSION['cart'])) {
        echo "<script>alert('Your cart is empty!'); window.location='cart.php';</script>";
        exit;
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // استخراج أول ID منتج (كما في كودك الأصلي)
    $first_product_id = null;
    foreach ($_SESSION['cart'] as $id => $item) {
        $first_product_id = $id;
        break;
    }

    try {
        $pdo->beginTransaction(); // لبدء عملية حفظ مؤمنة (Transaction)

        // 1. حفظ الطلب في جدول orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, customer_name, address, phone, total_amount, product_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$uid, $name, $addr, $phone, $total, $first_product_id]);
        $order_id = $pdo->lastInsertId();

        // 2. حفظ كل المنتجات في order_items
        $stmt_items = $pdo->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $item) {
            $stmt_items->execute([
                $order_id,
                $item['name'],
                $item['price'],
                $item['qty']
            ]);
        }

        $pdo->commit(); // تأكيد الحفظ في الداتابيز
        unset($_SESSION['cart']);

        echo "<div class='container mt-5 py-5 text-center'>
                <i class='fas fa-check-circle fa-5x text-success mb-4'></i>
                <h2 class='fw-bold'>Order Placed Successfully!</h2>
                <p class='lead text-muted'>Thank you, $name. Your Order ID is <span class='text-primary fw-bold'>#$order_id</span></p>
                <a href='index.php' class='btn btn-primary btn-lg rounded-pill mt-3 px-5'>Return to Home</a>
              </div>";
        include 'includes/footer.php';
        exit;

    } catch (Exception $e) {
        $pdo->rollBack(); // في حالة حدوث خطأ، تراجع عن كل شيء
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<style>
    body { background-color: #f8f9fa; }
    .checkout-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: #fff;
    }
    .form-label { font-weight: 600; color: #495057; }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        background-color: #fbfbfb;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #0071e3;
        box-shadow: 0 0 0 0.25; margin-top: rgba(0, 113, 227, 0.1);
    }
    .order-summary-box {
        background-color: #fff;
        border-radius: 20px;
        padding: 30px;
        position: sticky;
        top: 100px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: #6c757d;
    }
    .btn-place-order {
        background-color: #0071e3;
        color: white;
        border-radius: 50px;
        padding: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .btn-place-order:hover {
        background-color: #005bb5;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 113, 227, 0.2);
    }
</style>

<div class="container mt-5 pt-4 mb-5">
    <div class="row gx-5">
        <div class="col-lg-7 mb-4">
            <div class="card checkout-card p-4 p-md-5">
                <h3 class="fw-bold mb-4">Shipping Details</h3>
                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Shipping Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Apartment, Street, City..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="01xxxxxxxxx" required>
                    </div>

                    <div class="mt-5 border-top pt-4">
                        <h5 class="fw-bold mb-3">Payment Method</h5>
                        <div class="form-check p-3 border rounded-3 mb-3">
                            <input class="form-check-input ms-0 me-3" type="radio" checked>
                            <label class="form-check-label">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i> Cash on Delivery (COD)
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="place_order" class="btn btn-place-order w-100 mt-4">
                        Confirm & Place Order <i class="fas fa-check-circle ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="order-summary-box border">
                <h4 class="fw-bold mb-4">Order Summary</h4>
                <div class="mb-4">
                    <?php 
                    $total = 0;
                    if (!empty($_SESSION['cart'])):
                        foreach ($_SESSION['cart'] as $item):
                            $subtotal = $item['price'] * $item['qty'];
                            $total += $subtotal;
                    ?>
                    <div class="summary-item">
                        <span class="text-dark fw-500"><?php echo htmlspecialchars($item['name']); ?> <small class="text-muted">x<?php echo $item['qty']; ?></small></span>
                        <span class="text-dark fw-bold">$<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Shipping</span>
                        <span class="text-success fw-bold">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <h4 class="fw-bold">Total</h4>
                        <h4 class="fw-bold text-primary">$<?php echo number_format($total, 2); ?></h4>
                    </div>
                </div>
                
                <div class="alert alert-light border mt-4 small text-muted">
                    <i class="fas fa-info-circle me-1"></i> Delivery within 3-5 business days.
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>