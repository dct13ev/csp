<?php

if ($page === 'thuc_don') {
    if ($request_method === 'POST' && isset($_POST['add_product_id'])) {
        $product_id = (int) $_POST['add_product_id'];
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :id');
        $stmt->execute(['id' => $product_id]);

        if ($stmt->fetch()) {
            $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
        }

        redirect('index.php?area=khach&page=thuc_don');
    }

    $products = $pdo->query(
        'SELECT id, name, price, image_url FROM products ORDER BY id DESC'
    )->fetchAll();
    $product_html = '';

    foreach ($products as $product) {
        $product_html .= render_product_card($product);
    }

    $cart_count = array_sum($_SESSION['cart'] ?? []);
    $content = str_replace(
        ['{{products}}', '{{cart_count}}'],
        [$product_html, (string) $cart_count],
        file_get_contents('giao_dien/thucdon/thuc_don.html')
    );
    render_customer($content, 'giao_dien/thucdon/thuc_don.css?v=2');
} elseif ($page === 'dat_hang') {
    $message = '';

    if ($request_method === 'POST' && isset($_POST['place_order'])) {
        $name = trim($_POST['customer_name'] ?? '');
        $phone = trim($_POST['customer_phone'] ?? '');
        $address = trim($_POST['customer_address'] ?? '');
        $cart = $_SESSION['cart'] ?? [];

        if ($name === '' || $phone === '' || $address === '' || !$cart) {
            $message = 'Vui lòng nhập đủ thông tin và chọn ít nhất một món.';
        } else {
            $pdo->beginTransaction();
            $items = [];
            $total = 0;
            $product_ids = array_keys($cart);
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $pdo->prepare(
                "SELECT id, name, price FROM products WHERE id IN ($placeholders)"
            );
            $stmt->execute($product_ids);

            foreach ($stmt->fetchAll() as $product) {
                $quantity = (int) $cart[$product['id']];
                $items[] = [$product, $quantity];
                $total += $product['price'] * $quantity;
            }

            $stmt = $pdo->prepare(
                "INSERT INTO orders (customer_name, customer_phone, customer_address, total_amount, status)
                 VALUES (:name, :phone, :address, :total, 'Chờ xử lý')"
            );
            $stmt->execute([
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'total' => $total,
            ]);
            $order_id = (int) $pdo->lastInsertId();
            $stmt = $pdo->prepare(
                'INSERT INTO order_details (order_id, product_id, quantity, price)
                 VALUES (:order_id, :product_id, :quantity, :price)'
            );

            foreach ($items as [$product, $quantity]) {
                $stmt->execute([
                    'order_id' => $order_id,
                    'product_id' => $product['id'],
                    'quantity' => $quantity,
                    'price' => $product['price'],
                ]);
            }

            $pdo->commit();
            $_SESSION['cart'] = [];
            $message = 'Đặt hàng thành công. Mã đơn của bạn là #' . $order_id . '.';
        }
    }

    $cart_html = render_cart_items($pdo, $_SESSION['cart'] ?? []);
    $content = str_replace(
        ['{{message}}', '{{cart}}'],
        [
            $message === '' ? '' : '<p class="notice">' . e($message) . '</p>',
            $cart_html,
        ],
        file_get_contents('giao_dien/dat_hang/dat_hang.html')
    );
    render_customer($content, 'giao_dien/thucdon/thuc_don.css');
} elseif ($page === 'tra_cuu') {
    $results_html = '';

    if ($request_method === 'POST') {
        $phone = trim($_POST['customer_phone'] ?? '');
        $stmt = $pdo->prepare(
            'SELECT id, total_amount, status, order_date
             FROM orders WHERE customer_phone = :phone ORDER BY order_date DESC'
        );
        $stmt->execute(['phone' => $phone]);

        foreach ($stmt->fetchAll() as $order) {
            $results_html .= '<li>Đơn #' . (int) $order['id'] . ' - '
                . e($order['status']) . ' - ' . format_money($order['total_amount']) . ' - '
                . e($order['order_date']) . '</li>';
        }

        if ($results_html === '') {
            $results_html = '<li>Không tìm thấy đơn hàng.</li>';
        }
    }

    $content = str_replace(
        '{{results}}',
        $results_html,
        file_get_contents('giao_dien/tra_cuu/tra_cuu.html')
    );
    render_customer($content, 'giao_dien/thucdon/thuc_don.css');
} else {
    render_customer('', 'giao_dien/home/home.css');
}
