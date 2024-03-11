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

    function showOrderchef($db, $tableId){
        $sql = "SELECT order_id, menu_id, quantity, status FROM orders WHERE table_id = $tableId";
        $result = $db->query($sql);

        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // ดึงข้อมูลจากฐานข้อมูล
            $orderId = $row['order_id'];
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
            echo '<div class="bg-[#D7D4CF] rounded-2xl p-6 h-[57%] transition hover:scale-105">';
            echo '<center>';
            echo '<div class="w-[100%] h-[160px] bg-cover bg-no-repeat bg-center rounded-3xl" style="background-image: url(' . $menuImg . ');"></div>';
            echo ' <p class="mitr text-[20px] mt-4">' . $menuName . '</p>';
            echo '<p class="noto text-[16px]">จำนวน ' . $quantity . ' ชุด</p>';
            if($status == 'non-active'){
                echo '<button id="' . $orderId . '" onclick="change(this)" class="bg-[#7A6464] text-white px-4 py-2 rounded-full mt-4 w-[75%] noto hover:scale-105 hover:bg-[#1C1B1D]">ยังไม่ได้จัดเตรียม</button>';
            } else if($status == 'process'){
                echo '<button id="' . $orderId . '" onclick="change(this)" class=" text-white px-4 py-2 rounded-full mt-4 w-[75%] noto hover:scale-105 hover:bg-[#1C1B1D] bg-[#B78D43]">กำลังจัดเตรียม</button>';
            } else if($status =='active'){
                echo '<button id="' . $orderId . '" onclick="change(this)" class="text-white px-4 py-2 rounded-full mt-4 w-[75%] noto bg-[#61A12E]" disabled="">จัดเตรียมสำเร็จ</button>';
            }
            echo '</center>';
            echo '</div>';
        }
    }

    $tableNumber = $_POST['tableNumber'];
    if(isset($_POST['tableNumber'])) {
        // ทำสิ่งที่ต้องการเมื่อมีการส่งค่า tableNumber มา
        showOrderchef($db, $tableNumber);
    } else {
        // กรณีที่ไม่มีค่า tableNumber ถูกส่งมา
        echo "ไม่สามารถรับค่า tableNumber ได้";
    }

?>
