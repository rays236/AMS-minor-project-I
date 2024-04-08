<?php

$user = 'root';
$data = 'assignmentDB';
$host = 'localhost';
$pass = '';
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);