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

    $reservname = $_POST['reservname'];
    $numpeople = $_POST['numpeople'];
    $bookingdate = $_POST['bookingdate'];
    $bookingtime = $_POST['bookingtime'];
    $selectedTable = $_POST['selectedTable'];

    $sql_reservation = "INSERT INTO reservation (cust_name, reservation_date, reservation_time, cust_num, table_id)
            VALUES ('$reservname', '$bookingdate', '$bookingtime', $numpeople, $selectedTable)";
    $result_reservation = $db->exec($sql_reservation);

    $reservation_id = $db->lastInsertRowID();

    $payment_datetime = $bookingdate;
    $payment_amount = $numpeople * 499;

    $sql_payment = "INSERT INTO payment (reservation_id, payment_datetime, payment_amount)
            VALUES ($reservation_id, '$payment_datetime', $payment_amount)";
    $result_payment = $db->exec($sql_payment);

    if ($result_reservation && $result_payment) {
        // สำเร็จในการเพิ่มข้อมูล
        echo "success";
    } else {
        // ไม่สามารถเพิ่มข้อมูลได้
        echo "error";
    }

?>