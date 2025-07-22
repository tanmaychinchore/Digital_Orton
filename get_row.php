<?php
if (isset($_GET['table']) && isset($_GET['id'])) {
    $conn = new mysqli("localhost", "root", "", "digital_orton");
    if ($conn->connect_error) {
        die("Connection failed");
    }

    $table = $_GET['table'];
    $id = intval($_GET['id']);

    $validTables = ['business_info', 'customer_details', 'orders'];
    if (!in_array($table, $validTables)) {
        die("Invalid table");
    }

    $result = $conn->query("SELECT * FROM $table WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Record not found"]);
    }

    $conn->close();
}
?>
