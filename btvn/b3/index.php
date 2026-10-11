<?php
require 'db.php';

$edit_product = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $edit_product = $stmt->fetch(); 
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản phẩm</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 20px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 10px; }
        input { padding: 8px; width: 100%; box-sizing: border-box; margin-top: 5px; }
        .btn { padding: 8px 15px; color: #fff; border: none; cursor: pointer; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-add { background: #28a745; }
        .btn-update { background: #007bff; }
        .btn-edit { background: #ffc107; color: #000; padding: 5px 10px; }
        .btn-delete { background: #dc3545; padding: 5px 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
    </style>
</head>
<body>

<div class="container">
    <h2>Quản lý Sản phẩm</h2>

    <form method="POST" action="pocs.php">
        <input type="hidden" name="action" value="<?= $edit_product ? 'update' : 'create' ?>">
        <input type="hidden" name="id" value="<?= $edit_product['id'] ?? '' ?>">
        
        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($edit_product['name'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Giá:</label>
            <input type="number" name="price" required value="<?= htmlspecialchars($edit_product['price'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Số lượng:</label>
            <input type="number" name="quantity" required value="<?= htmlspecialchars($edit_product['quantity'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Mô tả:</label>
            <input type="text" name="description" value="<?= htmlspecialchars($edit_product['description'] ?? '') ?>">
        </div>
        
        <?php if ($edit_product): ?>
            <button type="submit" class="btn btn-update">Lưu thay đổi</button>
            <a href="index.php" class="btn" style="background: #6c757d;">Hủy</a>
        <?php else: ?>
            <button type="submit" class="btn btn-add">Thêm mới</button>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>SL</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= number_format($row['price']) ?> đ</td>
                <td><?= $row['quantity'] ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>
                    <a href="index.php?edit_id=<?= $row['id'] ?>" class="btn btn-edit">Sửa</a>
                    <a href="pocs.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>