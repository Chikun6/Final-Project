<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_user') {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM users WHERE id = $id");
    echo "success";
    exit;
}

$result = $conn->query("SELECT * FROM users");
?>

<h3>All Users</h3>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr id="row-<?= $row['id'] ?>">
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['role']) ?></td>
        <td>
          <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
