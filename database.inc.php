<?php
    $config = require_once 'config.inc.php';

    try {
        $db_connection = new PDO("mysql:host={$config['MYSQL_HOST']};dbname={$config['MYSQL_DATABASE']};charset=utf8",
        $config['MYSQL_USER'], $config['password'], 
        [PDO::ATTR_EMULATE_PREPARES => false, 
        PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $error) {
        exit('Database error');
    }
?>