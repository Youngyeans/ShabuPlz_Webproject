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

    // ตรวจสอบว่ามีการส่งค่า bookingdate ผ่าน POST หรือไม่
    $bookingDate = $_POST['bookingdate'];
    // Prepare SQL statement with a placeholder for the date
    $sql = "SELECT table_id FROM reservation WHERE reservation_date = :bookingDate";
    $stmt = $db->prepare($sql);
    // Bind the parameter value
    $stmt->bindParam(':bookingDate', $bookingDate);
    // Execute the statement
    $result = $stmt->execute();

    // Fetch table_ids and display buttons accordingly
    $reservedTables = array();
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $reservedTables[] = $row['table_id'];
    }

    for($i = 1; $i <= 12; $i++) {
        if(in_array($i, $reservedTables)) {
            echo "<button id='$i' class='table bg-[#555960] disabled'>$i</button>";
        } else {
            echo "<button id='$i' onclick='select(this)' class='table bg-[#D7D4CF] hover:bg-[#555960] transition'>$i</button>";
        }
    }
    
?>
