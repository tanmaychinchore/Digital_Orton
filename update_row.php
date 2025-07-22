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

    unset($_POST['table'], $_POST['id']);

    $fields = [];
    $values = [];
    $types = '';

    foreach ($_POST as $key => $val) {
        $fields[] = "$key = ?";
        $values[] = $val;
        $types .= 's';
    }

    $stmt = $conn->prepare("UPDATE $table SET " . implode(", ", $fields) . " WHERE id = ?");
    $types .= 'i';
    $values[] = $id;

    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record.";
    }

    $stmt->close();
    $conn->close();
}
?>
