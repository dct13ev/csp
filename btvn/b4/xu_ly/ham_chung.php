<?php

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function format_number($amount): string
{
    return number_format($amount, 0, ',', '.');
}

function format_money($amount): string
{
    return format_number($amount) . ' đ';
}

function render_template(string $path, array $replacements = []): void
{
    $html = file_get_contents($path);
    echo str_replace(array_keys($replacements), array_values($replacements), $html);
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function require_admin(): void
{
    if (!isset($_SESSION['admin_id'])) {
        redirect('index.php?area=admin&page=admin');
    }
}

function render_customer(string $content, string $css): void
{
    render_template('giao_dien/home/home.html', [
        '{{page_css}}' => $css,
        '{{content}}' => $content,
    ]);
}

function render_admin_home(): void
{
    render_template('giao_dien/admin/home.html', [
        '{{admin_username}}' => e($_SESSION['admin_username']),
        '{{admin_links}}' => '<nav class="admin-nav">'
            . '<a href="index.php?area=admin&page=products">Quản lý món</a>'
            . '<a href="index.php?area=admin&page=orders">Đơn hàng</a>'
            . '<a href="index.php?area=admin&page=stats">Thống kê</a>'
            . '<a href="index.php?area=admin&page=logout">Đăng xuất</a>'
            . '</nav>',
    ]);
}

function render_product_card(array $product): string
{
    return '<div class="product-card">'
        . '<div class="product-image"><img src="pictures/' . e($product['image_url']) . '" alt="' . e($product['name']) . '"></div>'
        . '<h3 class="product-name">' . e($product['name']) . '</h3>'
        . '<p class="product-price">' . format_money($product['price']) . '</p>'
        . '<form method="post">'
        . '<input type="hidden" name="add_product_id" value="' . (int) $product['id'] . '">'
        . '<button class="btn-add-cart" type="submit">Thêm vào giỏ</button>'
        . '</form>'
        . '</div>';
}

function render_cart_items(PDO $pdo, array $cart): string
{
    if (!$cart) {
        return '<li>Giỏ hàng đang trống.</li>';
    }

    $product_ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($product_ids);

    $cart_html = '';
    foreach ($stmt->fetchAll() as $product) {
        $quantity = (int) $cart[$product['id']];
        $cart_html .= '<li>' . e($product['name']) . ' x ' . $quantity . ' - '
            . format_money($product['price'] * $quantity) . '</li>';
    }

    return $cart_html;
}

function render_status_options(string $current_status): string
{
    $statuses = ['Chờ xử lý', 'Đang chuẩn bị', 'Hoàn thành', 'Đã hủy'];
    $options = '';

    foreach ($statuses as $status) {
        $selected = $status === $current_status ? ' selected' : '';
        $options .= '<option value="' . e($status) . '"' . $selected . '>'
            . e($status) . '</option>';
    }

    return $options;
}
