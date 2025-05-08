<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $update_password = false;

    if (!empty($password)) {
        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_password = true;
        } else {
            header("Location: profile.php?error=Passwords do not match!");
            exit();
        }
    }

    $profile_image = $user['image'];
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $profile_image = $image_name;
    }

    if ($update_password) {
        $query = "UPDATE users SET name = ?, image = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $profile_image, $hashed_password, $user_id);
    } else {
        $query = "UPDATE users SET name = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $name, $profile_image, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: profile.php?updated=true");
        exit();
    } else {
        header("Location: profile.php?error=Failed to update profile.");
        exit();
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Name:</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Profile Image:</label><br>
        <input type="file" name="profile_image" class="form-control">
    </div>

    <hr>
    <h5>Change Password <small class="text-muted">(optional)</small></h5>
    <div class="mb-3">
        <label class="form-label">New Password:</label>
        <input type="password" name="password" class="form-control" placeholder="Leave blank if not changing">
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm New Password:</label>
        <input type="password" name="confirm_password" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Save Changes</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
