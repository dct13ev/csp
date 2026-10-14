<?php

if ($page === 'admin' || $page === 'logout') {
    require 'xu_ly/quan_tri_tai_khoan.php';
} else {
    require_admin();

    if ($page === 'home') {
        render_admin_home();
    } elseif ($page === 'san_phan') {
        require 'xu_ly/quan_tri_san_pham.php';
    } elseif ($page === 'don_hang') {
        require 'xu_ly/quan_tri_don_hang.php';
    } elseif ($page === 'thong_ke') {
        require 'xu_ly/quan_tri_thong_ke.php';
    }
}
