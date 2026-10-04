<?php
$name = "Nguyen Van An";
$score = 7.5;
if ($score >= 8) {
    $result = "Giỏi";
} elseif ($score >= 6.5) {
    $result = "Khá";
} elseif ($score >= 5) {
    $result = "Trung bình";
} else {
    $result = "Yếu";
}
echo "Tên sinh viên: " . $name . "<br>";
echo "Điểm: " . $score . "<br>";
echo "Xếp hạng: " . $result . "<br>";
?>