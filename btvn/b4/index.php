<?php

require_once 'ket_noi_db/connection.php';
require_once 'xu_ly/ham_chung.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$area = $_GET['area'] ?? 'khach';
$page = $_GET['page'] ?? 'home';
$request_method = $_SERVER['REQUEST_METHOD'];

if ($area === 'khach') {
    require 'xu_ly/khach_hang.php';
} elseif ($area === 'admin') {
    require 'xu_ly/quan_tri.php';
}
