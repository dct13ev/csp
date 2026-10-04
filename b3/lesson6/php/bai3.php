<?php
$products = [
    [
        "name" => "Bánh mì",
        "price" => 15000,
        "quantity" => 2
    ],
    [
        "name" => "Sữa",
        "price" => 30000,
        "quantity" => 1
    ],
    [
        "name" => "Trứng",
        "price" => 25000,
        "quantity" => 3
    ]
];

$tongtien = 0;

echo "===== DANH SÁCH SẢN PHẨM =====\n\n";

foreach ($products as $product) {
    $thanhtien = $product["price"] * $product["quantity"];
    $tongtien += $thanhtien;

    echo $product["name"] . " - "
        . number_format($product["price"]) . " VNĐ x "
        . $product["quantity"] . " = "
        . number_format($thanhtien) . " VNĐ\n";
}

$giamgia = $tongtien >= 100000 ? $tongtien * 0.1 : 0;
$tongtiencanthanhtoan = $tongtien - $giamgia;

echo "\nThành tiền: " . number_format($tongtien) . " VNĐ\n";
echo "Giảm giá: " . number_format($giamgia) . " VNĐ\n";
echo "Thanh toán: " . number_format($tongtiencanthanhtoan) . " VNĐ\n";
?>
