<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Change if you have a MySQL password

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database and tables
    $pdo->exec("CREATE DATABASE IF NOT EXISTS club_manager");
    $pdo->exec("USE club_manager");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('student', 'admin', 'club_admin') DEFAULT 'student',
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        club_id INT DEFAULT NULL,
        FOREIGN KEY (club_id) REFERENCES clubs(id)
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS clubs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        image VARCHAR(255)
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        club_id INT,
        title VARCHAR(100) NOT NULL,
        description TEXT,
        event_date DATE,
        FOREIGN KEY (club_id) REFERENCES clubs(id)
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        club_id INT,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        UNIQUE KEY unique_registration (user_id, club_id),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (club_id) REFERENCES clubs(id)
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS event_registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        event_id INT,
        UNIQUE KEY unique_event_registration (user_id, event_id),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (event_id) REFERENCES events(id)
    )");
    
    // Insert admin user
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password, role, status) VALUES (?, ?, ?, ?)");
    $stmt->execute(['admin', password_hash('password', PASSWORD_DEFAULT), 'admin', 'approved']);
    
    echo "Database setup complete! Admin login: admin/password";
    
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
