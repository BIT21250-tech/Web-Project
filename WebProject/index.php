<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Royal Electronics Store</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        header {
            background-color: #1e3a8a;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 14px 35px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
            font-weight: bold;
            margin: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-5px);
        }

        .admin-btn {
            background-color: #facc15;
            color: #333;
        }

        .admin-btn:hover {
            background-color: #eab308;
        }

        .hidden-section {
            display: none;
        }

        .products-section {
            margin-top: 50px;
        }

        .products-section h2 {
            color: #1e3a8a;
            text-align: center;
            font-size: 30px;
            margin-bottom: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product-card h3 {
            color: #333;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .product-card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }

        .product-card .price {
            font-size: 20px;
            color: #10b981;
            font-weight: bold;
        }

        .cart-btn {
            background-color: #34d399;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .cart-btn:hover {
            background-color: #059669;
        }

        .logout-btn {
            background-color: #f87171;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }

        .logout-btn:hover {
            background-color: #ef4444;
        }

    </style>
    <script>
        function showSection(sectionId) {
            document.getElementById('landing-section').style.display = 'none';
            document.getElementById(sectionId).style.display = 'block';
        }

        function showLoggedInSection() {
            document.getElementById('landing-section').style.display = 'none';
            document.getElementById('logout-section').style.display = 'block';
        }
    </script>
</head>
<body>

<header>Welcome to Royal Electronics Store</header>

<div class="container">
    <div id="landing-section">
        <h1>Welcome to Our Website</h1>
        <p>Choose an option to get started:</p>
        <a href="login.php" class="btn">Login</a>
        <a href="signup.php" class="btn">Sign Up</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
            <a href="admin.php" class="btn admin-btn">Admin Panel</a>
        <?php } ?>
    </div>

    <div id="logout-section" class="hidden-section">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p>You are logged in as <?php echo $_SESSION['role']; ?>.</p>

        <?php if ($_SESSION['role'] == 'admin') { ?>
            <a href="admin.php" class="btn admin-btn">Admin Panel</a>
        <?php } ?>

        <a href="logout.php" class="logout-btn">Logout</a>

        <div class="products-section">
            <h2>Products Available</h2>
            <div class="product-grid">
                <?php
                $sql = "SELECT * FROM product";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($product = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="product-card">
                            <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <p><?php echo $product['description']; ?></p>
                            <p class="price">$<?php echo $product['price']; ?></p>
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                                <button type="submit" name="add_to_cart" class="cart-btn">Add to Cart</button>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    <?php if (isset($_SESSION['username'])) { ?>
        showLoggedInSection();
    <?php } ?>
</script>
</body>
</html>
