<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "digital_orton");
    if ($conn->connect_error) {
        die("Connection failed");
    }

    $table = $_POST['table'];
    $id = intval($_POST['id']);

    $validTables = ['business_info', 'customer_details', 'orders'];
    if (!in_array($table, $validTables)) {
        die("Invalid table");
    }

    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Entry deleted successfully.";
    } else {
        echo "Error deleting entry.";
    }

    $stmt->close();
    $conn->close();
}
?>
