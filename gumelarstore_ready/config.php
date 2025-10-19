<?php
$DB_HOST='127.0.0.1'; $DB_NAME='gumelar_store_db'; $DB_USER='root'; $DB_PASS='';
try {
    $pdo = new PDO("mysql:host=$DB_HOST;charset=utf8mb4",$DB_USER,$DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$DB_NAME` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$DB_NAME`");
} catch (Exception $e){ die('DB error: '.$e->getMessage()); }
if (!isset($_SESSION)) session_start();
$site_name = 'GumelarStore';
?>