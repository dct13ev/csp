<?php
$dsn = "mysql:host=127.0.0.1;port=3307;dbname=db_tiemtra;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, "root", "", [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    ]);
} 

catch (PDOException $e) {
    die("Không kết nối được database: " . $e->getMessage()
        . "\nKiểm tra lại kết nối.\n");
}
?>