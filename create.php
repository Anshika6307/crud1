<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create User</title>
    <script src="validation.js"></script>
</head>
<body>
    <h2>Create User</h2>
    <form id="createForm" method="POST" action="create.php">
        <input type="text" id="name" name="name" placeholder="Name" required><br>
        <input type="email" id="email" name="email" placeholder="Email" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required><br>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select><br>
        <input type="submit" value="Create">
    </form>

    <script>
        document.getElementById('createForm').onsubmit = function (event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $status = $_POST['status'];

    // Check if email is unique
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "Email already exists.";
    } else {
        // Insert user data
        $sql = "INSERT INTO users (name, email, password, status) VALUES (?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$name, $email, $password, $status]);
        header("Location: index.php");
    }
}
?>
