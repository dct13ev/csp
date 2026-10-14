<?php

$today = $pdo->query(
    "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
     FROM orders
     WHERE DATE(order_date) = CURDATE() AND status = 'Hoàn thành'"
)->fetch();
$week = $pdo->query(
    "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
     FROM orders
     WHERE order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
     AND status = 'Hoàn thành'"
)->fetch();
$month = $pdo->query(
    "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
     FROM orders
     WHERE order_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
     AND status = 'Hoàn thành'"
)->fetch();
$six_months = $pdo->query(
    "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
     FROM orders
     WHERE order_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
     AND status = 'Hoàn thành'"
)->fetch();
$year = $pdo->query(
    "SELECT COUNT(*) orders, COALESCE(SUM(total_amount),0) total
     FROM orders
     WHERE order_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
     AND status = 'Hoàn thành'"
)->fetch();

echo str_replace(
    [
        '{{today_orders}}', '{{today_total}}',
        '{{week_orders}}', '{{week_total}}',
        '{{month_orders}}', '{{month_total}}',
        '{{six_months_orders}}', '{{six_months_total}}',
        '{{year_orders}}', '{{year_total}}',
    ],
    [
        $today['orders'], format_number($today['total']),
        $week['orders'], format_number($week['total']),
        $month['orders'], format_number($month['total']),
        $six_months['orders'], format_number($six_months['total']),
        $year['orders'], format_number($year['total']),
    ],
    file_get_contents('giao_dien/admin/thong_ke.html')
);
