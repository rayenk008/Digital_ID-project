<?php

$dbFile = __DIR__ . '/users.db';

try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            age INTEGER
        )"
    );

    $name = trim($_POST['name'] ?? '');
    $age = (int)($_POST['age'] ?? 0);

    $stmt = $pdo->prepare("INSERT INTO users (name, age) VALUES (:name, :age)");
    $stmt->execute([
        ':name' => $name,
        ':age' => $age,
    ]);

    echo "Form received";
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . htmlspecialchars($e->getMessage());
}
