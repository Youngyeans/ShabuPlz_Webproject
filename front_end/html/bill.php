<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ใบเสร็จอาหาร</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- css -->
  <link rel="stylesheet" href="../css/style.css" />
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
  <script defer src="../js/navbar.js"></script>

  <script>
    let now = new Date();
    // ดึงข้อมูลวันที่และเวลา
    let date = now.toLocaleDateString();
    let time = now.toLocaleTimeString();
  </script>

  <div class="container h-[calc(100vh-100px)] mx-auto pt-10 p-5">
    <div class="flex flex-row justify-between mt-10 mb-2">
      <div class="text-[#B78D43] text-5xl mitr">เช็คบิลอาหาร</div>
      <form id="table-form" class="space-x-7 flex">
        <div class="flex space-x-5">
          <p class="mitr text-[#B78D43] flex items-center text-[20px]">วันที่</p>
          <div id="date" class="mitr bg-[#D9D9D9] mt-1 p-2 border rounded-md">
            <script>
              document.getElementById("date").innerHTML = `${date}`;
              setInterval(showDateTime, 1000);
            </script>
          </div>
        </div>
        <div class="flex space-x-5">
          <p class="mitr text-[#B78D43] flex items-center text-[20px]">โต๊ะ</p>
          <select id="table-select" name="table-select" class="mitr bg-[#D9D9D9] mt-1 p-2 border rounded-md">
              <option value="0">เลข</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
          </select>
        </div>
    </form>
    </div>
    <div class="flex justify-center h-[95%]">
      <div class="bg-[#D7D4CF] p-8 pt-4 rounded-2xl w-[30%] h-full flex flex-col">
        <div class="flex justify-center h-[50%]">
            <div class="w-[40%] h-[100%] bg-cover bg-no-repeat bg-center" style="background-image: url('../../src/img/sukiyaki.png');"></div>
        </div>
        <div class="">
            <div class="text-center text-[30px] text-[#B78D43] tracking-[0.05em] mitr font-semibold">Shabu <span class="text-[#7A6464]">PLZ</span></div>
            <div id="datetime" class="mt-2 text-center text-sm noto">
              <script>
                document.getElementById("datetime").innerHTML = `${date} | ${time}`;
              </script>
            </div>
            <div class="text-center noto text-sm ">เลขที่ใบเสร็จ: 656123456</div>
            <div class="text-center noto text-sm">โต๊ะ: 11</div>
        </div>

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

            $query = "SELECT * FROM payment";
            $result = $db->query($query);

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {

                $pay_id = $row['payment_id'];
                $amount = $row['payment_amount'];

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

          <div class="mt-5">
            <div class="flex justify-center w-full ">
              <div class="grid grid-cols-2 w-[85%] border-b-2 border-[#7A6464] pb-2 px-5">
                  <p class=" px-2 py-1 mitr text-sm text-left">รายการ</p>
                  <p class=" px-2 py-1 mitr text-sm text-right">ราคา</p>
                  <p class=" px-2 py-1 noto text-sm text-left">(2) ชาบูพลีส บุฟเฟต์</p>
                  <p class=" px-2 py-1 noto text-sm text-right">998.00</p>
              </div>
            </div>
          </div>

          <div class="mt-3 flex flex-row justify-between">
            <div class="flex justify-center w-full">
              <div class="grid grid-cols-2 w-[85%] px-5">
                  <p class=" px-2 py-1 text-sm mitr text-left">รวม:</p>
                  <p class=" px-2 py-1 text-sm noto text-right">998.00</p>
                  <p class=" px-2 py-1 text-sm mitr text-left">VAT 7%:</p>
                  <p class=" px-2 py-1 text-sm noto text-right">69.86</p>
                  <p class=" px-2 py-1 text-sm mitr text-left">ยอดรวม:</p>
                  <p class=" px-2 py-1 text-sm noto text-right">1,067.86</p>
              </div>
            </div>
          </div>


          <div class="flex justify-center mt-7">
            <div class="w-[100px] h-[100px] bg-cover bg-no-repeat bg-center rounded border-2 border-[#7A6464]" style="background-image: url('../../src/img/qrcode.png');"></div>
          </div>
          <div class="flex justify-center my-4">
            <button onclick="pay()" class="bg-[#555960] noto tracking-[0.1em] text-[20px] text-white py-2 px-7 rounded-full my-4 hover:scale-105 transition hover:bg-[#B78D43]">ชำระเงิน</button>
          </div>
    </div>
  </div>
  <script>
    function pay() {
      if(confirm("ชำระเงินเรียบร้อยแล้วใช่มั้ย")){
        alert("ชำระเงินสำเร็จ");
      }
    }
  </script>
</body>
</html>
