<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_to_cart') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = intval($_POST['product_price']);
    $product_image = $_POST['product_image'];
    
    // Inisialisasi keranjang
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Tambahkan produk ke keranjang
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => 1
        ];
    }
    
    // Set pesan sukses
    $_SESSION['msg'] = "✅ Produk berhasil ditambahkan ke keranjang!";
    
    // Redirect kembali
    header('Location: index.php');
    exit;
}

header('Location: index.php');
exit;
?>