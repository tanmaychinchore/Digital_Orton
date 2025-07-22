<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email_status = '';

if (
    empty($_SESSION['customer_first_name']) ||
    empty($_SESSION['customer_email']) ||
    empty($_SESSION['selected_packages']) ||
    empty($_SESSION['total']) ||
    empty($_SESSION['customer_id'])
) {
    exit("Missing session data. Please complete previous steps.");
}

$firstName = $_SESSION['customer_first_name'];
$lastName = $_SESSION['customer_last_name'];
$email = $_SESSION['customer_email'];
$phone = $_SESSION['customer_phone'];
$whatsapp = $_SESSION['customer_whatsapp'];
$address = $_SESSION['customer_address'];
$city = $_SESSION['customer_city'];
$state = $_SESSION['customer_state'];
$country = $_SESSION['customer_country'];
$packages = $_SESSION['selected_packages'];
$subtotal = $_SESSION['subtotal'];
$tax = $_SESSION['tax'];
$total = $_SESSION['total'];
$customer_id = $_SESSION['customer_id'];
$orderId = 'SA' . rand(10000, 99999);

// Store in orders table
$conn = new mysqli("localhost", "root", "", "digital_orton");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$full_address = "$address, $city, $state, $country";
$customer_name = "$firstName $lastName";
$payment_method = "CCAVENUE"; // or Paytm etc.
$shipping_method = "Online";
$package_summary = implode(', ', array_map(fn($p) => $p['name'], $packages));

$sql = "INSERT INTO orders (order_id, customer_id, customer_name, customer_email, customer_address, payment_method, shipping_method, subtotal, tax, total, package_summary)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sissssssdds", $orderId, $customer_id, $customer_name, $email, $full_address, $payment_method, $shipping_method, $subtotal, $tax, $total, $package_summary);

if ($stmt->execute()) {
    // Success message optional
} else {
    echo "<p style='color:red;'>Order error: " . $stmt->error . "</p>";
}

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$email_status = '';

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'chinchoretanmay@gmail.com'; // Your Gmail
    $mail->Password = 'xwai pdmd hrky lxbf';    // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('chinchoretanmay@gmail.com', 'Digital Orton');
    $mail->addAddress($email, "$firstName $lastName");

    $mail->isHTML(true);
    $mail->Subject = "Order Confirmation - $orderId";

    $mail->Body = "
        <h2>Order $orderId confirmed</h2>
        <p>Thank you for your payment.</p>
        <h3>Order Details:</h3>
        <ul>";
    foreach ($packages as $pkg) {
        $mail->Body .= "<li>" . $pkg['name'] . " - ₹" . $pkg['price'] . "</li>";
    }
    $mail->Body .= "</ul>
        <p><strong>Subtotal:</strong> ₹$subtotal</p>
        <p><strong>GST:</strong> ₹$tax</p>
        <p><strong>Total:</strong> ₹$total</p>
        <br>
        <h3>Customer Info:</h3>
        <p>$firstName $lastName</p>
        <p>$address, $city, $state, $country</p>
        <p>Email: $email</p>
        <p>Phone: $phone</p>
        <p>WhatsApp: $whatsapp</p>
    ";

    $mail->send();
    $email_status = "Email sent successfully to $email.";
} catch (Exception $e) {
    $email_status = "Mailer Error: " . $mail->ErrorInfo;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: #fff;
            padding: 40px;
            text-align: center;
        }
        .confirmation-box {
            background: white;
            color: #333;
            padding: 30px;
            max-width: 700px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .confirmation-box h2 {
            color: #667eea;
            margin-bottom: 20px;
        }
        .confirmation-box p {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h2>Order Confirmed ✅</h2>
        <p><strong>Customer:</strong> <?= htmlspecialchars($firstName . ' ' . $lastName) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Subtotal:</strong> ₹<?= number_format($subtotal, 2) ?></p>
        <p><strong>Tax:</strong> ₹<?= number_format($tax, 2) ?></p>
        <p><strong>Total:</strong> ₹<?= number_format($total, 2) ?></p>
        <hr>
        <p><?= htmlspecialchars($email_status) ?></p>
    </div>
</body>
</html>
