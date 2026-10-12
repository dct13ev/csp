<?php

if ($page === 'admin') {
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
} elseif ($page === 'logout') {
    session_destroy();
    redirect('index.php?area=admin&page=admin');
} else {
    require_admin();

    if ($page === 'home') {
        render_admin_home();
    } elseif ($page === 'products') {
        $message = '';

        if ($request_method === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'delete') {
                $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
                $stmt->execute(['id' => (int) $_POST['id']]);
            } elseif ($action === 'save') {
                $product_id = (int) ($_POST['id'] ?? 0);
                $product_data = [
                    'name' => trim($_POST['name'] ?? ''),
                    'price' => (int) ($_POST['price'] ?? 0),
                ];

                if ($product_id > 0) {
                    $stmt = $pdo->prepare(
                        'UPDATE products SET name=:name, price=:price WHERE id=:id'
                    );
                    $stmt->execute($product_data + ['id' => $product_id]);
                } else {
                    $stmt = $pdo->prepare(
                        'INSERT INTO products (name, price, image_url)
                         VALUES (:name, :price, :image_url)'
                    );
                    $stmt->execute($product_data + ['image_url' => 'trasua.png']);
                }

                $message = 'Đã lưu món.';
            }
        }

        $products = $pdo->query(
            'SELECT id, name, price, image_url FROM products ORDER BY id DESC'
        )->fetchAll();
        $rows = '';

        foreach ($products as $product) {
            $rows .= '<tr><td>' . (int) $product['id'] . '</td><td>'
                . '<form method="post" class="inline">'
                . '<input type="hidden" name="action" value="save">'
                . '<input type="hidden" name="id" value="' . (int) $product['id'] . '">'
                . '<input name="name" value="' . e($product['name']) . '" required></td>'
                . '<td><input name="price" type="number" value="' . (int) $product['price']
                . '" min="0" required></td><td><button>Lưu</button></form>'
                . '<form method="post" class="inline"><input type="hidden" name="action"'
                . ' value="delete"><input type="hidden" name="id" value="'
                . (int) $product['id'] . '"><button>Xóa</button></form></td></tr>';
        }

        echo str_replace(
            ['{{message}}', '{{rows}}'],
            [$message, $rows],
            file_get_contents('giao_dien/admin/products.html')
        );
    } elseif ($page === 'orders') {
        if ($request_method === 'POST') {
            $stmt = $pdo->prepare('UPDATE orders SET status = :status WHERE id = :id');
            $stmt->execute([
                'status' => $_POST['status'],
                'id' => (int) $_POST['id'],
            ]);
        }

        $orders = $pdo->query(
            'SELECT id, customer_name, customer_phone, customer_address,
             total_amount, status, order_date FROM orders ORDER BY order_date DESC'
        )->fetchAll();
        $rows = '';

        foreach ($orders as $index => $order) {
            $rows .= '<tr><td>' . ($index + 1) . '</td><td>'
                . e($order['customer_name']) . '</td><td>'
                . e($order['customer_phone']) . '</td><td>'
                . e($order['customer_address']) . '</td><td>'
                . format_money($order['total_amount']) . '</td><td>'
                . '<form method="post"><input type="hidden" name="id" value="'
                . (int) $order['id'] . '"><select name="status">'
                . render_status_options($order['status'])
                . '</select><button>Cập nhật</button></form></td></tr>';
        }

        echo str_replace(
            '{{rows}}',
            $rows,
            file_get_contents('giao_dien/admin/orders.html')
        );
    } elseif ($page === 'stats') {
        $today = $pdo->query(
            "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
             FROM orders
             WHERE DATE(order_date) = CURDATE() AND status = 'Hoàn thành'"
        )->fetch();
        $week = $pdo->query(
            "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
             FROM orders
             WHERE order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
             AND status = 'Hoàn thành'"
        )->fetch();
        $month = $pdo->query(
            "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
             FROM orders
             WHERE order_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
             AND status = 'Hoàn thành'"
        )->fetch();
        $six_months = $pdo->query(
            "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
             FROM orders
             WHERE order_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
             AND status = 'Hoàn thành'"
        )->fetch();
        $year = $pdo->query(
            "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
             FROM orders
             WHERE order_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
             AND status = 'Hoàn thành'"
        )->fetch();

        echo str_replace(
            [
                '{{today_orders}}', '{{today_total}}',
                '{{week_orders}}', '{{week_total}}',
                '{{month_orders}}', '{{month_total}}',
                '{{six_months_orders}}', '{{six_months_total}}',
                '{{year_orders}}', '{{year_total}}',
            ],
            [
                $today['orders'], format_number($today['total']),
                $week['orders'], format_number($week['total']),
                $month['orders'], format_number($month['total']),
                $six_months['orders'], format_number($six_months['total']),
                $year['orders'], format_number($year['total']),
            ],
            file_get_contents('giao_dien/admin/stats.html')
        );
    }
}
