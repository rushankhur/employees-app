<?php
session_start();   // gives access to session array

// Connection to db
//include("dbConn.php");
//$conn = connectToDB();
require_once('dbconn.php');
$conn = getConnection();  // PDO connection

$username = $_POST['loginUser'];
$pwd = $_POST['loginPwd'];

//sanitize our inputs     Prevent sql injections
//$username = stripslashes($username);
//$username = mysqli_real_escape_string($conn, $username);

//$sql = "SELECT * FROM newUsers WHERE user_name = '$username'";
$sql = "SELECT * FROM newUsers WHERE user_name = :username";

$stmt = $conn->prepare($sql);   // transform sql string to a prepared statement
$stmt->bindParam(":username", $username);


$stmt->execute();
//$result = mysqli_query($conn, $sql);
//if(!$result){
//    die("An error occured in query.");
//}
//mysqli_close($conn);
//$stmt->close();

//$count = mysqli_num_rows($result);
//$count = $result->rowCount();

//$results = $result->fetchAll();
//$count = count($results);

//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$count = count($results);

$count = $stmt->rowCount();

if($count == 1) {
    //a row was returned....
//    $row = mysqli_fetch_assoc($result);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //get the hashed value from the user_pwd
    $hash = $row['user_pwd'];

    if(password_verify($pwd, $hash)){
        //password matches, grant access
        $_SESSION['LoggedInUser'] = $username;
        header("location:main.php");
    }
}



echo "Incorrect Login<br/>";
echo "<a href='index.php'>Try Again</a>";
