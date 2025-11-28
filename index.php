<?php
session_start();

// Inisialisasi data produk makeup Skintific
$products = [
    ['id' => 1, 'name' => 'SKINTIFIC 5.5 Calming Toner', 'price' => 189000, 'image' => 'calming-toner.jpg', 'category' => 'Toner', 'rating' => 4.9],
    ['id' => 2, 'name' => 'SKINTIFIC Mugwort Mask', 'price' => 95000, 'image' => 'mugwort-mask.jpg', 'category' => 'Mask', 'rating' => 4.8],
    ['id' => 3, 'name' => 'SKINTIFIC Ceramide Barrier', 'price' => 275000, 'image' => 'ceramide-barrier.jpg', 'category' => 'Moisturizer', 'rating' => 5.0],
    ['id' => 4, 'name' => 'SKINTIFIC Sunscreen Serum', 'price' => 225000, 'image' => 'sunscreen-serum.jpg', 'category' => 'Sunscreen', 'rating' => 4.9],
    ['id' => 5, 'name' => 'SKINTIFIC AHA BHA PHA', 'price' => 198000, 'image' => 'aha-bha-pha.jpg', 'category' => 'Treatment', 'rating' => 4.7],
    ['id' => 6, 'name' => 'SKINTIFIC Salicylic Acid', 'price' => 165000, 'image' => 'salicylic-acid.jpg', 'category' => 'Treatment', 'rating' => 4.8],
    ['id' => 7, 'name' => 'SKINTIFIC Peptide Serum', 'price' => 285000, 'image' => 'peptide-serum.jpg', 'category' => 'Serum', 'rating' => 4.9],
    ['id' => 8, 'name' => 'SKINTIFIC Cica Mask', 'price' => 89000, 'image' => 'cica-mask.jpg', 'category' => 'Mask', 'rating' => 4.6],
    ['id' => 9, 'name' => 'SKINTIFIC Eye Cream', 'price' => 195000, 'image' => 'eye-cream.jpg', 'category' => 'Eye Care', 'rating' => 4.7],
    ['id' => 10, 'name' => 'SKINTIFIC Acne Patch', 'price' => 65000, 'image' => 'acne-patch.jpg', 'category' => 'Treatment', 'rating' => 4.8],
    ['id' => 11, 'name' => 'SKINTIFIC Sleeping Mask', 'price' => 175000, 'image' => 'sleeping-mask.jpg', 'category' => 'Mask', 'rating' => 4.9],
    ['id' => 12, 'name' => 'SKINTIFIC Set Complete Care', 'price' => 550000, 'image' => 'complete-set.jpg', 'category' => 'Bundle', 'rating' => 5.0]
];

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Filter produk berdasarkan kategori
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';
$filtered_products = $products;

if ($selected_category !== 'all') {
    $filtered_products = array_filter($products, function($product) use ($selected_category) {
        return $product['category'] === $selected_category;
    });
}

// Get unique categories
$categories = array_unique(array_column($products, 'category'));
sort($categories);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKINTIFIC - Official Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .brand-header {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 50%, #ffb3c6 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(255, 107, 157, 0.3);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        .logo-icon {
            font-size: 2rem;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
            border-radius: 20px;
            margin-bottom: 3rem;
            box-shadow: 0 8px 32px rgba(255, 107, 157, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: float 20s linear infinite;
        }
        
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-20px, -20px) rotate(360deg); }
        }
        
        .hero-section h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
            border: none;
            color: white;
            position: relative;
            z-index: 2;
        }
        
        .hero-section p {
            font-size: 1.3rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .hero-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
        }
        
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(255, 107, 157, 0.1);
            transition: all 0.3s ease;
            position: relative;
            border: 2px solid transparent;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(255, 107, 157, 0.2);
            border-color: #ff6b9d;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ff6b9d;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 3;
        }
        
        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin: 0.5rem 0;
            color: #ff6b9d;
        }
        
        .star {
            color: #ffd700;
        }
        
        .add-to-cart-btn {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 1rem;
        }
        
        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
        }
        
        .category-filter {
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(255, 107, 157, 0.1);
            border: 2px solid #fff0f5;
        }
        
        .filter-btn {
            padding: 0.7rem 1.8rem;
            background: #fff0f5;
            color: #ff6b9d;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s;
            border: 2px solid transparent;
            font-weight: 600;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
        }
        
        .nav-cart {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .nav-cart:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <header class="brand-header">
        <div class="logo">
            <span class="logo-icon">✨</span>
            <h1>SKINTIFIC SKINCARE</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Produk</a></li>
                <li><a href="cart.php" class="nav-cart">🛒 Keranjang (<span id="cart-count"><?php echo count($_SESSION['cart']); ?></span>)</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="hero-section">
            <h2>Skintific Beauty Hub</h2>
            <p>Dengan Skincare Terbaik Berbasis Sains</p>
            <div class="hero-badge">⭐ Rating 4.9/5 dari 50.000+ Review</div>
        </div>

        <div class="category-filter">
            <h3>Kategori Produk:</h3>
            <div class="filter-buttons">
                <a href="index.php?category=all" class="filter-btn <?php echo $selected_category === 'all' ? 'active' : ''; ?>">All Products</a>
                <?php foreach ($categories as $category): ?>
                    <a href="index.php?category=<?php echo urlencode($category); ?>" class="filter-btn <?php echo $selected_category === $category ? 'active' : ''; ?>">
                        <?php echo $category; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <h2>✨ Best Selling Products</h2>
        <div class="products-grid">
            <?php foreach ($filtered_products as $product): ?>
                <div class="product-card">
                    <?php if ($product['rating'] >= 4.9): ?>
                        <div class="product-badge">🔥 BESTSELLER</div>
                    <?php endif; ?>
                    
                    <div class="product-image">
                        <img src="https://via.placeholder.com/250x250/FF6B9D/FFFFFF?text=SKINTIFIC" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['name']; ?></h3>
                        <div class="product-rating">
                            <span class="star">⭐</span>
                            <span><?php echo $product['rating']; ?></span>
                            <span class="product-category">• <?php echo $product['category']; ?></span>
                        </div>
                        <p class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                        <form method="post" action="process.php">
                            <input type="hidden" name="action" value="add_to_cart">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                            <button type="submit" class="add-to-cart-btn">💖 Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SKINTIFIC Official Store | By Arlinka Kayna</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('added') === 'true') {
                alert('✨ Produk berhasil ditambahkan ke keranjang!');
            }
            if (urlParams.get('order') === 'success') {
                alert('🎉 Terima kasih! Pesanan Anda berhasil dibuat!');
            }
        });
    </script>
</body>
</html>