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

    function displaybill($db, $table_id, $reservation_date)
    {
        $sql = "SELECT * FROM reservation WHERE table_id = $table_id AND reservation_date = :reservation_date";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':reservation_date', $reservation_date);
        // ทำการ execute query
        $result = $stmt->execute();

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($result) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                // ดึงข้อมูลจากแต่ละแถวและทำการใช้งาน
                $reservation_id = $row['reservation_id'];
                $cust_num = $row['cust_num'];
                $table_id = $row['table_id'];
                $reservation_date = $row['reservation_date'];
                // ดึงข้อมูลจากตาราง payment
                $paymentSql = "SELECT * FROM payment WHERE reservation_id = '$reservation_id' AND payment_datetime = :payment_datetime";
                $paymentStmt = $db->prepare($paymentSql);
                $paymentStmt->bindParam(':payment_datetime', $reservation_date);
                $paymentResult = $paymentStmt->execute();
                
                $paymentRow = $paymentResult->fetchArray(SQLITE3_ASSOC);
                $payment_id = $paymentRow['payment_id'];
                $payment_amount = $paymentRow['payment_amount'];
                

                // แสดงข้อมูลบิล
                echo '<div class="flex justify-center h-[50%]">';
                echo '<div class="w-[40%] h-[100%] bg-cover bg-no-repeat bg-center" style="background-image: url(\'../../src/img/sukiyaki.png\');"></div>';
                echo '</div>';
                echo '<div class="">';
                echo '<div class="text-center text-[30px] text-[#B78D43] tracking-[0.05em] mitr font-semibold">Shabu <span class="text-[#7A6464]">PLZ</span></div>';
                echo '<div id="datetime" class="mt-2 text-center text-sm noto">';
                echo '<script>';
                echo 'document.getElementById("datetime").innerHTML = `${date} | ${time}`';
                echo '</script>';
                echo '</div>';

                echo '<div class="text-center noto text-sm ">เลขที่ใบเสร็จ: ' . $payment_id . '</div>';
                echo '<div class="text-center noto text-sm">โต๊ะ: ' . $table_id . '</div>';
                echo '</div>';

                echo '<div class="mt-5">';
                echo '<div class="flex justify-center w-full ">';
                echo '<div class="grid grid-cols-2 w-[85%] border-b-2 border-[#7A6464] pb-2 px-5">';
                echo '<p class=" px-2 py-1 mitr text-sm text-left">รายการ</p>';
                echo '<p class=" px-2 py-1 mitr text-sm text-right">ราคา</p>';
                echo '<p class=" px-2 py-1 noto text-sm text-left">(' . $cust_num . ') ชาบูพลีส บุฟเฟต์</p>';
                echo '<p class=" px-2 py-1 noto text-sm text-right">' . $payment_amount . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                echo '<div class="mt-3 flex flex-row justify-between">';
                echo '<div class="flex justify-center w-full">';
                echo '<div class="grid grid-cols-2 w-[85%] px-5">';
                echo '<p class=" px-2 py-1 text-sm mitr text-left">รวม:</p>';
                echo '<p class=" px-2 py-1 text-sm noto text-right">' . $payment_amount . '</p>';
                echo '<p class=" px-2 py-1 text-sm mitr text-left">VAT 7%:</p>';
                echo '<p class=" px-2 py-1 text-sm noto text-right">' . ($payment_amount * 0.07) . '</p>';
                echo '<p class=" px-2 py-1 text-sm mitr text-left">ยอดรวม:</p>';
                echo '<p class=" px-2 py-1 text-sm noto text-right">' . ($payment_amount * 1.07) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                echo '<div class="flex justify-center mt-7">';
                echo '<div class="w-[100px] h-[100px] bg-cover bg-no-repeat bg-center rounded border-2 border-[#7A6464]" style="background-image: url(\'../../src/img/qrcode.png\');"></div>';
                echo '</div>';
                echo '<div class="flex justify-center my-4">';
                echo '<button id="' . $reservation_id . '" onclick="pay()" class="bg-[#555960] noto tracking-[0.1em] text-[20px] text-white py-2 px-7 rounded-full my-4 hover:scale-105 transition hover:bg-[#B78D43]">ชำระเงิน</button>';
                echo '</div>';
                echo '</div>';
            }
        }
    }

    $table_id = isset($_POST['table-select']) ? $_POST['table-select'] : 0;
    $reservation_date = isset($_POST['date']) ? $_POST['date'] : '';


    displaybill($db, $table_id, $reservation_date);
?>
