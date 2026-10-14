<?php

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
render_customer($content, 'giao_dien/dat_hang/dat_hang.css');
