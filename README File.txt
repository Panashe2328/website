Online Clothing Store - Full PHP & MYSQL Project
Version: 1.0.0

Admin Credentials:

Username: laras@gmail.com
Password: 1234
Introduction
Welcome to Pastimes, an Online Clothing Store Web Application! Pastimes enables users to buy and sell preloved clothing items easily. This guide will walk you through setting up and running the application using XAMPP. Before starting, ensure you have XAMPP installed on your machine.

Key Features
This application is designed with a user-friendly interface and essential features for both users and admins:
Home Page Navigation: Users can navigate between Home, About, and Register pages.
Product Listings: Users can view items with detailed descriptions and prices.
Shopping Cart: Users can add items to their cart by clicking "Add to Cart," triggering a pop-up with item pricing, with items stored in the cart using the array_push() function.
User Registration and Login: New users can register and log in securely.
Admin Approval: Admins have control over user accounts and can approve or reject new registrations.
User Status: Registered users remain on a "waiting list" until approved by an admin, adding an additional layer of control.
Installation Guide


Follow these steps to set up and run the application locally:

Step 1: Download and Extract Files
Download the ZIP file for the project.
Extract the contents to a preferred location on your system.
Step 2: Database Setup
Start XAMPP: Open XAMPP and ensure the Apache and MySQL modules are running.
Create Database:
Open phpMyAdmin by navigating to http://localhost/phpmyadmin.
Create a new database called clothingstore.
Import Database Schema:
Open the provided myClothingStore.sql file.
Copy the SQL queries from the file and execute them in the clothingstore database to set up the required tables and data.
Step 3: Configure Database Connection
Locate the DBConn.php file in the project root directory.
Update the connection details if needed:
php
Copy code
$hostname = "localhost";
$username = "root";
$password = ""; 
$database = "clothingstore";

Step 4: Move Files to the htdocs Directory
Navigate to the XAMPP installation directory (usually C:\xampp\htdocs on Windows).
Move the project folder to the htdocs directory.
Step 5: Access the Application
Open a web browser and enter the following URL:
vbnet
Copy code
http://localhost/your-path-to-the-app/index.php
Replace your-path-to-the-app with the actual path to the index.php file within the htdocs directory.

Step 6: Explore the Application
You should now see the Online Clothing Store Web Application up and running.
Try out various features such as signing up, logging in, adding items to the cart, and viewing products.

Troubleshooting
Database Connection Issues
If you encounter issues with the database connection, double-check the credentials in DBConn.php.
Ensure the MySQL service is running in XAMPP.

Path Issues
Verify that the URL path in your browser matches the project’s location within the htdocs directory.