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
    D_day_of_birth DATETIME,
    B_type BOOLEAN
);

CREATE TABLE sellers (
    I_id_seller INT PRIMARY KEY AUTO_INCREMENT,
    I_id_user INT,
    T_name_shop VARCHAR(30),
    T_description VARCHAR(30),
    T_address_shop VARCHAR(100),
    T_numberphone_shop VARCHAR(30),
    FOREIGN KEY (I_id_user) REFERENCES users(I_id_user)
);

CREATE TABLE cart (
    I_id_cart INT PRIMARY KEY AUTO_INCREMENT,
    I_id_user INT,
    I_qty INT,
    FOREIGN KEY (I_id_user) REFERENCES users(I_id_user)
);

CREATE TABLE product (
    I_id_pro INT PRIMARY KEY AUTO_INCREMENT,
    T_name_pro VARCHAR(50),
    I_qty_in_stock INT,
    I_price INT,
    T_img_sample_pro VARCHAR(250),
    T_description VARCHAR(100),
    I_id_seller INT,
    FOREIGN KEY (I_id_seller) REFERENCES sellers(I_id_seller)
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
    I_id_pro INT,
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro)
);

CREATE TABLE category (
    I_id_category INT PRIMARY KEY AUTO_INCREMENT,
    T_name_category VARCHAR(50),
    T_description VARCHAR(500),
    T_img_sample_category VARCHAR(45),
    I_id_parent INT
);

CREATE TABLE pro_cate (
    I_id INT PRIMARY KEY AUTO_INCREMENT,
    I_id_category INT,
    I_id_pro INT,
    FOREIGN KEY (I_id_category) REFERENCES category(I_id_category),
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro)
);

CREATE TABLE orders (
    I_id_orders INT PRIMARY KEY AUTO_INCREMENT,
    I_idUser INT,
    I_total_price INT,
    T_status VARCHAR(50),
    T_shipping_address VARCHAR(100),
    T_payment_method VARCHAR(50),
    T_note VARCHAR(100)
);

CREATE TABLE order_detail (
    I_id INT PRIMARY KEY AUTO_INCREMENT,
    I_id_orders INT,
    I_id_pro INT,
    I_qty INT,
	I_price INT,
    FOREIGN KEY (I_id_orders) REFERENCES orders(I_id_orders),
    FOREIGN KEY (I_id_pro) REFERENCES product(I_id_pro)
);