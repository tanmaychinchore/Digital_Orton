<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['business_id'])) {
    exit("Missing business information. Please complete the form first.");
}

$conn = new mysqli("localhost", "root", "", "digital_orton");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = $_POST['first_name'] ?? '';
    $last = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $business_id = $_SESSION['business_id'];

    $sql = "INSERT INTO customer_details 
        (business_id, first_name, last_name, email, phone, whatsapp, address, city, state, country)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $business_id, $first, $last, $email, $phone, $whatsapp, $address, $city, $state, $country);

    if ($stmt->execute()) {
        $_SESSION['customer_id'] = $conn->insert_id;
        $_SESSION['customer_first_name'] = $first;
        $_SESSION['customer_last_name'] = $last;
        $_SESSION['customer_email'] = $email;
        $_SESSION['customer_phone'] = $phone;
        $_SESSION['customer_whatsapp'] = $whatsapp;
        $_SESSION['customer_address'] = $address;
        $_SESSION['customer_city'] = $city;
        $_SESSION['customer_state'] = $state;
        $_SESSION['customer_country'] = $country;

        header("Location: confirm.php");
        exit;
    } else {
        echo "<h2 style='color:red;'>Error: " . $stmt->error . "</h2>";
    }

    $stmt->close();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Your Details</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: #fff;
            padding: 40px;
        }

        .form-container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            color: #333;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"], input[type="email"], input[type="tel"], textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
        }

        .submit-btn:hover {
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Enter Your Personal Details</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="form-group">
                <label>Email ID</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" required>
            </div>
            <div class="form-group">
                <label>WhatsApp Number</label>
                <input type="tel" name="whatsapp" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" required></textarea>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" required>
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" required>
            </div>
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="country" required>
            </div>

            <button type="submit" class="submit-btn">Confirm & Proceed</button>
        </form>
    </div>
</body>
</html>
