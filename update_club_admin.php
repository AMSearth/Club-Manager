<?php
include 'config.php';

try {
    $pdo->exec("ALTER TABLE users MODIFY COLUMN role ENUM('student', 'admin', 'club_admin') DEFAULT 'student'");
    $pdo->exec("ALTER TABLE users ADD COLUMN club_id INT DEFAULT NULL");
    echo "Database updated for club admin functionality!";
} catch(PDOException $e) {
    if(strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Updates already applied.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
