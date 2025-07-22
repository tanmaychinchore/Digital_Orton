<?php
require 'db_connect.php';

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    $result = $conn->query("SELECT * FROM $table");

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $table . '.csv"');

    $output = fopen('php://output', 'w');
    if ($result->num_rows > 0) {
        fputcsv($output, array_keys($result->fetch_assoc())); // Headers
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit;
}
?>
