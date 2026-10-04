$dsn = "mysql:host=localhost;dbname=demo_sql";

try {
    $pdo = new PDO($dsn, "root", "");
    PD0::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}   