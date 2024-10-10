README File:

# Online Clothing Store - Full PHP & MYSQL Project 
version: 1.0.0 

### Admin User Name : laras@gmail.com

### Admin Password : 1234

## Introduction 
Welcome to the Online Clothing Store Web Application! The Online Clothing Store is called Pastimes that allows users to buy or sell clothing items. This guide will walk you through the steps to run the application using XAMPP. Ensure that you have XAMPP installed on your machine before proceeding. 


##Functionality

Our main focus was to create an aesthetically pleasing Website with the following functionalities:
- on the home page, users can navigate between Home, About, and Register
- The Home page has a working link "Shop" to allow users to view items with descriptions.
- Users can now press the "Add to Cart" button which will show a pop up message of the item's price. Furthermore, the item will be added to the cart using array_push() function.
- Users can sign up and sign in
- Admins can approve or reject users
- Users will see that they are on a waiting list until approved

## Installation Steps

download the ZIP file and extract it to your desired location 

1) Database Setup:* 
- Open your WampServer and make sure the Apache and MySQL services are running. 
- Access phpMyAdmin through `http://localhost/phpmyadmin`. 
- Create a new database named `clothingstore`.    
	- Import the database schema from the provided SQL file:      
	- Open `myClothingStore.sql`.      
	- Copy the SQL queries and execute them in the `clothingstore` database. 

2) *Configure Database Connection:*    
- Navigate to `DBConn.php` in the root directory.    
- Update the database connection details if needed:     
php      
$hostname = "localhost"; 
$username = "root";
$password = "";
$database = "ClothingStore";
        
Note: Update the `$password` field if you have set a password for your MySQL server. 

3) *Move Files to htdocs Directory:*    
- Locate your XAMPP installation directory (usually `C:\xampp\htdocs` on Windows).   
- Move the entire cloned repository or extracted files to the `htdocs` directory.

4) *Access the Application:*    
- Open your web browser and navigate to `http://localhost/your-path-to-theapp/index.php`.    
- Replace `your-path-to-the-app` with the path to the `index.php` file within the `htdocs` directory. "website"

5) *Discover and Enjoy:*    
- You should now see the Online Clothing Store Web Application!    
- Discover different features such as signing up and logging in, adding items to your cart, and managing the shopping cart.



## Troubleshooting 

*Database Connection Issues:* 
- If you encounter database connection issues, double-check the credentials in `DBConn.php`. 
- Ensure that the MySQL service is running in WampServer. 
- Ensure that the Start Actions are started in the XAMPP COntrol Panel for Module Apache and MySQL. 


*Path Issues:* 
- If the application is not accessible, ensure the correct path is used in the browser (`http://localhost/your-path-to-the-app/index.php`). 

You've successfully set up and run the Online Clothing Store Web Application using XAMPP. If you have any issues, refer to the troubleshooting section 
