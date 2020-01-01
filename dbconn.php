<?php
//$conn = mysqli_connect("localhost", "root", "inet2005", "sakila");
//if(!$conn)
//{
//    die("Unable to connect to database: " . mysqli_connect_error());
//}
function getConnection() {
// Create a connection
    $dsn = "mysql:hostname=localhost;dbname=employees";
    $conn = new PDO($dsn, "employeesApp", "inet2005");

    return $conn;
}