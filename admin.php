<?php
session_start();

include 'database.php';

if (isset($_POST['Masuk'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;

        // pindah ke dashboard
        header("Location: ddashboard.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

  <div class="container">
    <div class="login-box">
      <h2>Selamat Datang Admin!</h2>
      <hr>

      <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="Masuk">Masuk</button>
      </form>
    </div>
  </div>

  <script src="cart.js"></script>

</body>
</html>