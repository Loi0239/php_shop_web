create database webck;
USE webck;

create table users(
	I_id_user INT PRIMARY KEY AUTO_INCREMENT,
    T_user_name VARCHAR(50),
    T_password VARCHAR(50),
    T_name VARCHAR(30),
    T_number_phone VARCHAR(30),
    T_email VARCHAR(30),
    T_address VARCHAR(100),
    D_day_of_birth DATE,
    I_reviewed INT,
    I_likes INT,
    B_type BOOLEAN
);

CREATE TABLE cart (
    I_id_cart INT PRIMARY KEY AUTO_INCREMENT,
    I_id_user INT,
    I_qty INT,
    FOREIGN KEY (I_id_user) REFERENCES users(I_id_user)
);

CREATE TABLE category (
    I_id_category INT PRIMARY KEY AUTO_INCREMENT,
    T_name_category VARCHAR(50),
    T_description VARCHAR(500),
    T_img_sample_category VARCHAR(45),
    I_id_parent INT
);
use webck;
insert into category(I_id_category, T_name_category)
values
(1,'Điện thoại'),
(2,'Máy tính'),
(3,'Đồng hồ'),
(4,'Tivi');
-- use webck;
insert into category(T_name_category, I_id_parent)
values
('Apple', 1),('Samsung', 1),('Oppo', 1),('Xiaomi', 1),('Huawei', 1),
('Lenovo', 2),('Asus', 2),('Acer', 2),('HP', 2),
('Rolex', 3),('Casio', 3),
('LG', 4),('Sony', 4),('Panasonic', 4),('Toshiba', 4),('Samsung', 4);


CREATE TABLE product (
    I_id_pro INT PRIMARY KEY AUTO_INCREMENT,
    T_name_pro VARCHAR(50),
    T_img_sample_pro VARCHAR(250),
    T_feature VARCHAR(400),
    T_description VARCHAR(100),
    I_sold int,
    I_id_category int,
    FOREIGN KEY (I_id_category) REFERENCES category(I_id_category)
);
-- use webck;
insert into product(T_name_pro, I_id_category, T_img_sample_pro)
values
-- Điện thoại
('Iphone X',5, 'DT_ipX_detail1.png | DT_ipX_detail2.png | DT_ipX_detail3.png'), 
('Iphone 11',5, 'DT_ip11_detail1.png | DT_ip11_detail2.png'), 
('Iphone 12',5, 'DT_ip12_detail1.png | DT_ip12_detail2.png'), 
('Iphone 13', 5, 'DT_ip13_detail1.png | DT_ip13_detail2.png'), 
('Iphone 14',5, 'DT_ip14_detail1.png | DT_ip14_detail2.png'), 
('Iphone 15',5, 'DT_ip15_detail1.png | DT_ip15_detail2.png'),

('Samsung Galaxy S10', 6, 'DT_ssS10_detail1.png | DT_ssS10_detail2.png'),
('Samsung Galaxy S20', 6, 'DT_ssS20_detail1.png | DT_ssS20_detail2.png'),
('Samsung Galaxy S21', 6, 'DT_ssS21_detail1.png | DT_ssS21_detail2.png'),
('Samsung Galaxy S22', 6, 'DT_ssS22_detail1.png | DT_ssS22_detail2.png'),

('Oppo Reno 2', 7, 'DT_opReno2_detail1.png | DT_opReno2_detail2.png'),
('Oppo Reno 3', 7, 'DT_opReno3_detail1.png | DT_opReno3_detail2.png'),
('Oppo Find X2', 7, 'DT_oFindX2_detail1.png'),

('Xiaomi Redmi Note 8', 8, 'DT_xiaoNote8_detail1.png | DT_xiaoNote8_detail2.png'),
('Xiaomi Redmi Note 9', 8, 'DT_xiaoNote9_detail1.png | DT_xiaoNote9_detail2.png'),

('Huawei P30', 9, 'DT_huaP30_detail1.png | DT_huaP30_detail2.png'),
('Huawei P40', 9, 'DT_huaP40_detail1.png | DT_huaP40_detail2.png'),
('Huawei Mate 20', 9, 'DT_huaMate20_detail1.png | DT_huaMate20_detail2.png'),
-- Máy tính 
('Lenovo ThinkPad X1 Carbon', 10, 'MT_lenoThinkX1_detail1.png | MT_lenoThinkX1_detail2.png'),
('Lenovo ThinkPad T14s', 10, 'MT_lenoThinkT14s_detail1.png | MT_lenoThinkT14s_detail2.png'),
('Lenovo Yoga C940', 10, 'MT_lenoYoga_detail1.png | MT_lenoYoga_detail2.png'),

('Asus ROG Zephyrus G14', 11, 'MT_asusROG_detail1.png | MT_asusROG_detail2.png'),
('Asus ZenBook 14', 11, 'MT_asusZen_detail1.png | MT_asusZen_detail2.png'),

('Acer Predator Helios 300', 12, 'MT_acerHelios_detail1.png | MT_acerHelios_detail2.png'),
('Acer Aspire 5', 12, 'MT_acerAspire_detail1.png | MT_acerAspire_detail2.png'),

('HP Spectre x360', 13, 'MT_hpSpectre_detail1.png | MT_hpSpectre_detail2.png'),
('HP Envy x360', 13, 'MT_hpEnvy_detail1.png'),
('HP Pavilion 14', 13, 'MT_hpPavy_detail1.png'),
-- Đồng hồ
('Rolex Submariner', 14, 'DH_rolexSub_detail1.png | DH_rolexSub_detail2.png'),
('Rolex Datejust', 14, 'DH_rolexDate_detail1.png | DH_rolexDate_detail2.png'),
('Rolex Day-Date', 14, 'DH_rolexDay_detail1.png | DH_rolexDay_detail2.png'),
('Rolex GMT-Master II', 14, 'DH_rolexGMT_detail1.png | DH_rolexGMT_detail2.png'),

('Casio G-Shock', 15, 'DH_casioG_detail1.png'),
('Casio Edifice', 15, 'DH_casioEd_detail1.png'),
-- Tivi
('LG OLED C1', 16, 'TV_lgC1_detail1.png | TV_lgC1_detail2.png'),
('LG NanoCell 85', 16, 'TV_lgCell85_detail1.png | TV_lgCell85_detail2.png'),
('Sony Bravia A80J', 17, 'TV_sonyBra_detail1.png | TV_sonyBra_detail2.png'),
('Panasonic OLED JZ2000', 18, 'TV_panaJZ_detail1.png | TV_panaJZ_detail2.png'),
('Samsung QLED Q80A', 19, 'TV_ssQ80_detail1.png | TV_ssQ80_detail2.png'),
('Samsung Crystal UHD TU8000', 19, 'TV_ssUHD_detail1.png | TV_ssUHD_detail2.png');
CREATE TABLE product_details (
    I_id_de_pro INT AUTO_INCREMENT PRIMARY KEY,
    I_id_pro INT,
    T_name VARCHAR(255),
    T_value VARCHAR(255),
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro)
);

CREATE TABLE product_type (
    I_id_type_pro INT AUTO_INCREMENT PRIMARY KEY,
    I_id_pro INT,
    T_name VARCHAR(255),
    T_image_sample_type_pro VARCHAR(255),
    I_qty_in_stock INT,
    I_price INT,
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro)
); 

CREATE TABLE cart_pro (
    I_id INT PRIMARY KEY AUTO_INCREMENT,
    I_id_cart INT,
    I_id_pro INT,
    I_qty INT,
    FOREIGN KEY (I_id_cart) REFERENCES cart(I_id_cart),
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro)
);

CREATE TABLE review (
    I_id INT PRIMARY KEY AUTO_INCREMENT,
    I_star INT,
    T_comment VARCHAR(250),
    T_img_sample_review VARCHAR(250),
    I_id_pro INT,
    I_id_user INT,
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro),
	FOREIGN KEY (I_id_user) REFERENCES users(I_id_user)
);

CREATE TABLE orders (
    I_id_orders INT PRIMARY KEY AUTO_INCREMENT,
    I_idUser INT,
    T_code_orders text,
    T_name_user VARCHAR(100),
    T_number_phone VARCHAR(100),
    T_address VARCHAR(100),
    T_email VARCHAR(100),
    T_order_date datetime,
    I_status INT,
    FOREIGN KEY (I_idUser) REFERENCES users(I_id_user)
);

CREATE TABLE order_detail (
    I_id INT PRIMARY KEY AUTO_INCREMENT,
    I_id_orders INT,
    I_id_type_pro INT,
    I_qty INT,
	I_price INT,
    FOREIGN KEY (I_id_orders) REFERENCES orders(I_id_orders),
    FOREIGN KEY (I_id_type_pro) REFERENCES product_type(I_id_type_pro)
);