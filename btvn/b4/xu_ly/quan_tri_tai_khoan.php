<?php

if ($page === 'logout') {
    session_destroy();
    redirect('index.php?area=admin&page=admin');
}

$login_error = '';

if ($request_method === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare(
        'SELECT id, username, password FROM admin_users
         WHERE username = :username LIMIT 1'
    );
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if (
        $username !== ''
        && $password !== ''
        && $admin
        && (
            password_verify($password, $admin['password'])
            || hash_equals((string) $admin['password'], $password)
        )
    ) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        redirect('index.php?area=admin&page=home');
    }

    $login_error = 'Tài khoản hoặc mật khẩu không đúng.';
}

$error_html = $login_error === ''
    ? ''
    : '<p class="login-error">' . e($login_error) . '</p>';
echo str_replace(
    '{{login_error}}',
    $error_html,
    file_get_contents('giao_dien/dangnhap/login.html')
);
