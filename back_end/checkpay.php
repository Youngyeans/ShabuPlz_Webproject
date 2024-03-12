<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('shabu.db');
    }
}
// Open Database
$db = new MyDB();
if (!$db) {
    echo $db->lastErrorMsg();
}

$table_id = $_POST['table_id'];

$sql = "SELECT order_id FROM orders WHERE table_id = $table_id";
$result = $db->query($sql); // เปลี่ยน exec เป็น query

if ($result) {
    // ตรวจสอบว่ามี order ค้างหรือไม่
    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // ถ้ามี order ค้าง ให้ส่งข้อความไปยัง client ว่ามี order ค้าง
        echo "มี order ค้าง";
    } else {
        // ถ้าไม่มี order ค้าง ให้ส่งข้อความไปยัง client ว่าไม่มี order ค้าง
        echo "ไม่มี order ค้าง";
    }
} else {
    // กรณีเกิดข้อผิดพลาดในการ query ให้แสดงข้อความผิดพลาด
    echo "เกิดข้อผิดพลาดในการดึงข้อมูล";
}
?>