$searchTerm = $_GET['search_customer'] ?? '';
$searchSql = "SELECT * FROM customer_info";

if (!empty($searchTerm)) {
    $searchTerm = $conn->real_escape_string($searchTerm);
    $searchSql .= " WHERE first_name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
}

$result = $conn->query($searchSql);
