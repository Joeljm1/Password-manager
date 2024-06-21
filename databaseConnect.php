<?php
$servername = "localhost";
$username = "root";
$password = "root123";
$database="login";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === FALSE) 
{
    echo "Error creating database: " . $conn->error;
}
$conn->query("use login");
$sql = "SHOW TABLES LIKE 'login'";
$result = $conn->query($sql);

if ($result->num_rows == 0) 
{
    $createTableSQL = "CREATE table login(sno int PRIMARY KEY AUTO_INCREMENT,userid varchar(100) Not null,email varchar(100) not null, password varchar(200) not null);";

    if ($conn->query($createTableSQL) === TRUE)
    {
        echo "Table login created successfully";
    } 
    else
    {
        echo "Error creating table: " . $conn->error;
    }
}
?>