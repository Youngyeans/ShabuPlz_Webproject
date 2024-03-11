<?php
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

    // สร้าง query เพื่อดึงข้อมูล table_id จากตาราง orders
    $query = "SELECT DISTINCT table_id FROM orders";

    // ดึงข้อมูลจากฐานข้อมูล
    $result = $db->query($query);

    // สร้าง array เพื่อเก็บข้อมูล table_id
    $tableIds = array();

    // วนลูปเพื่อดึงข้อมูลแต่ละแถวจากผลลัพธ์
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // เพิ่มข้อมูล table_id ลงใน array
        $tableIds[] = $row['table_id'];
    }
    // ส่งข้อมูลในรูปแบบ JSON กลับไปยัง client-side
    echo json_encode($tableIds);
?>
