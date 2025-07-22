<?php
session_start();

// Redirect if no promotion type set
if (!isset($_SESSION['promotion_type']) || empty($_SESSION['promotion_type'])) {
    header('Location: form.php');
    exit;
}

$selected_promotions = $_SESSION['promotion_type'];
$packages = [];

// Determine packages based on selected promotions
if (in_array('all', $selected_promotions)) {
    $packages[] = [
        'name' => 'Google Business Profile Optimization & Promotion',
        'price' => 3300
    ];
    $packages[] = [
        'name' => 'Social Media Page Promotion',
        'price' => 3000
    ];
    $packages[] = [
        'name' => 'Website SEO & UX Optimization Package',
        'price' => 2500
    ];
} else {
    if (in_array('google', $selected_promotions)) {
        $packages[] = [
            'name' => 'Google Business Profile Optimization & Promotion',
            'price' => 3300
        ];
    }

    if (in_array('social', $selected_promotions)) {
        $packages[] = [
            'name' => 'Social Media Page Promotion',
            'price' => 3000
        ];
    }

    if (in_array('website', $selected_promotions)) {
        $packages[] = [
            'name' => 'Website SEO & UX Optimization Package',
            'price' => 2500
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Packages - Digital Orton</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .packages-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .package-card {
            background: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 15px;
            padding: 20px;
            width: 280px;
            transition: all 0.3s ease;
            position: relative;
        }

        .package-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .package-card input[type="checkbox"] {
            position: absolute;
            top: 16px;
            left: 16px;
            transform: scale(1.2);
        }

        .package-card h3 {
            margin: 10px 0 5px 30px;
            color: #667eea;
            font-size: 1.1rem;
        }

        .package-card p {
            margin-left: 30px;
            font-size: 0.95rem;
            color: #555;
        }

        .btn-center {
            text-align: center;
            margin-top: 30px;
        }

        .select-package-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 60px;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .select-package-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Your Package</h2>

        <form method="POST" action="subtotal.php">
            <div class="packages-grid">
                <?php foreach ($packages as $pkg): ?>
                    <label class="package-card">
                        <input type="checkbox" name="selected_packages[]" value="<?php echo $pkg['name'] . '|' . $pkg['price']; ?>">
                        <h3><?php echo htmlspecialchars($pkg['name']); ?></h3>
                        <p>Price: ₹<?php echo number_format($pkg['price'], 2); ?>/-</p>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="btn-center">
                <button type="submit" class="select-package-btn">Proceed to Billing</button>
            </div>
        </form>
    </div>
</body>
</html>