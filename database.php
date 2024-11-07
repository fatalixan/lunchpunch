<?php
    // database.php
    function connectDatabase() {
        $host = 'localhost';
        $dbname = 'coffee_shop_db';
        $user = 'your_username';
        $password = 'your_password';
    
        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }
?>
    

