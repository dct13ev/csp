<?php
$Tensanpham = "Banh mi";
$dongia = 15000;
$soluong = 3;
$thanhtien = $dongia * $soluong;
$vat = $thanhtien * 0.1;
$tongtienphaitra = $thanhtien + $vat;

echo "Tên sản phẩm: " . $Tensanpham . "<br>";
echo "Đơn giá: " . $dongia . "<br>";
echo "Số lượng: " . $soluong . "<br>";
echo "Thành tiền: " . $thanhtien . "<br>";
echo "VAT: " . $vat . "<br>";
echo "Tổng tiền phải trả: " . $tongtienphaitra . "<br>";
?>