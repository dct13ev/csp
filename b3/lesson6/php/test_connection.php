$dsn = "mysql:host=localhost;dbname=demo_sql";

try {
    $pdo = new PDO($dsn, "root", "");
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}   