<?php
session_start();

// Data produk untuk cart
$products = [
    1 => ['name' => 'SKINTIFIC 5.5 Calming Toner', 'price' => 189000, 'category' => 'Toner', 'image' => '1.jpg'],
    2 => ['name' => 'SKINTIFIC Mugwort Mask', 'price' => 95000, 'category' => 'Mask', 'image' => '2.jpg'],
    3 => ['name' => 'SKINTIFIC Ceramide Barrier', 'price' => 275000, 'category' => 'Moisturizer', 'image' => '3.jpg'],
    4 => ['name' => 'SKINTIFIC Sunscreen Serum', 'price' => 225000, 'category' => 'Sunscreen', 'image' => '4.jpg'],
    5 => ['name' => 'SKINTIFIC AHA BHA PHA', 'price' => 198000, 'category' => 'Treatment', 'image' => '5.jpg'],
    6 => ['name' => 'SKINTIFIC Salicylic Acid', 'price' => 165000, 'category' => 'Treatment', 'image' => '6.jpg'],
    7 => ['name' => 'SKINTIFIC Peptide Serum', 'price' => 285000, 'category' => 'Serum', 'image' => '7.jpg'],
    8 => ['name' => 'SKINTIFIC Cica Mask', 'price' => 89000, 'category' => 'Mask', 'image' => '8.jpg'],
    9 => ['name' => 'SKINTIFIC Eye Cream', 'price' => 195000, 'category' => 'Eye Care', 'image' => '9.jpg'],
    10 => ['name' => 'SKINTIFIC Acne Patch', 'price' => 65000, 'category' => 'Treatment', 'image' => '10.jpg'],
    11 => ['name' => 'SKINTIFIC Sleeping Mask', 'price' => 175000, 'category' => 'Mask', 'image' => '11.jpg'],
    12 => ['name' => 'SKINTIFIC Set Complete Care', 'price' => 550000, 'category' => 'Bundle', 'image' => '12.jpg']
];

// Proses aksi keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'remove_from_cart' && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['msg'] = "🗑️ Produk berhasil dihapus dari keranjang!";
        }
    } elseif ($_POST['action'] === 'update_cart' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = intval($_POST['quantity']);
        
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['msg'] = "🗑️ Produk berhasil dihapus dari keranjang!";
        } else {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            $_SESSION['msg'] = "✨ Jumlah produk berhasil diupdate!";
        }
    } elseif ($_POST['action'] === 'clear_cart') {
        $_SESSION['cart'] = [];
        $_SESSION['msg'] = "🧹 Keranjang berhasil dikosongkan!";
    }
    
    header('Location: cart.php');
    exit;
}

// Hitung total
$total_price = 0;
$total_items = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
        $total_items += $item['quantity'];
    }
}

// Notifikasi
$msg = "";
if (!empty($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - SKINTIFIC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="brand-header">
        <div class="logo">
            <span>✨</span>
            <h1>SKINTIFIC</h1>
        </div>
        <nav>
            <a href="index.php" class="nav-cart">🏠 Kembali ke Produk</a>
        </nav>
    </header>

    <?php if (!empty($msg)): ?>
        <div class="message"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="cart-container">
        <div class="cart-header">
            <h2>🛒 Keranjang Belanja</h2>
            <span class="cart-stats"><?php echo $total_items; ?> items</span>
        </div>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <div class="empty-icon">🛒</div>
                <h3>Keranjang belanja Anda kosong</h3>
                <p>Yuk, temukan produk skincare terbaik!</p>
                <a href="index.php" class="btn primary">Jelajahi Produk</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                        <div class="cart-item">
                            <div class="item-image">
                                <div class="image-placeholder small">
                                    <span class="image-number"><?php echo $product_id; ?>.jpg</span>
                                </div>
                            </div>
                            <div class="item-details">
                                <h3><?php echo $item['name']; ?></h3>
                                <p class="item-category"><?php echo $products[$product_id]['category']; ?></p>
                                <p class="item-price">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?> / item</p>
                            </div>
                            <div class="item-controls">
                                <form method="post" class="quantity-form">
                                    <input type="hidden" name="action" value="update_cart">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <label>Qty:</label>
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10" class="quantity-input">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>
                                <form method="post" class="remove-form">
                                    <input type="hidden" name="action" value="remove_from_cart">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <button type="submit" class="remove-btn">🗑️ Hapus</button>
                                </form>
                            </div>
                            <div class="item-total">
                                <p class="total-price">Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h3>📋 Ringkasan Belanja</h3>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal (<?php echo $total_items; ?> items):</span>
                            <span>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim:</span>
                            <span>Rp 15.000</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Pembayaran:</span>
                            <span>Rp <?php echo number_format($total_price + 15000, 0, ',', '.'); ?></span>
                        </div>
                    </div>
                    <div class="cart-actions">
                        <form method="post">
                            <input type="hidden" name="action" value="clear_cart">
                            <button type="submit" class="btn secondary" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                🧹 Kosongkan Keranjang
                            </button>
                        </form>
                        <a href="checkout.php" class="btn primary">💖 Lanjut ke Checkout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 SKINTIFIC Official Store | Created with 💖 by [Nama Kamu]</p>
        <p class="footer-sub">STT Mandala - UTS Pemrograman Internet WEB</p>
    </footer>
</body>
</html>