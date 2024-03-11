<?php
session_start(); // เริ่ม Session
  
class MyDB extends SQLite3 {
    function __construct() {
        $this->open('shabu.db');
    }
}

// Open Database
$db = new MyDB();
if(!$db) {
    echo $db->lastErrorMsg();
}

// รับค่าจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// คำสั่ง SQL เพื่อตรวจสอบข้อมูลผู้ใช้
$sql = "SELECT * FROM employee WHERE username = :username AND password = :password";
$stmt = $db->prepare($sql);
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);
$result = $stmt->execute();

// ตรวจสอบว่ามีผู้ใช้ที่ตรงกับชื่อผู้ใช้และรหัสผ่านที่ใส่เข้ามาหรือไม่
if ($row = $result->fetchArray()) {
    // การเข้าสู่ระบบสำเร็จ
    // เก็บข้อมูลการเข้าสู่ระบบใน Session
    $_SESSION['username'] = $username;

    // ดึง role จากฐานข้อมูล
    $role = $row['role'];

    // เปรียบเทียบ role และส่งกลับไปยังหน้าที่เหมาะสม
    if ($role == 'chef') {
        // ส่งกลับไปยังหน้า order_chef.html
        header("Location: ../front_end/html/order_chef.html");
    } elseif ($role == 'staff') {
        // ส่งกลับไปยังหน้า serving.html
        header("Location: ../front_end/html/serving.html");
    }
} else {
    // การเข้าสู่ระบบไม่สำเร็จ
    header("Location: ../front_end/html/login.html");
}
?>

