<?php
require 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $qty = $_POST['quantity'] ?? 0;
    $desc = $_POST['description'] ?? '';

    // Xử lý Thêm mới
    if ($action === 'create' && $name) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, quantity, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $qty, $desc]);
    } 
    // Xử lý Cập nhật
    elseif ($action === 'update' && $id) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, quantity=?, description=? WHERE id=?");
        $stmt->execute([$name, $price, $qty, $desc, $id]);
    }
} 
// Xử lý Xóa
elseif ($action === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$_GET['id']]);
}

// Xong việc thì quay về trang chủ
header("Location: index.php");
exit;
?>