
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
    `condition` ENUM('new', 'used') NOT NULL
);


CREATE TABLE IF NOT EXISTS tblOrder (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    clothes_id INT NOT NULL,
    clothes_purchased VARCHAR(255) NOT NULL,
    order_date DATE NOT NULL,
    status ENUM('pending', 'shipped', 'delivered') NOT NULL,
    quantity INT NOT NULL,
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



INSERT INTO tblAdmin (admin_id, admin_num, first_name, last_name, admin_email, password) 
VALUES
(1, '11011', 'Diana', 'Simpson', 'dianasimpson@yahoo.com', '5d41402abc4b2a76b9719d911017c592'),
(2, '11012', 'Sam', 'Palmer', 'sampalmer@gmail.com', '098f6bcd4621d373cade4e832627b4f6'),
(3, '11013', 'Paula', 'Peters', 'paulapeters@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b'),
(4, '11014', 'Jane', 'Smit', 'janesmit@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(5, '11015', 'Kara', 'Johnson', 'karajohnson@gmail.com', 'e99a18c428cb38d5f260853678922e03');



INSERT INTO tblClothes (clothes_id, image_url, clothes_category, clothes_description, price, size, `condition`) VALUES
(11011, '_images/black_shirt.jpg', 'Women', 'Black t-shirt', 125.00, 'M', 'good'),
(11012, '_images/men_pants_brown.jpg', 'Men', 'Brown formal pants', 250.00, 'S', 'new'),
(11013, '_images/kids_dress1.jpg', 'Kids', 'Colourful dress', 115.00, 'S', 'good'),
(11014, '_images/woman_dress_blue.jpg', 'Women', 'dress', 115.00, 'S', 'good'),
(11015, '_images/men_coca.jpg', 'Men', 'A white Coca-Cola t-shirt', 90.00, 'M', 'good'),
(11016, '_images/women_dress_pink.jpg', 'Women', 'Pink summer dress', 150.00, 'S', 'new'),
(11017, '_images/kids_shirt_grey.jpg', 'Kids', 'Grey t-shirt with animals', 80.00, 'XS', 'new'),
(11018, '_images/women_skirt.jpg', 'Women', 'Red skirt', 120.00, 'S', 'good'),
(11019, '_images/men_shirt_blue.jpg', 'Men', 'Blue buttoned shirt', 150.00, 'M', 'new'),
(11020, '_images/kids_skirt_lines.jpg', 'Kids', 'Black and white skirt', 90.00, 'S', 'good'),
(11021, '_images/women_dress_dots.jpg', 'Women', 'Blue dotted dress', 250.00, 'S', 'new'),
(11022, '_images/men_jeans.jpg', 'Men', 'Blue jeans', 180.00, 'M', 'good'),
(11023, '_images/kids_shirt_hearts.jpg', 'Kids', 'Shirt with hearts', 95.00, 'S', 'new'),
(11024, '_images/women_shirt_orange.jpg', 'Women', 'Orange shirt', 300.00, 'S', 'good'),
(11025, '_images/kids_dress_2.jpg', 'Kids', 'White dress', 350.00, 'XS', 'good'),
(11026, '_images/men_jacket.jpg', 'Men', 'Green jacket', 400.00, 'L', 'new'),
(11027, '_images/women_skirt_pink.jpg', 'Women', 'Long skirt', 140.00, 'M', 'good'),
(11028, '_images/kids_shirt_red.jpg', 'Kids', 'Long sleeve red shirt', 115.00, 'S', 'new'),
(11029, '_images/kids_pants_green.jpg', 'Kids', 'Green pants', 125.00, 'S', 'new'),
(11030, '_images/men_shirt_white.jpg', 'Men', 'White shirt', 150.00, 'L', 'good'),
(11031, '_images/kids_sirt_orange.jpg', 'Kids', 'Orange skirt', 90.00, 'M', 'new'),
(11032, '_images/kids_shirt_white.jpg', 'Kids', 'dress', 115.00, 'S', 'good'),
(11033, '_images/women_jacket_brown.jpg', 'Kids', 'Grey shirt', 200.00, 'S', 'new'),
(11034, '_images/women_shirt_white.jpg', 'Women', 'Light brown jacket', 250.00, 'M', 'new'),
(11035, '_images/women_shirt_lines.jpg', 'Women', 'White shirt', 170.00, 'L', 'good'),
(11036, '_images/women_shirt_black.jpg', 'Women', 'Shirt with lines', 85.00, 'S', 'good'),
(11037, '_images/men_jacket_purple.jpg', 'Men', 'Purple jacket', 450.00, 'M', 'new'),
(11038, '_images/women_shirt_grey.jpg', 'Women', 'dress', 60.00, 'S', 'good'),
(11040, '_images/kids_shirt_blue.jpg', 'Kids', 'Blue shirt', 95.00, 'S', 'new'),
(11041, '_images/women_shirt_white.jpg', 'Women', 'White shirt', 250.00, 'L', 'new');



INSERT INTO tblOrder (order_id, user_id, clothes_id, clothes_purchased, order_date, quantity, total_price, status) VALUES
(1, 101, 11011, 'Black t-shirt', '2024-10-01', 2, 250.00, 'delivered'),
(2, 102, 11012, 'Brown formal pants', '2024-10-02', 1, 250.00, 'shipped'),
(3, 103, 11013, 'Colourful dress', '2024-10-03', 3, 345.00, 'delivered'),
(4, 104, 11014, 'dress', '2024-10-04', 1, 115.00, 'pending'),
(5, 105, 11015, 'A white Coca-Cola t-shirt', '2024-10-05', 2, 180.00, 'pending'),
(6, 106, 11016, 'Pink summer dress', '2024-10-06', 1, 150.00, 'delivered'),
(7, 107, 11017, 'Grey t-shirt with animals', '2024-10-07', 5, 400.00, 'shipped'),
(8, 108, 11018, 'Red skirt', '2024-10-08', 2, 240.00, 'pending'),
(9, 109, 11019, 'Blue buttoned shirt', '2024-10-09', 3, 450.00, 'delivered'),
(10, 110, 11020, 'Black and white skirt', '2024-10-10', 1, 90.00, 'pending'),
(11, 111, 11021, 'Blue dotted dress', '2024-10-11', 2, 500.00, 'delivered'),
(12, 112, 11022, 'Blue jeans', '2024-10-12', 1, 180.00, 'shipped'),
(13, 113, 11023, 'Shirt with hearts', '2024-10-13', 2, 190.00, 'pending'),
(14, 114, 11024, 'Orange shirt', '2024-10-14', 3, 900.00, 'delivered'),
(15, 115, 11025, 'White dress', '2024-10-15', 1, 350.00, 'pending'),
(16, 116, 11026, 'Green jacket', '2024-10-16', 1, 400.00, 'delivered'),
(17, 117, 11027, 'Long skirt', '2024-10-17', 2, 280.00, 'shipped'),
(18, 118, 11028, 'Long sleeve red shirt', '2024-10-18', 2, 230.00, 'pending'),
(19, 119, 11029, 'Green pants', '2024-10-19', 3, 375.00, 'delivered'),
(20, 120, 11030, 'White shirt', '2024-10-20', 2, 300.00, 'pending'),
(21, 121, 11031, 'Orange skirt', '2024-10-21', 1, 90.00, 'delivered'),
(22, 122, 11032, 'dress', '2024-10-22', 2, 230.00, 'shipped'),
(23, 123, 11033, 'Grey shirt', '2024-10-23', 1, 200.00, 'pending'),
(24, 124, 11034, 'Light brown jacket', '2024-10-24', 3, 510.00, 'delivered'),
(25, 125, 11035, 'White shirt', '2024-10-25', 2, 340.00, 'pending'),
(26, 126, 11036, 'Shirt with lines', '2024-10-26', 1, 85.00, 'delivered'),
(27, 127, 11037, 'Purple jacket', '2024-10-27', 1, 450.00, 'shipped'),
(28, 128, 11038, 'dress', '2024-10-28', 2, 120.00, 'pending'),
(29, 129, 11040, 'Blue shirt', '2024-10-29', 1, 95.00, 'delivered'),
(30, 130, 11041, 'White shirt', '2024-10-30', 1, 250.00, 'pending');


