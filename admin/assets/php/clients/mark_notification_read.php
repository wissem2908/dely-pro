<?php
session_start();
include_once '../config.php';








$bdd = new PDO(
    "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$stmt = $bdd->prepare("UPDATE notifications SET is_read=1 WHERE inscription_id =? ");
$stmt->execute([ $_SESSION['user_id']]);
