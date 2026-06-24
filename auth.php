<?php
// auth.php - Đăng nhập / Đăng ký Mizuki’s Cakes
require_once __DIR__ . '/config.php';
$pageTitle = 'Đăng nhập / Đăng ký - Mizuki’s Cakes';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Thử xác minh mật khẩu hashed
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            // Nếu là mật khẩu plain text, hash nó lại
            if ($password === $user['password']) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
                $updateStmt->bind_param('si', $hashed, $user['id']);
                $updateStmt->execute();
                $updateStmt->close();
            }
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            if ($user['role'] === 'admin') {
                header('Location: admin.php');
                exit();
            } else {
                header('Location: index.php');
                exit();
            }
        }
    }

    $error = 'Sai tài khoản hoặc mật khẩu!';
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if ($password !== $repassword) {
        $error = 'Mật khẩu nhập lại không khớp!';
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $check = $stmt->get_result();
        $stmt->close();

        if ($check && $check->num_rows > 0) {
            $error = 'Tên đăng nhập hoặc email đã tồn tại!';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?);');
            $role = 'user';
            $stmt->bind_param('sssss', $fullname, $username, $email, $passwordHash, $role);

            if ($stmt->execute()) {
                $_SESSION['user'] = [
                    'fullname' => $fullname,
                    'username' => $username,
                    'email' => $email,
                    'role' => 'user'
                ];
                $stmt->close();
                header('Location: index.php');
                exit();
            }

            $stmt->close();
            $error = 'Đăng ký thất bại. Vui lòng thử lại!';
        }
    }
}
?>
<?php
$pageHead = '<style>
  body { display: flex; flex-direction: column; min-height: 100vh; }
  .nav { flex-shrink: 0; }
  .auth-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; background: #f6efe6; }
  .auth-container { background: #fff; border-radius: 18px; border: 2px solid #b48d61; box-shadow: 0 8px 32px rgba(0,0,0,.12); padding: 36px 32px 28px 32px; width: 100%; max-width: 407px; text-align: center; }
  footer { flex-shrink: 0; }
</style>';
$pageScripts = ['js/auth.js'];
require_once __DIR__ . '/partials/head.php';
?>
<?php require_once __DIR__ . '/partials/header.php'; ?>
<div class="auth-wrapper">
  <div class="auth-container">
    <a href="index.php" class="auth-logo" title="Về trang chủ">
      <img src="images/slideshow_1.png" alt="Mizuki’s Cakes">
      <span>Mizuki’s Cakes</span>
    </a>
    <div class="auth-tabs">
      <button class="auth-tab active" id="loginTab" onclick="showForm('login')">Đăng nhập</button>
      <button class="auth-tab" id="registerTab" onclick="showForm('register')">Đăng ký</button>
    </div>
    <form class="auth-form active" id="loginForm" autocomplete="off" method="post" action="">
      <?php if ($error): ?>
        <div class="error-msg"><?= $error ?></div>
      <?php endif; ?>
      <input type="text" name="username" placeholder="Tên đăng nhập" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <button type="submit" name="login">Đăng nhập</button>
      <div class="auth-link">Chưa có tài khoản? <a onclick="showForm('register')">Đăng ký</a></div>
    </form>
    <form class="auth-form" id="registerForm" autocomplete="off" method="post" action="">
      <input type="text" name="fullname" placeholder="Họ và tên" required>
      <input type="text" name="username" placeholder="Tên đăng nhập" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <input type="password" name="repassword" placeholder="Nhập lại mật khẩu" required>
      <button type="submit" name="register">Đăng ký</button>
      <div class="auth-link">Đã có tài khoản? <a onclick="showForm('login')">Đăng nhập</a></div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>