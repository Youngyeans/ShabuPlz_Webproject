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
    $status = $_POST['status'];

    if($status == 'process'){
        $sql = "UPDATE orders SET status = 'process' WHERE order_id = $order_id";
        $result = $db->exec($sql);
    } else if($status == 'active'){
        $sql = "UPDATE orders SET status = 'active' WHERE order_id = $order_id";
        $result = $db->exec($sql);
    }

    if ($result) {
        // สำเร็จในการอัปเดตข้อมูล
        echo "อัปเดตสถานะเรียบร้อยแล้ว";
    } else {
        // ไม่สามารถอัปเดตข้อมูลได้
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }

?>
