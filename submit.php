<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'digital_orton';
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize form data
$business_name = $_POST['business_name'] ?? '';
$pincode = $_POST['pincode'] ?? '';
$location_city = $_POST['location_city'] ?? '';
$location_state = $_POST['location_state'] ?? '';
$location_country = $_POST['location_country'] ?? '';
$website_url = $_POST['website_url'] ?? '';
$google_profile = $_POST['google_profile'] ?? '';
$facebook_link = $_POST['facebook_link'] ?? '';
$youtube_link = $_POST['youtube_link'] ?? '';
$promotion_types = $_POST['promotion_type'] ?? [];
$promotion_type_str = implode(', ', $promotion_types);

// Insert into business_info
$sql = "INSERT INTO business_info 
    (business_name, pincode, location_city, location_state, location_country, website_url, google_profile, facebook_link, youtube_link, promotion_type) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $business_name, $pincode, $location_city, $location_state, $location_country, $website_url, $google_profile, $facebook_link, $youtube_link, $promotion_type_str);

if ($stmt->execute()) {
    $business_id = $conn->insert_id;
    $_SESSION['business_id'] = $business_id;

    // Store in session
    $_SESSION['business_name'] = $business_name;
    $_SESSION['pincode'] = $pincode;
    $_SESSION['location_city'] = $location_city;
    $_SESSION['location_state'] = $location_state;
    $_SESSION['location_country'] = $location_country;
    $_SESSION['website_url'] = $website_url;
    $_SESSION['google_profile'] = $google_profile;
    $_SESSION['facebook_link'] = $facebook_link;
    $_SESSION['youtube_link'] = $youtube_link;
    $_SESSION['promotion_type'] = $promotion_types;

    header("Location: packages.php");
    exit;
} else {
    echo "<h2 style='color:red;text-align:center;'>Error: " . $stmt->error . "</h2>";
}
$stmt->close();
$conn->close();
?>