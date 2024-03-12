<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Edit</title>
    <!-- tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- css -->
    <link rel="stylesheet" href="../css/style.css" />
</head>

<?php
    class MyDB extends SQLite3 {
        function __construct() {
            $this->open('../../back_end/shabu.db');
        }
    }
    // Open Database
    $db = new MyDB();
    if(!$db) {
        echo $db->lastErrorMsg();
    }

    function displayMenuCategory($db, $category) {
    // คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง menu โดยตรวจสอบ status
    $sql = "SELECT menu_name, menu_id, menu_img, status FROM menu WHERE category = :category"; // ใช้ named placeholders
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category', $category); // ใช้ bindValue แทน bindParam
    $result = $stmt->execute();

    if ($result) {
        // วนลูปผ่านทุกแถวของผลลัพธ์
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // ตรวจสอบสถานะของรายการเมนู
            if ($row["status"] == "active") {
                $status = "มีในสต๊อก";
                // แสดงรายการเมนูตามรูปแบบที่กำหนดเมื่อ status เป็น active
                echo '<div class="flex justify-center">';
                echo '<div class="mt-2 p-5">';
                echo '<div class="relative">';
                echo '<div class="w-[180px] h-[195px] bg-cover bg-no-repeat bg-center" style="background-image: url(' . $row["menu_img"] . ');" onclick="addToOrder(\''. $row["menu_name"] . '\', \'quantity_' . $row["menu_name"] . '\')"></div>';
                echo '</div>';
                echo '<p class="mitr text-[20px] text-white mt-4 w-[100%]">' . $row["menu_name"] . '</p>';
                echo '<p class="noto text-[16px] text-white mt-4 w-[100%] tracking-[0.05em]"> สถานะ : ' . $status . '</p>';
                echo '<div class="flex space-x-3 items-center justify-center mt-5">';
                echo '<button onclick="edit(this)" id="' . $row["menu_id"] . '" class="bg-[#C74022] text-white noto py-2 px-10 rounded-full hover:scale-105 transition hover:bg-[#555960]">หมด</button>';
                // echo '<button class="noto font-bold text-[22px] w-[30px] h-[30px] bg-[#D9D9D9] rounded-full hover:bg-[#817B85]" onclick="decreaseQuantity(\'quantity_' . $row["menu_name"] . '\')">-</button>';
                // echo '<div class="bg-[#817B85] w-[120px] py-2 px-4 flex rounded-lg">';
                // echo '<input id="quantity_' . $row["menu_name"] . '" class="font-semibold noto text-[16px] bg-transparent text-white w-10 text-center border-b-[2px] border-white" value="0">';
                // echo '<p class="noto text-[16px] text-white ml-7 font-semibold">ชุด</p>';
                // echo '</div>';
                // echo '<button class="noto font-bold text-[22px] w-[30px] h-[30px] bg-[#D9D9D9] rounded-full hover:bg-[#817B85]" onclick="increaseQuantity(\'quantity_' . $row["menu_name"] . '\')">+</button>';
                echo '</div>';

            } else {
                // แสดงรายการเมนูตามรูปแบบที่กำหนดเมื่อ status เป็น empty
                $status = "หมด";
                echo '<div class="flex justify-center">';
                echo '<div class="mt-2 p-5">';
                echo '<div class="relative">';
                echo '<div class="absolute bg-[#656262CC] w-[180px] h-[195px]"></div>';
                echo '<div class="w-[180px] h-[195px] bg-cover bg-no-repeat bg-center" style="background-image: url(' . $row["menu_img"] . ');"></div>';
                echo '</div>';
                echo '<p class="mitr text-[20px] text-[#B78D43] mt-4 w-[100%]">' . $row["menu_name"] . '</p>';
                echo '<p class="noto text-[16px] text-white mt-4 w-[100%] tracking-[0.05em]"> สถานะ : <span class="underline">' . $status . '</span></p>';
                // echo '<p class="mitr text-[24px] font-semibold text-[#B78D43] mt-2">หมด</p>';
                echo '<div class="flex justify-center mt-5"><button onclick="edit(this)" id="'. $row["menu_id"] .'" class="bg-[#61A12E] text-white noto py-2 px-10 rounded-full hover:scale-105 transition hover:bg-[#555960]">เติม</button></div>';
            }
            echo '</div>';
            echo '</div>';
        }
    }
}
?>

<script>
    function show(){

    }
    function edit(btn){
        var menuId = btn.id;
        if (btn.innerText == "หมด") {
            if (confirm("เมนูนี้หมดใช่หรือไม่")) {
                sendStatusAndMenu(menuId);
                alert("แก้ไขเมนูสำเร็จ");
                location.reload();
            }
        }
        else if (btn.innerText == "เติม") {
            if (confirm("เตินสต๊อกดมนูนี้แล้วหรือไม่")) {
                sendStatusAndMenu(menuId);
                alert("แก้ไขเมนูสำเร็จ");
                location.reload();
            }
        }
    }

    function sendStatusAndMenu(menuId){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText); // สามารถแสดงข้อความตอบกลับจากเซิร์ฟเวอร์ได้
            }
        };
        xhttp.open("POST", "../../back_end/editmenu_chef.php", true); // เปลี่ยนเส้นทางไปยังไฟล์ PHP ที่จะดำเนินการอัปเดตฐานข้อมูล
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("menuId=" + menuId);
        console.log("menuId=" + menuId);
    }
    
    
</script>

<body class="bg-black">
    <div id="navbar-placeholder"></div>
    <script>
        fetch('asset/chefnav.html')
            .then(response => response.text())
            .then(html => {
                document.getElementById('navbar-placeholder').innerHTML = html;
            });
    </script>
    <script defer src="../js/navbar.js"></script>

    <section class="flex justify-center w-[100vw] p-0 m-0">
        <div class="flex mt-[80px] h-[280px]">
            <!-- ฝั่งซ้าย list menu -->
            <div class="w-[70vw] flex justify-center">
                <div>
                    <!-- head -->
                    <div class="">
                        <p class="mitr text-[#B78D43] text-[36px] text-center mt-1">เมนูอาหาร</p>
                        <p class="noto text-[14px] text-white text-center mt-1 tracking-wide">
                            คลิกที่อาหารเพื่อแก้ไขสถานะ</p>
                        <!-- categories -->
                        <div class="grid grid-cols-8 mt-7 gap-3 border-b-[3px] px-2 pb-5 border-[#817B85] mx-36">
                            <button id="1" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img src="../../src/img/bull 1.png">
                                    <p class="noto text-[14px] text-white mt-4 text-center">เนื้อวัว</p>
                                </center>
                            </button>
                            <button id="2" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="mt-3" src="../../src/img/pig 1.png">
                                    <p class="noto text-[14px] text-white mt-5 text-center">เนื้อหมู</p>
                                </center>
                            </button>
                            <button id="3" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="mt-2" src="../../src/img/chicken (2) 1.png">
                                    <p class="noto text-[14px] text-white mt-6 text-center">เนื้อไก่</p>
                                </center>
                            </button>
                            <button id="4" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="mt-3" src="../../src/img/fish 1.png">
                                    <p class="noto text-[14px] text-white mt-6 text-center">อาหารทะเล</p>
                                </center>
                            </button>
                            <button id="5" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="mt-2" src="../../src/img/lettuce 1.png">
                                    <p class="noto text-[14px] text-white mt-5 text-center">ผัก</p>
                                </center>
                            </button>
                            <button id="6" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="mt-1" src="../../src/img/sausage 1.png">
                                    <p class="noto text-[14px] text-white mt-5 text-center">อื่นๆ</p>
                                </center>
                            </button>
                            <button id="7" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="" src="../../src/img/fried-potatoes 1.png">
                                    <p class="noto text-[14px] text-white mt-5 text-center">ของทานเล่น</p>
                                </center>
                            </button>
                            <button id="8" onclick="move(this.id)"
                                class="hover:scale-110 transition hover:bg-[#B78D43] px-2 py-2 rounded-lg">
                                <center>
                                    <img class="mt-2" src="../../src/img/ice-pop 1.png">
                                    <p class="noto text-[14px] text-white mt-6 text-center">ของหวาน</p>
                                </center>
                            </button>
                        </div>
                    </div>
                    <!-- list menu -->
                    <div id="menu" class="py-5 mt-10 pr-8 mx-16 h-[500px] overflow-auto rounded-2xl space-y-20">
                        <!-- แต่ละ catrgory -->
                        <div id="section1" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">เนื้อวัว</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "เนื้อวัว"); ?>
                            </div>
                        </div>

                        <!-- เนื้อหมู -->
                        <div id="section2" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">เนื้อหมู</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "เนื้อหมู"); ?>
                            </div>
                        </div>

                        <!-- เนื้อไก่ -->
                        <div id="section3" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">เนื้อไก่</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "เนื้อไก่"); ?>
                            </div>
                        </div>

                        <!-- อาหารทะเล -->
                        <div id="section4" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">อาหารทะเล</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "อาหารทะเล"); ?>
                            </div>
                        </div>

                        <!-- ผัก -->
                        <div id="section5" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">ผัก</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "ผัก"); ?>
                            </div>
                        </div>

                        <!-- อื่น -->
                        <div id="section6" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">อื่นๆ</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "อื่นๆ"); ?>
                            </div>
                        </div>

                        <!-- ของทานเล่น -->
                        <div id="section7" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">ของทานเล่น</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "ของทานเล่น"); ?>
                            </div>
                        </div>

                        <!-- ของหวาน -->
                        <div id="section8" class="bg-[#817B8538] p-5 px-14 rounded-2xl">
                            <p class="mitr text-[24px] text-[#B0A9B5]">ของหวาน</p>
                            <div class="grid grid-cols-3 gap-[36px] px-10">
                                <?php displayMenuCategory($db, "ของหวาน"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ฝั่งรายการอาหาร -->
        </div>
    </section>

    <!-- ตอนกด catagory -->
    <script>
        function move(id) {
            const section = document.getElementById("section" + id);
            const menu = document.getElementById("menu");
            console.log("menu :" + menu.getBoundingClientRect().top);
            console.log("section :" + section.getBoundingClientRect().top);
            console.log("scrollY :" + menu.scrollY);

            const sectionY = section.getBoundingClientRect().top - menu.getBoundingClientRect().top + menu.scrollTop;
            const scrollOffset = menu.clientHeight / 12;
            console.log("sectionY :" + sectionY);

            menu.scrollTo({
                top: sectionY - scrollOffset,
                behavior: "smooth",
            });
        }

    </script>

</body>

</html>