<?php
include "../includes/session.php";
include(__DIR__ . '/../includes/db.php');

if (!$conn) {
    die("Database connection failed");
}


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        // Secure session
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<?php include "../includes/header.php"; ?>

<link rel="stylesheet" href="../assets/css/style.css">

<div class="auth-container">
  <div class="auth-box">
    <h2>Login</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p>Don't have an account?</p>
    <a href="register.php">Create Account</a>
  </div>
</div>

</body>
</html>