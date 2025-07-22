<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "digital_orton");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch counts
$businessCount = $conn->query("SELECT COUNT(*) as count FROM business_info")->fetch_assoc()['count'];
$customerCount = $conn->query("SELECT COUNT(*) as count FROM customer_details")->fetch_assoc()['count'];
$orderCount = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles1.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: #333;
      padding: 40px;
    }

    h1 {
      text-align: center;
      color: #fff;
    }

    .logout-btn {
      position: absolute;
      top: 20px;
      right: 40px;
      background: #fff;
      color: #764ba2;
      border: none;
      padding: 10px 20px;
      border-radius: 30px;
      cursor: pointer;
      font-weight: bold;
      box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }

    .card-container {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin: 40px 0;
      flex-wrap: wrap;
    }

    .card {
      flex: 1;
      min-width: 250px;
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      text-align: center;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      background: #f3f4ff;
    }

    .card h3 {
      margin-bottom: 10px;
    }

    .card span {
      font-size: 2rem;
      font-weight: bold;
    }

    .data-table {
      display: none;
      margin-top: 30px;
      background: white;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      padding: 10px 14px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #667eea;
      color: white;
    }

    .actions button {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      margin-right: 5px;
      cursor: pointer;
    }

    .edit-btn { background: #facc15; color: black; }
    .delete-btn { background: #ef4444; color: white; }

    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.4);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 500px;
    }

    .modal-content input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
    }

    .modal-content button {
      background: #667eea;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h1>Admin Dashboard</h1>
  <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

  <div class="card-container">
    <div class="card" onclick="toggleTable('business')">
      <h3>Business Entries</h3>
      <span><?= $businessCount ?></span>
    </div>
    <div class="card" onclick="toggleTable('customer')">
      <h3>Customer Entries</h3>
      <span><?= $customerCount ?></span>
    </div>
    <div class="card" onclick="toggleTable('orders')">
      <h3>Order Entries</h3>
      <span><?= $orderCount ?></span>
    </div>
  </div>

  <!-- BUSINESS TABLE -->
  <div id="business" class="data-table">
    <h2>Business Information</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Business Name</th>
        <th>Location</th>
        <th>Promotion Type</th>
        <th>Actions</th>
      </tr>
      <?php
      $res = $conn->query("SELECT * FROM business_info");
      while ($row = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['business_name'] ?></td>
          <td><?= $row['location_city'] ?>, <?= $row['location_country'] ?></td>
          <td><?= $row['promotion_type'] ?></td>
          <td class="actions">
            <button class="edit-btn" onclick="editRow('business_info', <?= $row['id'] ?>)">Edit</button>
            <button class="delete-btn" onclick="deleteRow('business_info', <?= $row['id'] ?>)">Delete</button>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <!-- CUSTOMER TABLE -->
  <div id="customer" class="data-table">
    <h2>Customer Information</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Business ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>WhatsApp</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Country</th>
        <th>Actions</th>
      </tr>
      <?php
      $res = $conn->query("SELECT * FROM customer_details");
      while ($row = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['business_id'] ?></td>
          <td><?= $row['first_name'] ?></td>
          <td><?= $row['last_name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['phone'] ?></td>
          <td><?= $row['whatsapp'] ?></td>
          <td><?= $row['address'] ?></td>
          <td><?= $row['city'] ?></td>
          <td><?= $row['state'] ?></td>
          <td><?= $row['country'] ?></td>
          <td class="actions">
            <button class="edit-btn" onclick="editRow('customer_details', <?= $row['id'] ?>)">Edit</button>
            <button class="delete-btn" onclick="deleteRow('customer_details', <?= $row['id'] ?>)">Delete</button>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <!-- ORDERS TABLE -->
  <div id="orders" class="data-table">
    <h2>Order Information</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Order ID</th>
        <th>Customer Email</th>
        <th>Total</th>
        <th>Package Summary</th>
        <th>Actions</th>
      </tr>
      <?php
      $res = $conn->query("SELECT * FROM orders");
      while ($row = $res->fetch_assoc()):
      ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['order_id'] ?></td>
          <td><?= $row['customer_email'] ?></td>
          <td>₹<?= number_format($row['total'], 2) ?></td>
          <td><?= $row['package_summary'] ?></td>
          <td class="actions">
            <button class="edit-btn" onclick="editRow('orders', <?= $row['id'] ?>)">Edit</button>
            <button class="delete-btn" onclick="deleteRow('orders', <?= $row['id'] ?>)">Delete</button>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <!-- MODAL -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <h3>Edit Entry</h3>
      <form id="editForm">
        <input type="hidden" name="table" id="editTable">
        <input type="hidden" name="id" id="editId">
        <div id="formFields"></div>
        <button type="submit">Update</button>
      </form>
    </div>
  </div>

  <script>
    function toggleTable(id) {
      document.querySelectorAll('.data-table').forEach(t => t.style.display = 'none');
      document.getElementById(id).style.display = 'block';
    }

    function deleteRow(table, id) {
      if (confirm("Are you sure you want to delete this entry?")) {
        fetch('delete_row.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: `table=${table}&id=${id}`
        })
        .then(res => res.text())
        .then(data => {
          alert(data);
          location.reload();
        });
      }
    }

    function editRow(table, id) {
      fetch(`get_row.php?table=${table}&id=${id}`)
        .then(res => res.json())
        .then(data => {
          document.getElementById('editTable').value = table;
          document.getElementById('editId').value = id;

          let html = '';
          for (let key in data) {
            if (key !== 'id') {
              html += `<label>${key}</label><input name="${key}" value="${data[key]}" />`;
            }
          }
          document.getElementById('formFields').innerHTML = html;
          document.getElementById('editModal').style.display = 'flex';
        });
    }

    document.getElementById('editForm').onsubmit = function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('update_row.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.text())
      .then(data => {
        alert(data);
        location.reload();
      });
    };

    window.onclick = function(e) {
      if (e.target == document.getElementById('editModal')) {
        document.getElementById('editModal').style.display = 'none';
      }
    };
  </script>
</body>
</html>
