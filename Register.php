<?php 

include 'connect.php';

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
 
    $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
    $result = $conn->query($sql);
 
    if($result->num_rows > 0){
       session_start();
       $row = $result->fetch_assoc();
       $_SESSION['email'] = $row['email'];
       $_SESSION['role'] = $row['role']; // Store the role in session
 
       // Check role and redirect accordingly
       if($row['role'] == 'admin'){
           // Redirect to phpMyAdmin or admin dashboard
           header("Location: /path-to-admin-dashboard.php");
       } else {
           // Redirect to the shopping/homepage for regular users
           header("Location: homepage.php");
       }
       exit();
    } else {
       echo "Not Found, Incorrect Email or Password";
    }
 }
 

if(isset($_POST['signIn'])){
   $email=$_POST['email'];
   $password=$_POST['password'];
   $password=md5($password) ;
   
   $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
   $result=$conn->query($sql);
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: homepage.php");
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
   }

}
?>