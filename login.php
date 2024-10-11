CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    status VARCHAR(50)
);



<?php
session_start();
require 'db_connection.php'; // Your DB connection file

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid email or password.";
    }
}
?>

<form method="POST" action="">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit" name="login">Login</button>
</form>


<?php
session_start();
session_destroy(); // Destroy all sessions
header("Location: login.php"); // Redirect to login page
?>


<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<h2>Welcome, <?php echo $user['name']; ?></h2>

<a href="update.php">Update Profile</a> |
<a href="delete.php">Delete Account</a> |
<a href="logout.php">Logout</a>


<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';

$user_id = $_SESSION['user_id'];
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);

    if ($stmt->execute()) {
        session_destroy(); // End session after account deletion
        header("Location: login.php");
        exit();
    } else {
        echo "Error deleting account.";
    }
}
?>

<form method="POST" action="">
    <p>Are you sure you want to delete your account?</p>
    <button type="submit" name="delete">Delete Account</button>
</form>



<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "your_database_name";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
