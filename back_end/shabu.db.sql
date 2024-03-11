BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "employee" (
	"employee_id"	INTEGER,
	"username"	VARCHAR(255),
	"password"	VARCHAR(255),
	"role"	VARCHAR(50) CHECK("role" IN ('staff', 'chef')),
	PRIMARY KEY("employee_id")
);
CREATE TABLE IF NOT EXISTS "menu" (
	"menu_id"	INTEGER,
	"menu_name"	VARCHAR(255),
	"menu_img"	VARCHAR(500),
	"category"	VARCHAR(255),
	"status"	VARCHAR(50) CHECK("status" IN ('active', 'empty')),
	PRIMARY KEY("menu_id")
);
CREATE TABLE IF NOT EXISTS "orders" (
	"order_id"	INTEGER,
	"table_id"	INTEGER,
	"menu_id"	INTEGER,
	"quantity"	INTEGER,
	"status"	VARCHAR(50) CHECK("status" IN ('active', 'non-active', 'process')),
	PRIMARY KEY("order_id"),
	FOREIGN KEY("menu_id") REFERENCES "menu"("menu_id"),
	FOREIGN KEY("table_id") REFERENCES "tables"("table_id")
);
CREATE TABLE IF NOT EXISTS "payment" (
	"payment_id"	INTEGER,
	"reservation_id"	INTEGER,
	"payment_datetime"	VARCHAR(50),
	"payment_amount"	INTEGER,
	PRIMARY KEY("payment_id"),
	FOREIGN KEY("reservation_id") REFERENCES "reservation"("reservation_id")
);
CREATE TABLE IF NOT EXISTS "reservation" (
	"reservation_id"	INTEGER,
	"cust_name"	VARCHAR(255),
	"reservation_date"	VARCHAR(50),
	"reservation_time"	VARCHAR(50),
	"cust_num"	INTEGER,
	"table_id"	INTEGER,
	PRIMARY KEY("reservation_id"),
	FOREIGN KEY("table_id") REFERENCES "tables"("table_id")
);
CREATE TABLE IF NOT EXISTS "tables" (
	"table_id"	INTEGER,
	"table_number"	INTEGER,
	"status"	VARCHAR(50) CHECK("status" IN ('active', 'empty')),
	PRIMARY KEY("table_id")
);
INSERT INTO "employee" VALUES (1,'it65070090','Tae21424704','staff');
INSERT INTO "menu" VALUES (1,'เนื้อวากิว','https://us-fbcloud.net/wb/data/882/882791-topic-1433001799-12p.jpg','เนื้อวัว','empty');
INSERT INTO "menu" VALUES (2,'เนื้อวัวออสเตรเลีย','https://passiondelivery.com/pub/media/catalog/product/cache/7e6e59e80a69ca81b40190dbfa9e211f/s/s/ssjwlwfnhl-1.png','เนื้อวัว','active');
INSERT INTO "menu" VALUES (3,'เสือร้องไห้','https://www.sirinfarm.com/wp-content/uploads/2021/07/Brisket-Sliced.jpeg','เนื้อวัว','active');
INSERT INTO "menu" VALUES (4,'หมูคุโรบุตะ(สันคอ)','https://img.wongnai.com/p/400x0/2020/01/13/ba7ee71506254aa2963ac681e03d9a78.jpg','เนื้อหมู','active');
INSERT INTO "menu" VALUES (5,'หมูคุโรบุตะ(สันนอก)','https://chillchilljapan.com/wp-content/uploads/2020/10/pixta_41591937_M.jpg','เนื้อหมู','active');
INSERT INTO "menu" VALUES (6,'หมูสามชั้น','https://www.mcfs.co.th/wp-content/uploads/2022/08/XL_01094.jpg','เนื้อหมู','active');
INSERT INTO "menu" VALUES (7,'หมูหมัก','https://s359.kapook.com/pagebuilder/dee327f0-7294-460f-adf1-255217137662.jpg','เนื้อหมู','active');
INSERT INTO "menu" VALUES (8,'หมูไม้ไผ่','https://img.wongnai.com/p/400x0/2022/05/25/4d0c312efe2b4b70a4840d5eae2d573f.jpg','เนื้อหมู','active');
INSERT INTO "menu" VALUES (9,'เนื้อไก่','https://www.ppf-group.com/wp-content/uploads/2019/09/shutterstock_327673388.jpg','เนื้อไก่','active');
INSERT INTO "menu" VALUES (10,'ไก่ไม้ไผ่','https://www.ajinomotofoodservicethailand.com/wp-content/uploads/2019/10/marinatedmeat-bouncychicken45-1170x468px.jpg','เนื้อไก่','active');
INSERT INTO "menu" VALUES (11,'ปลาดอลลี่','https://www.ppnseafoodwishing.com/wp-content/uploads/2021/11/Screen-Shot-2564-11-06-at-22.25.48.png','อาหารทะเล','active');
INSERT INTO "menu" VALUES (12,'ปลาแซลมอน','https://static.thairath.co.th/media/dFQROr7oWzulq5FZUEkCiVTPiEVTncN1z6DouZeoUPDVNW7Eo1wlSiR9fOvgRqXCjXl.jpg','อาหารทะเล','active');
INSERT INTO "menu" VALUES (13,'หมึก','https://static5-th.orstatic.com/userphoto/Article/0/4L/000WLG39A64B2CE963B578j.jpg','อาหารทะเล','active');
INSERT INTO "menu" VALUES (14,'กุ้ง','https://www.hatyaifocus.com/ckeditor/upload/forums/3/Na/%E0%B8%8A%E0%B8%B2%E0%B8%9A%E0%B8%B9%E0%B8%A1%E0%B8%B4%E0%B8%81%E0%B8%8B%E0%B9%8C/W%20Shabu%20mix-41.jpg','อาหารทะเล','active');
INSERT INTO "menu" VALUES (15,'ผักบุ้ง','https://img.wongnai.com/p/1920x0/2019/01/31/1a3ad9314c03446ca9ac0f14ef57eaa0.jpg','ผัก','active');
INSERT INTO "menu" VALUES (16,'ผักกาด','https://img.wongnai.com/p/1920x0/2018/12/10/6788a69bbf914e1b84f33a0471025dd6.jpg','ผัก','active');
INSERT INTO "menu" VALUES (17,'สาหร่าย','https://res.cloudinary.com/dk0z4ums3/image/upload/v1675223796/attached_image_th/%E0%B8%AA%E0%B8%B2%E0%B8%AB%E0%B8%A3%E0%B9%88%E0%B8%B2%E0%B8%A2%E0%B8%A7%E0%B8%B2%E0%B8%81%E0%B8%B2%E0%B9%80%E0%B8%A1%E0%B8%B0%E0%B8%81%E0%B8%B1%E0%B8%9A%E0%B8%84%E0%B8%B8%E0%B8%93%E0%B8%9B%E0%B8%A3-pobpad.jpg','ผัก','active');
INSERT INTO "menu" VALUES (18,'เห็ดเข็มทอง','https://img.wongnai.com/p/1920x0/2020/03/12/e70ae9e41e2849fbb0a8c0f71ace75d1.jpg','ผัก','active');
INSERT INTO "menu" VALUES (19,'ข้าวโพด','https://img.wongnai.com/p/800x0/2021/08/18/375adab3a7dd4015a61cc24415b9bd5a.jpg','ผัก','active');
INSERT INTO "menu" VALUES (20,'ไข่ไก่','https://img.wongnai.com/p/1920x0/2020/09/28/37bd52ba9a134cd3b588f863ccaa079d.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (21,'วุ้นเส้น','https://img.wongnai.com/p/1920x0/2018/12/10/0f4f80e2bc024b39920ae558e6c7ffa3.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (22,'ลูกชิ้น','https://www.ofm.co.th/blog/wp-content/uploads/2021/09/%E0%B9%80%E0%B8%9B%E0%B8%B4%E0%B8%94%E0%B8%A3%E0%B9%89%E0%B8%B2%E0%B8%99%E0%B8%82%E0%B8%B2%E0%B8%A2%E0%B8%A5%E0%B8%B9%E0%B8%81%E0%B8%8A%E0%B8%B4%E0%B9%89%E0%B8%99_3.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (23,'เต้าหู้ปลา','https://img.wongnai.com/p/1920x0/2021/02/04/fc21e0d932cf4f11b196aecc5c71bd35.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (24,'ไส้กรอก','https://www.jandoprocessing.com/wp-content/uploads/2020/01/smoked-pork-cocktail-01.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (25,'ปูอัด','https://static.cdntap.com/tap-assets-prod/wp-content/uploads/sites/25/2022/09/crab-sticks-menu-lead.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (26,'ชีส','https://goohiw.com/wp-content/uploads/2020/09/review-nang-nai-shabu-buffet52.jpg','อื่นๆ','active');
INSERT INTO "menu" VALUES (27,'เฟรนซ์ฟราย','https://www.cooking.in.th/wp-content/uploads/2023/03/%E0%B9%80%E0%B8%9F%E0%B8%A3%E0%B8%99%E0%B8%9F%E0%B8%A3%E0%B8%B2%E0%B8%A2-%E0%B9%80%E0%B8%A1%E0%B8%99%E0%B8%B9%E0%B8%AD%E0%B8%B2%E0%B8%AB%E0%B8%B2%E0%B8%A3%E0%B8%A7%E0%B9%88%E0%B8%B2%E0%B8%87.jpg','ของทางเล่น','active');
INSERT INTO "menu" VALUES (28,'ไก่ทอด','https://storage.thaipost.net/main/uploads/photos/big/20210507/image_big_6094b13a494ec.jpg','ของทานเล่น','active');
INSERT INTO "menu" VALUES (29,'ชีสบอล','https://image.bestreview.asia/wp-content/uploads/2021/05/Cheese-Balls.jpg','ของทานเล่น','active');
INSERT INTO "menu" VALUES (30,'เกี๊ยวซ่าทอด','https://www.ajinomotofoodservicethailand.com/wp-content/uploads/2017/12/shutterstock_608576015-1024x683.jpg','ของทานเล่น','active');
INSERT INTO "menu" VALUES (31,'ไอติมรสวนิลลา','https://static.cdntap.com/tap-assets-prod/wp-content/uploads/sites/25/2023/05/can-pregnant-eat-vanilla-3.jpg','ของหวาน','active');
INSERT INTO "menu" VALUES (32,'ไอติมรสชาเขียว','https://f.ptcdn.info/975/065/000/pxv53fijq0yJL5T4GKh-o.jpg','ของหวาน','active');
INSERT INTO "menu" VALUES (33,'ไอติมรสช็อค','https://f.ptcdn.info/936/080/000/rwljkb27qmr48Jp1T76tK-o.jpg','ของหวาน','active');
INSERT INTO "menu" VALUES (34,'ไอติมรสสตรอเบอรี่','https://s359.kapook.com/pagebuilder/240a9f79-4745-441f-b7c0-a11d27b659db.jpg','ของหวาน','active');
INSERT INTO "tables" VALUES (1,1,'empty');
INSERT INTO "tables" VALUES (2,2,'empty');
INSERT INTO "tables" VALUES (3,3,'empty');
INSERT INTO "tables" VALUES (4,4,'empty');
INSERT INTO "tables" VALUES (5,5,'empty');
INSERT INTO "tables" VALUES (6,6,'empty');
INSERT INTO "tables" VALUES (7,7,'empty');
INSERT INTO "tables" VALUES (8,8,'empty');
INSERT INTO "tables" VALUES (9,9,'empty');
INSERT INTO "tables" VALUES (10,10,'empty');
INSERT INTO "tables" VALUES (11,11,'empty');
INSERT INTO "tables" VALUES (12,12,'empty');
COMMIT;
