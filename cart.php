<?php 
// session_start(); 
include 'includes/header.php'; 

if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $_SESSION['cart'][$id]['qty'] = max(1, (int)$qty); // لا تقل عن 1
    }
}
?>

<div class="container mt-5">
    <h3>Shopping Cart</h3>

    <form method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                if (!empty($_SESSION['cart'])):
                    foreach ($_SESSION['cart'] as $id => $item):
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['qty']; ?>" min="1" style="width:60px;">
                    </td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <a href="remove_item.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
                <?php 
                    endforeach;
                else: ?>
                <tr>
                    <td colspan="5" class="text-center">Your cart is empty!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h4>Total: $<?php echo number_format($total, 2); ?></h4>

        <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        <p><strong>You Must click on "Update Cart" button and Proceed to "Checkout" button to buy products!</strong></p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>