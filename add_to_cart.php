<?php
session_start();

if (isset($_GET['id']) && isset($_GET['price'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $_SESSION['cart'][$id] = [
        'name' => $name,
        'price' => $price,
        'qty' => 1
    ];
    header("Location: index.php?status=added");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>