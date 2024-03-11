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

    function displayOrder($db, $tableId){
        // คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง orders
        $sql = "SELECT * FROM orders WHERE table_id = $tableId";
        $result = $db->query($sql);

        // วนลูปเพื่อแสดงข้อมูลในรูปแบบของ HTML
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // ดึงข้อมูลจากฐานข้อมูล
            $tableId = $row['table_id'];
            $menuId = $row['menu_id'];
            $quantity = $row['quantity'];
            $status = $row['status'];

            // คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง menu โดยใช้ menu_id เป็นเงื่อนไข
            $menuSql = "SELECT * FROM menu WHERE menu_id = $menuId";
            $menuResult = $db->query($menuSql);
            $menuRow = $menuResult->fetchArray(SQLITE3_ASSOC);
            $menuName = $menuRow['menu_name'];
            $menuImg = $menuRow['menu_img'];

            // สร้าง HTML สำหรับแสดงข้อมูล
            echo '<div class="bg-[#D7D4CF] rounded-2xl p-6 h-[335px] transition hover:scale-105">';
            echo '<center>';
            echo '<div class="w-[200px] h-[160px] bg-cover bg-no-repeat bg-center rounded-3xl" style="background-image: url(' . $menuImg . ');"></div>';
            echo '<p class="mitr text-[20px] mt-4">' . $menuName . '</p>';
            echo '<p class="noto text-[16px]">จำนวน ' . $quantity . ' ชุด</p>';
            if($status == 'active'){
                echo '<div class="bg-[#61A12E] text-white px-4 py-2 rounded-lg mt-4 w-[75%] noto">จัดเตรียมสำเร็จ</div>';
            } else if($status == 'process'){
                echo '<div class="bg-[#C79922] text-white px-4 py-2 rounded-lg mt-4 w-[75%] noto"> กำลังจัดเตรียม</div>';
            } else if($status =='non-active'){
                echo '<div class="bg-[#C74022] text-white px-4 py-2 rounded-lg mt-4 w-[75%] noto">ยังไม่ได้จัดเตรียม</div>';
            }
            echo '</center>';
            echo '</div>';
        }
    }

    // รับค่าโต๊ะที่ถูกส่งมาจาก AJAX request
    $tableId = $_POST['table-select'] ?? 0;
    // เรียกใช้ฟังก์ชัน displayOrder() เพื่อแสดงข้อมูลรายการอาหาร
    displayOrder($db, $tableId);
?>
