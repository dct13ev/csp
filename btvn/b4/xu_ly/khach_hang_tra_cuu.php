<?php

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
render_customer($content, 'giao_dien/tra_cuu/tra_cuu.css');
