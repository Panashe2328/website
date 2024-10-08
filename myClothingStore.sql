create schema ClothingStore;

--
CREATE TABLE tblUser (
    user_id INT PRIMARY KEY, 
    first_name VARCHAR(50) NOT NULL, 
    last_name VARCHAR(50) NOT NULL,  
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    address VARCHAR(255) NOT NULL, 
    city VARCHAR(100) NOT NULL, 
    code VARCHAR(10), 
    status ENUM('active', 'pending') NOT NULL 
);

CREATE TABLE tblAdmin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT, -- Primary Key, auto-incrementing
    admin_num VARCHAR(10) NOT NULL UNIQUE, -- Unique admin number
    first_name VARCHAR(50) NOT NULL, -- Admin's first name
    last_name VARCHAR(50) NOT NULL,  -- Admin's last name
    admin_email VARCHAR(100) NOT NULL UNIQUE, -- Admin's email address
    password VARCHAR(255) NOT NULL -- Hashed password for security
);

CREATE TABLE tblOrder (
    order_id INT PRIMARY KEY AUTO_INCREMENT, -- Primary Key, auto-incrementing
    user_id INT NOT NULL, -- Foreign key referencing tblUser
    clothes_id INT NOT NULL, -- Foreign key referencing tblClothes
    clothes_purchased VARCHAR(255) NOT NULL, -- Purchased clothing items (optional string description)
    order_date DATE NOT NULL, -- Date of the order
    status ENUM('pending', 'shipped', 'delivered') NOT NULL, -- Order status
    total_price DECIMAL(10,2) NOT NULL, -- Total price of the order
    FOREIGN KEY (user_id) REFERENCES tblUser(user_id),
    FOREIGN KEY (clothes_id) REFERENCES tblClothes(clothes_id)
);

CREATE TABLE tblClothes (
    clothes_id INT PRIMARY KEY AUTO_INCREMENT, -- Primary Key, auto-incrementing
    clothes_category ENUM('woman', 'men', 'kids') NOT NULL, -- Category of the clothing
    clothes_description VARCHAR(255) NOT NULL, -- Description of the clothing item
    price DECIMAL(10,2) NOT NULL, -- Price of the clothing item
    size VARCHAR(10) NOT NULL, -- Size of the clothing item (e.g., S, M, L)
    condition ENUM('new', 'used') NOT NULL -- Condition of the clothing (new or used)
);


