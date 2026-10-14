<?php

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
    file_get_contents('giao_dien/admin/san_phan.html')
);
