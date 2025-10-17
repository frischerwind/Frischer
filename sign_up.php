<?php
session_start();

// بيانات الاتصال بقاعدة البيانات - عدلها حسب إعداداتك
$host = "localhost";
$dbname = "your_database";
$username = "your_db_user";
$password = "your_db_password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // ضبط الخطأ على Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}

// استلام بيانات النموذج
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// التحقق من صحة الإدخال
if (empty($email) || empty($password)) {
    die("Bitte füllen Sie alle Felder aus.");
}

// تحقق مما إذا كان البريد الإلكتروني موجودًا بالفعل في قاعدة البيانات
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->fetch()) {
    die("Dieser E-Mail ist bereits registriert.");
}

// تشفير كلمة المرور
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// إدخال بيانات المستخدم في قاعدة البيانات
$stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :password_hash)");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password_hash', $password_hash);
$stmt->execute();

// تسجيل الدخول تلقائيًا بعد التسجيل (اختياري)
$_SESSION['user_id'] = $pdo->lastInsertId();
$_SESSION['user_email'] = $email;

// إعادة التوجيه للصفحة الرئيسية بعد التسجيل
header("Location: index.html");
exit();
?>
