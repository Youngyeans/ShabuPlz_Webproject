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

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // ทำการอัปเดตข้อมูลในตาราง orders
    $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);
    $stmt->bindValue(':order_id', $order_id, SQLITE3_INTEGER);

    // ทำการ execute คำสั่ง SQL
    $result = $stmt->execute();

    if ($result) {
        // สำเร็จในการอัปเดตข้อมูล
        echo "อัปเดตสถานะเรียบร้อยแล้ว";
    } else {
        // ไม่สามารถอัปเดตข้อมูลได้
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }

?>