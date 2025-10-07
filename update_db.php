<?php
include 'config.php';

try {
    $pdo->exec("ALTER TABLE clubs ADD COLUMN image VARCHAR(255) DEFAULT NULL");
    echo "Database updated successfully!";
} catch(PDOException $e) {
    if(strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Column already exists - no update needed.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
