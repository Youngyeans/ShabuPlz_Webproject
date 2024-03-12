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
            background-color: #B78D43;
            /* เปลี่ยนสีพื้นหลังของแถว */
            border-radius: 20px;
            font-family: 'Noto Sans Thai';
        }

        .custom-button {
            background-color: #555960;
            border-radius: 35px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Noto Sans Thai';
        }

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

    <div class="flex flex-col justify-center items-center h-screen">
        <h2 class="text-5xl mb-4 text-gold">รายการจองโต๊ะ</h2>
        <div class="flex flex-col justify-center items-center h-screen">
            <h2 class="text-5xl mb-4 text-gold">รายการจองโต๊ะ</h2>
            <div class="bg-gray-300 p-8 rounded-lg shadow-md max-w-6xl w-full">
                <table class="w-full table-auto" style="border-collapse: collapse;">
                    <thead>
                        <tr class="custom-thead bg-gold text-black">
                            <th class="px-4 py-2 border-b-0">ชื่อผู้จอง</th>
                            <th class="px-4 py-2 border-b-0">จำนวนคน</th>
                            <th class="px-4 py-2 border-b-0">วันที่จอง</th>
                            <th class="px-4 py-2 border-b-0">เวลา</th>
                            <th class="px-4 py-2 border-b-0">โต๊ะ</th>
                            <th class="px-4 py-2 border-b-0">ยกเลิก</th>
                        </tr>
                    </thead>
                    <tbody>
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

                            echo '<tr class="custom-tr rounded-lg text-center">';
                            echo '<td class="border px-4 py-2">' . $cust_name . '</td>';
                            echo '<td class="border px-4 py-2">' . $cust_num . '</td>';
                            echo '<td class="border px-4 py-2">' . $reservation_date . '</td>';
                            echo '<td class="border px-4 py-2">' . $reservation_time . '</td>';
                            echo '<td class="border px-4 py-2">' . $table_id . '</td>';
                            echo '<td class="border px-4 py-2">';
                            echo '<button id="' . $reservation_id . '" onclick="cancle(this)" class="custom-button text-white font-bold py-2 px-4 rounded">ยกเลิก</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
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