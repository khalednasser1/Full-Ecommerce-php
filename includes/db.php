<?php
$host = 'localhost';
$db   = 'tech_ecommerce';
$user = 'root';
$pass = '';


$dsn = "mysql:host=$host;dbname=$db;";
$pdo = new PDO($dsn, $user, $pass);
