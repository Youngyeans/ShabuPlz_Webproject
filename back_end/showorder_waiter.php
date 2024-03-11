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

    function showOrderWaiter($db, $tableId){
        $sql = "SELECT order_id, menu_id, quantity FROM orders WHERE table_id = $tableId AND status = 'active'";
        $result = $db->query($sql);

        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // ดึงข้อมูลจากฐานข้อมูล
            $orderId = $row['order_id'];
            $menuId = $row['menu_id'];
            $quantity = $row['quantity'];

            // คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง menu โดยใช้ menu_id เป็นเงื่อนไข
            $menuSql = "SELECT * FROM menu WHERE menu_id = $menuId";
            $menuResult = $db->query($menuSql);
            $menuRow = $menuResult->fetchArray(SQLITE3_ASSOC);
            $menuName = $menuRow['menu_name'];
            $menuImg = $menuRow['menu_img'];

            // สร้าง HTML สำหรับแสดงข้อมูล
            echo '<div class="m-1 hover:scale-105 space-x-3 mitr text-[16px] bg-[#D9D9D9] shadow-md p-3 shadow-[#00000033] rounded-lg flex mx-10">';
            echo '<div class="flex w-[100%] p-2 space-x-10">';
            echo '<div class="w-[100px] h-[70px] bg-cover bg-no-repeat bg-center rounded-xl" style="background-image: url(' . $menuImg . ');"></div>';
            echo '<div class="w-[52%] flex items-center mitr text-[20px]">' . $menuName . '</div>';
            echo '<div class="flex items-center noto text-[16px] noto text-end">จำนวน ' . $quantity . ' ชุด</div>';
            
            // สร้างปุ่มเสิร์ฟ
            echo '<button id="' . $orderId . '" onclick="serve(this)" class="bg-[#555960] text-white noto text-[16px] my-2 px-5 rounded-full transition hover:scale-105 hover:bg-[#B78D43] tracking-[0.1em] text-wservete">เสิร์ฟสำเร็จ</button>';
            
            echo '</div>';
            echo '</div>';
            }
    }

    $tableNumber = $_POST['tableNumber'];
    if(isset($_POST['tableNumber'])) {
        showOrderWaiter($db, $tableNumber);
    } else {
        echo "ไม่สามารถรับค่า tableNumber ได้";
    }

?>
