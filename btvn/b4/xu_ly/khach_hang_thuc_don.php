<?php

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
