<?php include 'config.php'; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    $sql = "UPDATE users SET name = ?, email = ?, status = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$name, $email, $status, $id]);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form method="POST">
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <select name="status">
            <option value="active" <?php if ($user['status'] == 'active') echo 'selected'; ?>>Active</option>
            <option value="inactive" <?php if ($user['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
        </select><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
