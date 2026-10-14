<?php

if ($page === 'thuc_don') {
    require 'xu_ly/khach_hang_thuc_don.php';
} elseif ($page === 'dat_hang') {
    require 'xu_ly/khach_hang_dat_hang.php';
} elseif ($page === 'tra_cuu') {
    require 'xu_ly/khach_hang_tra_cuu.php';
} else {
    render_customer('', 'giao_dien/home/home.css');
}
