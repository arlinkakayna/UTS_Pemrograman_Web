<?php
session_start();

// Redirect jika keranjang kosong
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// Data produk untuk checkout
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

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    
    // Simpan data pesanan
    $_SESSION['order'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'payment_method' => $payment_method,
        'items' => $_SESSION['cart'],
        'total' => $total_price,
        'order_date' => date('Y-m-d H:i:s')
    ];
    
    // Kosongkan keranjang
    $_SESSION['cart'] = [];
    
    header('Location: index.php?order=success');
    exit;
}

// Hitung total
$total_price = 0;
$total_items = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
    $total_items += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SKINTIFIC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="brand-header">
        <div class="logo">
            <span>✨</span>
            <h1>SKINTIFIC</h1>
        </div>
        <nav>
            <a href="cart.php" class="nav-cart">🛒 Kembali ke Keranjang</a>
        </nav>
    </header>

    <div class="checkout-container">
        <h2>💖 Checkout</h2>
        
        <div class="checkout-content">
            <div class="checkout-form">
                <h3>📝 Informasi Pengiriman</h3>
                <form method="post">
                    <div class="form-group">
                        <label for="name">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Nomor Telepon *</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Alamat Pengiriman *</label>
                        <textarea id="address" name="address" rows="3" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="payment_method">Metode Pembayaran *</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Pilih metode</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="credit_card">Kartu Kredit</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="cod">COD</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <a href="cart.php" class="btn secondary">Kembali</a>
                        <button type="submit" class="btn primary">💖 Konfirmasi Pesanan</button>
                    </div>
                </form>
            </div>
            
            <div class="order-summary">
                <h3>📦 Ringkasan Pesanan</h3>
                <div class="order-items">
                    <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                        <div class="order-item">
                            <div class="item-info">
                                <div class="item-image">
                                    <div class="image-placeholder x-small">
                                        <span class="image-number"><?php echo $product_id; ?>.jpg</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="item-name"><?php echo $item['name']; ?></div>
                                    <div class="item-quantity">Qty: <?php echo $item['quantity']; ?></div>
                                </div>
                            </div>
                            <div class="item-price">
                                Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-total">
                    <div class="total-row">
                        <span>Total (<?php echo $total_items; ?> items):</span>
                        <span>Rp <?php echo number_format($total_price + 15000, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 SKINTIFIC Official Store | Created with 💖 by [Nama Kamu]</p>
        <p class="footer-sub">STT Mandala - UTS Pemrograman Internet WEB</p>
    </footer>
</body>
</html>