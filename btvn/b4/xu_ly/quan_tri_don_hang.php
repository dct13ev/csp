<?php

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
    file_get_contents('giao_dien/admin/don_hang.html')
);
