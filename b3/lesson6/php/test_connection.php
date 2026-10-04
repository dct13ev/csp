$dsn = "mysql:host=localhost;dbname=demo_sql";

try {
    $pdo = new PDO($dsn, "root", "");
    PDO::ATTE_ERMODE    => PDO::ERRMODE_EXCEPTION
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
}   