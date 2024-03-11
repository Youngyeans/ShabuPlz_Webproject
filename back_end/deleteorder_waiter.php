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

    $order_id = $_POST['orderId'];
    $sql = "DELETE FROM orders WHERE order_id = $order_id";
    $result = $db->exec($sql);

    if ($result) {
        // สำเร็จในการอัปเดตข้อมูล
        echo "อัปเดตสถานะเรียบร้อยแล้ว";
        header("Location: ../frontend/html/serving.html");
    } else {
        // ไม่สามารถอัปเดตข้อมูลได้
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }

?>
