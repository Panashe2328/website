
CREATE DATABASE IF NOT EXISTS ClothingStore;
USE ClothingStore;


CREATE TABLE IF NOT EXISTS tblUser (
    user_id INT PRIMARY KEY, 
    first_name VARCHAR(50) NOT NULL, 
    last_name VARCHAR(50) NOT NULL,  
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    address VARCHAR(255) NOT NULL, 
    city VARCHAR(100) NOT NULL, 
    code VARCHAR(10), 
    status ENUM('active', 'pending') NOT NULL, 
    role ENUM('user', 'admin') NOT NULL  
);



CREATE TABLE IF NOT EXISTS tblAdmin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT, 
    admin_num VARCHAR(10) NOT NULL UNIQUE, 
    first_name VARCHAR(50) NOT NULL, 
    last_name VARCHAR(50) NOT NULL, 
    admin_email VARCHAR(100) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL 
);


CREATE TABLE IF NOT EXISTS tblClothes (
    clothes_id INT PRIMARY KEY AUTO_INCREMENT,
    image_url VARCHAR(255) NOT NULL,
    clothes_category ENUM('woman', 'men', 'kids') NOT NULL,
    clothes_description VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    size VARCHAR(10) NOT NULL,
    condition ENUM('new', 'used') NOT NULL
);


CREATE TABLE IF NOT EXISTS tblOrder (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    clothes_id INT NOT NULL,
    clothes_purchased VARCHAR(255) NOT NULL,
    order_date DATE NOT NULL,
    status ENUM('pending', 'shipped', 'delivered') NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES tblUser(user_id),
    FOREIGN KEY (clothes_id) REFERENCES tblClothes(clothes_id)
);

INSERT INTO tblUser (user_id, first_name, last_name, username, password, address, city, code, status, role) VALUES
(101, 'Carol', 'Heinz', 'carol003', '$2a$04$rDzeLQd3dhzMDucN4zjeZepK1P2Zbj.RCKopn1suo5K2noZ.xDlFS', '111 Nellie Rd', 'Cape Town', '7100', 'active', 'user'),
(102, 'Stella', 'Cotton', 'stella209', '$2a$04$YZ1WnA5tuQnqUtQMBE0TW.OOOmsD5/hcSy1dpkMV4YIpFxsdlj3oe', '177 Oxford Service Rd', 'Johannesburg', '2006', 'active', 'user'),
(103, 'Alice', 'Kidd', 'kiddAlice', '$2a$04$5W78uQPtNWLurrNGDGoZheZiZrrMONXwPrBqVP.treBeUybCqK9F6', '30 Rudd Rd', 'Pretoria', '0007', 'active', 'user'),
(104, 'Suzanne', 'Hardwick', 'suzanneh', '$2a$04$8A9.89mtQI327NQZVwAb5OQbRyZW1eCMxF179QrBI0KUKiMBgvisC', '28 Baker Square', 'Roodepoort', '2169', 'pending', 'user'),
(105, 'Juliet', 'Hillier', 'julhi', '$2a$04$8tbf2OBR8K9vQk8tfb44weucvjtaC4kJSvLYolYbLjdANYaxkbUDC', '202 Birch Rd', 'Sandton', '2014', 'pending', 'user'),
(106, 'Marc', 'Andrews', 'andrewsmmm', '$2a$04$abcde1234567890ZYXWVutsrqponmlkjihgfedcba', '50 Pine St', 'Cape Town', '7100', 'active', 'user'),
(107, 'Judith', 'Howe', 'jhowe31', '$2a$04$fghijk1234567890ZYXWVutsrqponmlkjihgfedcba', '75 West Rd', 'Durban', '4001', 'active', 'user'),
(108, 'Lisa', 'Kennede', 'kennede400', '$2a$04$lmnopq1234567890ZYXWVutsrqponmlkjihgfedcba', '21 Elm St', 'Port Elizabeth', '6001', 'pending', 'user'),
(109, 'Arron', 'Jones', 'arron123', '$2a$04$rszuvw1234567890ZYXWVutsrqponmlkjihgfedcba', '12 Maple Ave', 'Pretoria', '0007', 'active', 'user'),
(110, 'Kathleen', 'Warburton', 'katwar', '$2a$04$ijklmn1234567890ZYXWVutsrqponmlkjihgfedcba', '90 Lakeview Rd', 'Johannesburg', '2001', 'pending', 'user'),
(111, 'Richard', 'Conway', 'richardC', '$2a$04$qrstuv1234567890ZYXWVutsrqponmlkjihgfedcba', '45 Grove St', 'Bloemfontein', '9301', 'active', 'user'),
(112, 'Alma', 'Lawson', 'almaLaw', '$2a$04$ghijkl1234567890ZYXWVutsrqponmlkjihgfedcba', '36 Cherry Rd', 'East London', '5200', 'pending', 'user'),
(113, 'Edward', 'Burke', 'edburke', '$2a$04$uvwxyz1234567890ZYXWVutsrqponmlkjihgfedcba', '88 Long St', 'Durban', '4001', 'active', 'user'),
(114, 'Colette', 'Neale', 'nealeCo', '$2a$04$mnopqr1234567890ZYXWVutsrqponmlkjihgfedcba', '52 King St', 'Cape Town', '7100', 'pending', 'user'),
(115, 'William', 'Browning', 'wbrown', '$2a$04$abcdef1234567890ZYXWVutsrqponmlkjihgfedcba', '13 Queen Rd', 'Pretoria', '0007', 'active', 'user'),
(116, 'Lea', 'Miller', 'leamill', '$2a$04$mnopqr1234567890ZYXWVutsrqponmlkjihgfedcba', '77 Palm St', 'Johannesburg', '2006', 'pending', 'user'),
(117, 'Oliver', 'Fraser', 'fraserOliver', '$2a$04$abcdef1234567890ZYXWVutsrqponmlkjihgfedcba', '62 Orange Rd', 'Sandton', '2014', 'active', 'user'),
(118, 'Leslie', 'Johnston', 'lesliejohn', '$2a$04$qrstuv1234567890ZYXWVutsrqponmlkjihgfedcba', '91 Park Rd', 'Durban', '4001', 'pending', 'user'),
(119, 'Caron', 'Talbot', 'carontal', '$2a$04$uvwxyz1234567890ZYXWVutsrqponmlkjihgfedcba', '18 Hill St', 'Roodepoort', '2169', 'active', 'user'),
(120, 'Jennifer', 'Affleck', 'jaffleck', '$2a$04$hijklmn1234567890ZYXWVutsrqponmlkjihgfedcba', '74 Beach Ave', 'Cape Town', '7100', 'pending', 'user'),
(121, 'Tina', 'Cowley', 'cowleytina', '$2a$04$ghijkl1234567890ZYXWVutsrqponmlkjihgfedcba', '25 Forest Rd', 'Pretoria', '0007', 'active', 'user'),
(122, 'Annette', 'Avery', 'annavery', '$2a$04$mnopqr1234567890ZYXWVutsrqponmlkjihgfedcba', '38 North St', 'Johannesburg', '2006', 'pending', 'user'),
(123, 'John', '', 'johnsmith', '$2a$04$abcdef1234567890ZYXWVutsrqponmlkjihgfedcba', '11 South St', 'Port Elizabeth', '6001', 'active', 'user'),
(124, 'Lara', '', 'larajones', '$2a$04$rstuvw1234567890ZYXWVutsrqponmlkjihgfedcba', '9 Main St', 'Sandton', '2014', 'pending', 'user'),
(125, 'Will', '', 'willturner', '$2a$04$uvwxyz1234567890ZYXWVutsrqponmlkjihgfedcba', '22 School St', 'Durban', '4001', 'active', 'user'),
(126, 'Julie', 'Adams', 'juliea', '$2a$04$ijklmn1234567890ZYXWVutsrqponmlkjihgfedcba', '81 Market St', 'Cape Town', '7100', 'pending', 'user'),
(127, 'Rose', 'Williams', 'roseW', '$2a$04$ghijkl1234567890ZYXWVutsrqponmlkjihgfedcba', '55 High St', 'Pretoria', '0007', 'active', 'user'),
(128, 'Nelly', 'Korda', 'nellyK', '$2a$04$lmnopq1234567890ZYXWVutsrqponmlkjihgfedcba', '73 Park Lane', 'Johannesburg', '2006', 'pending', 'user'),
(129, 'Lexi', 'Thompson', 'lexithom', '$2a$04$abcdef1234567890ZYXWVutsrqponmlkjihgfedcba', '47 Golf St', 'Roodepoort', '2169', 'active', 'user'),
(130, 'Sam', '', 'samsmith', '$2a$04$qrstuv1234567890ZYXWVutsrqponmlkjihgfedcba', '60 Ocean Rd', 'Sandton', '2014', 'pending', 'user');



INSERT INTO tblAdmin (admin_id, admin_num, first_name, last_name, admin_email, password) VALUES
('A1001', 'Alice', 'Brown', 'alice@admin.com', 'hashedpassword1'),
('A1002', 'Bob', 'Davis', 'bob@admin.com', 'hashedpassword2');


INSERT INTO tblClothes (clothes_id, image_url, clothes_category, clothes_description, price, size, condition) VALUES
('men', 'Men\'s T-Shirt', 19.99, 'M', 'new'),
('women', 'Women\'s Dress', 49.99, 'S', 'new'),
('kids', 'Kids\' Shorts', 12.99, 'XS', 'used'),
-- Add 27 more entries similarly...
('men', 'Men\'s Jacket', 89.99, 'L', 'new');


INSERT INTO tblOrder (user_id, clothes_id, clothes_purchased, order_date, status, total_price) VALUES
(1, 1, 'Men\'s T-Shirt', '2024-10-10', 'pending', 19.99),
(2, 2, 'Women\'s Dress', '2024-10-09', 'shipped', 49.99);
