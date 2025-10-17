<?php
$host = "localhost";
$dbname = "frischer_wind_db";
$username = "your_db_user";  // قم بتغييرها إلى اسم المستخدم الخاص بك
$password = "your_db_password";  // قم بتغييرها إلى كلمة المرور الخاصة بك

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Erfolgreich mit der Datenbank verbunden!";
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}
?>
