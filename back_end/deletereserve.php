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

    $reservation_id = $_POST['reservation_id'];

    $sql_reservation = "DELETE FROM reservation WHERE reservation_id = $reservation_id";
    $result_reservation = $db->exec($sql_reservation);

    $sql_payment = "DELETE FROM payment WHERE reservation_id = $reservation_id";
    $result_payment = $db->exec($sql_payment);
    
    if ($result_reservation && $result_payment) {
        // สำเร็จในการอัปเดตข้อมูล
        echo "อัปเดตสถานะเรียบร้อยแล้ว";
    } else {
        // ไม่สามารถอัปเดตข้อมูลได้
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }

?>
