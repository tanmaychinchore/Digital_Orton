<?php
$conn = new mysqli("localhost", "root", "", "digital_orton");
if ($conn->connect_error) die("Connection failed");

$id = $_GET['id'] ?? 0;
$conn->query("DELETE FROM customer_info WHERE id=$id");

header("Location: admin_dashboard.php");
exit;
