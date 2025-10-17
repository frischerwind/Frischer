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

// استعلام آمن لمنع حقن SQL
$stmt = $pdo->prepare("SELECT id, email, password_hash FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // تحقق من كلمة المرور باستخدام password_verify
    if (password_verify($password, $user['password_hash'])) {
        // تسجيل الدخول ناجح
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        // إعادة التوجيه للصفحة الرئيسية أو صفحة محمية
        header("Location: index.html");
        exit();
    } else {
        die("Ungültige E-Mail oder Passwort.");
    }
} else {
    die("Ungültige E-Mail oder Passwort.");
}
?>
