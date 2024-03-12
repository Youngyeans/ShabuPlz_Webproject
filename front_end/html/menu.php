<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
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
    $sql = "SELECT menu_name, menu_img, status FROM menu WHERE category = :category"; // ใช้ named placeholders
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category', $category); // ใช้ bindValue แทน bindParam
    $result = $stmt->execute();

    if ($result) {
        // วนลูปผ่านทุกแถวของผลลัพธ์
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // ตรวจสอบสถานะของรายการเมนู
            if ($row["status"] == "active") {
                // แสดงรายการเมนูตามรูปแบบที่กำหนดเมื่อ status เป็น active
                echo '<div class="flex justify-center">';
                echo '<div class="mt-2 p-5">';
                echo '<div class="relative">';
                echo '<div class="w-[180px] h-[195px] bg-cover bg-no-repeat bg-center" style="background-image: url(' . $row["menu_img"] . ');" onclick="addToOrder(\''. $row["menu_name"] . '\', \'quantity_' . $row["menu_name"] . '\')"></div>';
                echo '</div>';
                echo '<p class="mitr text-[20px] text-white mt-4 w-[100%]">' . $row["menu_name"] . '</p>';
                echo '<div class="flex space-x-3 items-center justify-center mt-2">';
                echo '<button class="noto font-bold text-[22px] w-[30px] h-[30px] bg-[#D9D9D9] rounded-full hover:bg-[#817B85]" onclick="decreaseQuantity(\'quantity_' . $row["menu_name"] . '\')">-</button>';
                echo '<div class="bg-[#817B85] w-[120px] py-2 px-4 flex rounded-lg">';
                echo '<input id="quantity_' . $row["menu_name"] . '" class="font-semibold noto text-[16px] bg-transparent text-white w-10 text-center border-b-[2px] border-white" value="0">';
                echo '<p class="noto text-[16px] text-white ml-7 font-semibold">ชุด</p>';
                echo '</div>';
                echo '<button class="noto font-bold text-[22px] w-[30px] h-[30px] bg-[#D9D9D9] rounded-full hover:bg-[#817B85]" onclick="increaseQuantity(\'quantity_' . $row["menu_name"] . '\')">+</button>';
                echo '</div>';

            } else {
                // แสดงรายการเมนูตามรูปแบบที่กำหนดเมื่อ status เป็น empty
                echo '<div class="flex justify-center">';
                echo '<div class="mt-2 p-5">';
                echo '<div class="relative">';
                echo '<div class="absolute bg-[#6562628C] w-[180px] h-[195px]"></div>';
                echo '<div class="w-[180px] h-[195px] bg-cover bg-no-repeat bg-center" style="background-image: url(' . $row["menu_img"] . ');"></div>';
                echo '</div>';
                echo '<p class="mitr text-[20px] text-white mt-4 w-[100%]">' . $row["menu_name"] . '</p>';
                echo '<p class="mitr text-[24px] font-semibold text-[#B78D43] mt-2">หมด</p>';
            }
            echo '</div>';
            echo '</div>';
        }
    }
}
?>

<body class="bg-black">
    <div id="navbar-placeholder"></div>
    <script>
        fetch('asset/navbar.html')
            .then(response => response.text())
            .then(html => {
                document.getElementById('navbar-placeholder').innerHTML = html;
            });
    </script>
    <script defer src="../js/navbar.js"></script>

    <section class="flex justify-center w-[100vw] p-0 m-0">
        <div class="flex mt-[80px] h-[30vh]">
            <!-- ฝั่งซ้าย list menu -->
            <div class="w-[70vw] flex justify-center">
                <div>
                    <!-- head -->
                    <div class="">
                        <p class="mitr text-[#B78D43] text-[36px] text-center mt-1">เมนูอาหาร</p>
                        <p class="noto text-[14px] text-white text-center mt-1 tracking-wide">
                            คลิกที่อาหารเพื่อเพิ่มเข้ารายการ</p>
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
                    <div id="menu" class="py-5 mt-10 pr-8 mx-16 h-[53vh] overflow-auto rounded-2xl space-y-20">
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
            <div class="w-[30vw]flex justify-center pt-5">
                <div
                    class="bg-[#D7D4CF] w-[23vw] h-[85vh] rounded-2xl flex justify-center hover:scale-105 transition">
                    <div class="w-[100%] p-3 pt-2">
                        <p class="mitr text-[28px] mt-6 text-[#B78D43] text-center">รายการอาหาร</p>
                        <div class="flex mt-3 border-b-[3px] pb-8 border-[#817B85] p-2 ml-2 flex justify-center">
                            <select id="tableSelect" class="w-[50%] mitr text-[16px] bg-[#D9D9D9] shadow-md p-3 w-[144px] shadow-[#00000033] rounded-lg text-[#B78D43] py-2 ">
                                <option value="">เลือกโต๊ะ</option>
                                <?php
                                    // สร้างตัวเลือกโต๊ะตั้งแต่ 1 ถึง 12
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- กล่องให้ใส่ -->
                        <div id="order-container" class="h-[60%] mt-7 overflow-auto space-y-3 py-2 pr-3"></div>

                        <div class="flex justify-center mt-5">
                            <button id="orderButton" class="hover:scale-105 transition hover:bg-[#B78D43] text-center text-[20px] noto font-semibold bg-[#555960] text-white py-3 px-12 rounded-full" onclick="orderFood()">สั่งอาหาร</button>
                        </div>
                    </div>
                </div>
            </div>
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

        function decreaseQuantity(quantityId) {
            var quantityInput = document.getElementById(quantityId);
            var quantity = parseInt(quantityInput.value);
            if (quantity > 0) {
                quantity--;
                quantityInput.value = quantity;
            }
        }

        function increaseQuantity(quantityId) {
            var quantityInput = document.getElementById(quantityId);
            var quantity = parseInt(quantityInput.value);
            quantity++;
            quantityInput.value = quantity;
        }

        function addToOrder(menuName, quantityId) {
            // หา element ของ input จำนวนสินค้า
            var quantityInput = document.getElementById(quantityId);

            // ดึงค่าจำนวนสินค้าจาก input
            var quantity = parseInt(quantityInput.value);

            // ตรวจสอบว่ารายการอาหารนี้มีอยู่ในรายการออร์เดอร์แล้วหรือไม่
            var existingItem = document.querySelector("#order-container [data-menu-name='" + menuName + "']");

            if (existingItem) {
                // ถ้ามีอยู่แล้ว ให้เพิ่มจำนวนสินค้าเข้าไป
                var existingQuantity = parseInt(existingItem.querySelector(".quantity").textContent);
                existingQuantity += quantity;
                existingItem.querySelector(".quantity").textContent = existingQuantity;
            } else {
                // ถ้ายังไม่มีอยู่ในรายการออร์เดอร์ ให้สร้างรายการใหม่
                var orderItem = document.createElement("div");
                orderItem.classList.add("m-1", "hover:scale-105", "space-x-3", "mitr", "text-[16px]", "bg-[#D9D9D9]", "shadow-md", "p-3", "shadow-[#00000033]", "rounded-lg", "flex");
                orderItem.dataset.menuName = menuName; // เก็บชื่อเมนูเป็นข้อมูลใน dataset

                // สร้าง element สำหรับชื่ออาหาร
                var nameParagraph = document.createElement("p");
                nameParagraph.classList.add("mitr", "text-[16px]", "w-[150px]");
                nameParagraph.textContent = menuName;

                // สร้าง element สำหรับจำนวนสินค้า
                var quantitySpan = document.createElement("span");
                quantitySpan.classList.add("quantity");
                quantitySpan.textContent = quantity;

                var decreaseButton = document.createElement("button");
                decreaseButton.classList.add("w-6", "h-6", "bg-[#B78D43]", "rounded-full", "hover:bg-[#817B85]");
                decreaseButton.textContent = "-";
                decreaseButton.onclick = function() {
                    quantity--;
                    if (quantity < 0) {
                        quantity = 0; // ตรวจสอบไม่ให้ลดจำนวนต่ำกว่า 0
                    }
                    quantitySpan.textContent = quantity; // อัพเดทจำนวนใน order
                };

                var increaseButton = document.createElement("button");
                increaseButton.classList.add("w-6", "h-6", "bg-[#B78D43]", "rounded-full", "hover:bg-[#817B85]");
                increaseButton.textContent = "+";
                increaseButton.onclick = function() {
                    quantity++;
                    quantitySpan.textContent = quantity; // อัพเดทจำนวนใน order
                };

                // ปรับตำแหน่งของปุ่มและจำนวนสินค้า
                nameParagraph.style.marginTop = "8px";
                decreaseButton.style.marginTop = "8px"; // ปรับตำแหน่งลงมา 5px
                increaseButton.style.marginTop = "8px"; // ปรับตำแหน่งลงมา 5px
                quantitySpan.style.marginTop = "8px"; // ปรับตำแหน่งลงมา 5px

                // สร้าง element สำหรับลบรายการอาหาร
                var deleteButton = document.createElement("div");
                deleteButton.classList.add("ml-4", "hover:bg-[#C74022]", "hover:text-white", "p-2", "rounded-lg");
                deleteButton.innerHTML = '<i class="text-[24px] fa-regular fa-trash-can"></i>';

                // เพิ่ม element ลงใน element หลัก
                orderItem.appendChild(nameParagraph);
                orderItem.appendChild(decreaseButton);
                orderItem.appendChild(quantitySpan);
                orderItem.appendChild(increaseButton);
                orderItem.appendChild(deleteButton);

                // เพิ่ม event listener สำหรับการลบรายการอาหาร
                deleteButton.addEventListener("click", function() {
                    orderItem.remove(); // ลบรายการอาหารออกจากรายการออร์เดอร์
                });

                // เพิ่ม element รายการอาหารลงใน container ของรายการออร์เดอร์
                var orderContainer = document.getElementById("order-container");
                orderContainer.appendChild(orderItem);
            }
        }
        
        function orderFood() {
            // รับค่าเลขโต๊ะที่ถูกเลือก
            var tableId = document.getElementById("tableSelect").value;

            if (!tableId) {
                alert("โปรดเลือกเลขโต๊ะก่อนสั่งอาหาร");
                return; // หยุดฟังก์ชันทันทีถ้าไม่มีการเลือกเลขโต๊ะ
            }

            // รับข้อมูลจากตารางออร์เดอร์
            var orderItems = document.querySelectorAll("#order-container .flex[data-menu-name]");

            // สร้าง XML Document
            var xmlDoc = new XMLHttpRequest();

            // กำหนดข้อมูลที่จะส่งไปยังเซิร์ฟเวอร์
            var data = "tableId=" + tableId;
            orderItems.forEach(function(item) {
                var menuName = item.dataset.menuName;
                var quantity = parseInt(item.querySelector(".quantity").textContent);
                data += "&menuName[]=" + encodeURIComponent(menuName);
                data += "&quantity[]=" + encodeURIComponent(quantity);
            });

            // เปิดการเชื่อมต่อ
            xmlDoc.open("POST", "../../back_end/save_order.php", true);

            // กำหนดส่วนของ header เพื่อระบุประเภทข้อมูลที่จะส่งไปยังเซิร์ฟเวอร์
            xmlDoc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // เมื่อสำเร็จ
            xmlDoc.onreadystatechange = function() {
                if (xmlDoc.readyState == 4 && xmlDoc.status == 200) {
                    alert(xmlDoc.responseText); // แสดงผลการบันทึกข้อมูล
                    document.getElementById("order-container").innerHTML = ""; // ล้างรายการอาหารที่เลือก
                    document.getElementById("tableSelect").value = ""; // ล้างค่าเลขโต๊ะที่เลือก
                }
            }

            // ส่งข้อมูลไปยังเซิร์ฟเวอร์
            xmlDoc.send(data);
        }

    </script>

</body>

</html>