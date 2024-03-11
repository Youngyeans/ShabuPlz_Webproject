<?php
    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('shabu.db');
        }
    }

    $db = new MyDB();
        if(!$db) {
            echo $db->lastErrorMsg();
    }

    $query = "SELECT DISTINCT table_id FROM orders WHERE status = 'active'";
    $result = $db->query($query);
    $tableIds = array();

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $tableIds[] = $row['table_id'];
    }
    echo json_encode($tableIds);
?>
