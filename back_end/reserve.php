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

    $reservname = $_POST['reservname'];
    $numpeople = $_POST['numpeople'];
    $bookingdate = $_POST['bookingdate'];
    $bookingtime = $_POST['bookingtime'];
    $selectedTable = $_POST['selectedTable'];

    $sql = "INSERT INTO reservation (cust_name, reservation_date, reservation_time, cust_num, table_id)
        VALUES ('$reservname', '$bookingdate', '$bookingtime', $numpeople, $selectedTable)";
    $result = $db->exec($sql);

    if ($result) {
        // สำเร็จในการเพิ่มข้อมูล
        echo "success";
    } else {
        // ไม่สามารถเพิ่มข้อมูลได้
        echo "error";
    }
    
?>