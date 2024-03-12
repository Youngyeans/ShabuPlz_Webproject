<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViewReserveList</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;400&family=Libre+Caslon+Text&family=Kolker+Brush&display=swap');

        .custom-bg-color {
            background-color: rgba(129, 123, 133, 0.22);
        }

        h2 {
            color: #B78D43;
            font-family: 'Mitr';
        }

        h3 {
            font-family: 'Noto Sans Thai';
            font-size: medium;
            color: #B78D43;
        }

        .custom-thead {
            font-family: 'Noto Sans Thai';
            font-size: large;
        }

        .custom-tr {
            /* background-color: #B78D43; */
            /* เปลี่ยนสีพื้นหลังของแถว */
            border-radius: 20px;
            font-family: 'Noto Sans Thai';
        }

        /* .custom-button {
            background-color: #555960;
            border-radius: 35px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Noto Sans Thai';
        } */

        .custom-button:hover {
            background-color: rgb(185, 182, 182);
        }
    </style>
</head>

<body class="bg-black">
    <div id="navbar-placeholder"></div>
    <script>
        fetch('asset/waiternav.html')
            .then(response => response.text())
            .then(html => {
                document.getElementById('navbar-placeholder').innerHTML = html;
            });
    </script>

    <div class="flex flex-col justify-center items-center h-[100vh]">
        <div class="flex flex-col justify-center items-center w-[70%] h-full pt-7 pb-3 mt-3">
            <h2 class="text-5xl mb-4 text-gold">รายการจองโต๊ะ</h2>
            <div class="bg-[#D7D4CF] p-8 rounded-lg shadow-md max-w-6xl w-full h-[80%]">
                <div class="head grid grid-cols-6 w-[100%] gap-[30px] p-3 pb-4 border-b-2 border-[#7A6464]">
                    <div class="text-center mitr text-[20px] ">ชื่อผู้จอง</div>
                    <div class="text-center mitr text-[20px] ">จำนวนคน</div>
                    <div class="text-center mitr text-[20px] ">วันที่จอง</div>
                    <div class="text-center mitr text-[20px] ">เวลา</div>
                    <div class="text-center mitr text-[20px] ">โต๊ะ</div>
                    <div class="text-center mitr text-[20px] invisible">ยกเลิก</div>
                </div>
                <!-- <table class="w-full table-auto">
                    <thead>
                        <tr class="custom-thead text-black ">
                            <th class="px-4 py-2 ">ชื่อผู้จอง</th>
                            <th class="px-4 py-2 ">จำนวนคน</th>
                            <th class="px-4 py-2 ">วันที่จอง</th>
                            <th class="px-4 py-2 ">เวลา</th>
                            <th class="px-4 py-2 ">โต๊ะ</th>
                            <th class="px-4 py-2 ">ยกเลิก</th>
                        </tr>
                    </thead>
                    <tbody class="space-y-5"> -->
                        <?php
                        class MyDB extends SQLite3
                        {
                            function __construct()
                            {
                                $this->open('../../back_end/shabu.db');
                            }
                        }

                        $db = new MyDB();
                        if (!$db) {
                            echo $db->lastErrorMsg();
                        }

                        $query = "SELECT * FROM reservation";
                        $result = $db->query($query);

                        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {

                            $cust_name = $row['cust_name'];
                            $reservation_date = $row['reservation_date'];
                            $reservation_time = $row['reservation_time'];
                            $cust_num = $row['cust_num'];
                            $reservation_id = $row['reservation_id'];
                            $table_id = $row['table_id'];

                            echo '<div class="head grid grid-cols-6 w-[100%] gap-[30px] p-3 pb-4 bg-[#D7D4CF] my-3 rounded-2xl shadow-md hover:scale-105">';
                            echo '<div class="text-center noto text-[20px] flex justify-center items-center">' . $cust_name . '</div>';
                            echo '<div class="text-center noto text-[20px] flex justify-center items-center ">' . $cust_num . '</div>';
                            echo '<div class="text-center noto text-[20px] flex justify-center items-center ">' . $reservation_date . '</div>';
                            echo '<div class="text-center noto text-[20px] flex justify-center items-center ">' . $reservation_time . '</div>';
                            echo '<div class="text-center noto text-[20px] flex justify-center items-center ">' . $table_id . '</div>';
                            echo '<button id="' . $reservation_id . '" onclick="cancle(this)" class="bg-[#555960] noto text-white text-[20px] py-2 px-4 rounded-full mx-2 hover:scale-105 hover:bg-[#C74022]">ยกเลิก</button>';
                            echo '</div>';
                        }
                        ?>
            </div>
        </div>

    </div>

    <script>
        function cancle(btn) {
            var reservation_id = btn.id;
            if (confirm("ต้องการยกเลิกการจองใช่ไหม")) {
                cancelReservation(reservation_id);
                btn.innerText = "ยกเลิกสำเร็จ";
                btn.disabled = true;
                btn.classList.remove('bg-[#555960]');
                btn.classList.add('bg-[#C74022]');
                // ใส่เปลี่ยนสีให้หน่อย
            }
        }

        function cancelReservation(reservation_id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText); // สามารถแสดงข้อความตอบกลับจากเซิร์ฟเวอร์ได้
                }
            };
            xhttp.open("POST", "../../back_end/deletereserve.php", true); // เปลี่ยนเส้นทางไปยังไฟล์ PHP ที่จะดำเนินการอัปเดตฐานข้อมูล
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("reservation_id=" + reservation_id);
        }
    </script>
</body>

</html>