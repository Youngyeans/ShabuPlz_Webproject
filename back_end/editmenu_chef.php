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

$menu_Id = $_POST['menuId'];
echo 'fuck u';  // คำนี้อาจจะไม่เกี่ยวกับการทำงานแต่ให้แสดงให้เห็นว่าโค้ดถูกเรียกใช้

// ไม่ควรใช้ exec() เพื่อดึงข้อมูล SELECT ใช้ prepare() และ execute() แทน
$sql = "SELECT status FROM menu WHERE menu_id = :menuId";
$stmt = $db->prepare($sql);
$stmt->bindParam(':menuId', $menu_Id, SQLITE3_INTEGER);
$result = $stmt->execute();
$status = "";

if ($result) {
    // ใช้ fetchArray() ได้ตรงนี้เนื่องจากเป็นการ SELECT
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $status = $row['status'];
    }

    if ($status == 'active') {
        $newStatus = 'empty';
    } else if ($status == 'empty') {
        $newStatus = 'active';
    }

    // อัปเดตสถานะใหม่
    $sqlUpdate = "UPDATE menu SET status = :newStatus WHERE menu_id = :menuId";
    $stmtUpdate = $db->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':newStatus', $newStatus, SQLITE3_TEXT);
    $stmtUpdate->bindParam(':menuId', $menu_Id, SQLITE3_INTEGER);
    $resultUpdate = $stmtUpdate->execute();

    if ($resultUpdate) {
        echo "อัปเดตสถานะเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }
} else {
    echo "ไม่พบข้อมูลสถานะเมนู";
}
?>
