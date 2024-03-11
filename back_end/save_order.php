<?php
// เชื่อมต่อกับฐานข้อมูล
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

// รับข้อมูลจาก JavaScript
$tableId = $_POST['tableId'];
$menuNames = $_POST['menuName'];
$quantities = $_POST['quantity'];

// วนลูปเพื่อบันทึกข้อมูลลงในฐานข้อมูล
for ($i = 0; $i < count($menuNames); $i++) {
    $menuName = $menuNames[$i];
    $quantity = $quantities[$i];
    
    // ค้นหา menu_id จากชื่อเมนู
    $sql = "SELECT menu_id FROM menu WHERE menu_name = :menuName"; // ใช้ named placeholders
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':menuName', $menuName); // ใช้ bindValue เพื่อผูกค่าและระบุประเภทข้อมูล
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $menuId = $row['menu_id'];

    // บันทึกข้อมูลในตาราง orders
    $status = 'non-active'; // ตั้งค่า status เป็น non-active
    $sql = "INSERT INTO orders (table_id, menu_id, quantity, status) VALUES (:tableId, :menuId, :quantity, :status)"; // ใช้ named placeholders
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':tableId', $tableId, SQLITE3_INTEGER); // ใช้ bindValue เพื่อผูกค่าและระบุประเภทข้อมูล
    $stmt->bindValue(':menuId', $menuId, SQLITE3_INTEGER); // ใช้ bindValue เพื่อผูกค่าและระบุประเภทข้อมูล
    $stmt->bindValue(':quantity', $quantity, SQLITE3_INTEGER); // ใช้ bindValue เพื่อผูกค่าและระบุประเภทข้อมูล
    $stmt->bindValue(':status', $status); // ใช้ bindValue เพื่อผูกค่าและระบุประเภทข้อมูล
    $stmt->execute(); // ใช้เมธอด execute() แทนการใช้ exec() และส่งคำสั่ง SQL ไปยังฐานข้อมูล
}



// // ตอบกลับข้อความว่าบันทึกข้อมูลสำเร็จ
// echo "สั่งอาหารแล้ว";

?>


