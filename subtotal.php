<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure packages were selected
if (!isset($_POST['selected_packages']) || empty($_POST['selected_packages'])) {
    header("Location: packages.php");
    exit;
}

// Save selected package details in session
$selected = $_POST['selected_packages'];
$packages = [];
$subtotal = 0;

foreach ($selected as $item) {
    list($name, $price) = explode('|', $item);
    $price = floatval($price);
    $packages[] = ['name' => $name, 'price' => $price];
    $subtotal += $price;
}

$tax = $subtotal * 0.18;
$total = $subtotal + $tax;

$_SESSION['selected_packages'] = $packages;
$_SESSION['subtotal'] = $subtotal;
$_SESSION['tax'] = $tax;
$_SESSION['total'] = $total;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing Summary - Digital Orton</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .summary-table th, .summary-table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        .summary-table th {
            background: #667eea;
            color: white;
        }
        .total-row {
            font-weight: bold;
            background: #f8f9fa;
        }
        .btn-center {
            text-align: center;
        }
        .continue-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 60px;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Billing Summary</h2>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Price (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $pkg): ?>
                    <tr>
                        <td><?= htmlspecialchars($pkg['name']) ?></td>
                        <td><?= number_format($pkg['price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td>Subtotal</td>
                    <td>₹<?= number_format($subtotal, 2) ?></td>
                </tr>
                <tr class="total-row">
                    <td>GST (18%)</td>
                    <td>₹<?= number_format($tax, 2) ?></td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td>₹<?= number_format($total, 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="btn-center">
            <a href="details.php" class="continue-btn">Continue</a>
        </div>
    </div>
</body>
</html>
