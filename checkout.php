<?php
// session_start();
include 'includes/header.php';

// لو الفورم اتبعت
if (isset($_POST['place_order'])) {

    $uid   = $_SESSION['user_id'];
    $name  = $_POST['full_name'];
    $addr  = $_POST['address'];
    $phone = $_POST['phone'];

    
    if (empty($_SESSION['cart'])) {
        echo "<script>alert('Your cart is empty!'); window.location='cart.php';</script>";
        exit;
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }

    
    $first_product_id = null;
    foreach ($_SESSION['cart'] as $id => $item) {
        $first_product_id = $id; // نفترض id المنتج مطابق للـ products.id
        break;
    }

    // حفظ الطلب في جدول orders
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, customer_name, address, phone, total_amount, product_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$uid, $name, $addr, $phone, $total, $first_product_id]);

    $order_id = $pdo->lastInsertId();

    // حفظ كل المنتجات في order_items
    $stmt_items = $pdo->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $item) {
        $stmt_items->execute([
            $order_id,
            $item['name'],
            $item['price'],
            $item['qty']
        ]);
    }

    // تفريغ الكارت
    unset($_SESSION['cart']);

    echo "<script>alert('Order Placed Successfully! Your Order ID is #$order_id'); window.location='index.php';</script>";
}
?>

<div class="container mt-5">
    <h3>Checkout</h3>

    <!-- الفورم -->
    <form method="POST">
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Shipping Address</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <button type="submit" name="place_order" class="btn btn-primary">Confirm & Place Order</button>
    </form>

    <hr>

    <h4>Order Summary</h4>
    <?php 
    $total = 0;
    if (!empty($_SESSION['cart'])):
        foreach ($_SESSION['cart'] as $item):
            $subtotal = $item['price'] * $item['qty'];
            $total += $subtotal;
    ?>
    <p>
        <?php echo $item['name'] ?> (x<?php echo $item['qty']; ?>) = $<?php echo number_format($subtotal, 2); ?>
    </p>
    <?php 
        endforeach;
    else: ?>
    <p>Your cart is empty!</p>
    <?php endif; ?>

    <h3>Total: $<?php echo number_format($total, 2); ?></h3>
</div>

<?php include 'includes/footer.php'; ?>