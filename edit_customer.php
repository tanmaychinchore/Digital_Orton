<?php
$conn = new mysqli("localhost", "root", "", "digital_orton");
if ($conn->connect_error) die("Connection failed");

$id = $_GET['id'] ?? 0;

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $whatsapp = $_POST['whatsapp'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    $sql = "UPDATE customer_info SET 
        first_name=?, last_name=?, email=?, phone=?, whatsapp=?, address=?, city=?, state=?, country=?
        WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $first, $last, $email, $phone, $whatsapp, $address, $city, $state, $country, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Load customer
    $res = $conn->query("SELECT * FROM customer_info WHERE id=$id");
    $data = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
</head>
<body>
    <h2>Edit Customer Info</h2>
    <form method="post">
        <input name="first_name" value="<?= $data['first_name'] ?>" required><br>
        <input name="last_name" value="<?= $data['last_name'] ?>" required><br>
        <input name="email" value="<?= $data['email'] ?>" required><br>
        <input name="phone" value="<?= $data['phone'] ?>" required><br>
        <input name="whatsapp" value="<?= $data['whatsapp'] ?>" required><br>
        <input name="address" value="<?= $data['address'] ?>" required><br>
        <input name="city" value="<?= $data['city'] ?>" required><br>
        <input name="state" value="<?= $data['state'] ?>" required><br>
        <input name="country" value="<?= $data['country'] ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
