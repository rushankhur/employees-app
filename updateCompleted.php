<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <title>Update completed</title>
</head>
<body>

<!-- HEADER -->
<?php include_once("./html/header.html"); ?>
<br><br>

<?php
    // Connection to db
    require_once('dbconn.php');
    $conn = getConnection();  // PDO connection

    $empNo = $_POST['empNo'];
    $birthDate = $_POST['birthDate'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $hireDate = $_POST['hireDate'];

    // Update an employee
    if (!empty($empNo) && !empty($birthDate) && !empty($firstName) && !empty($lastName) && !empty($gender) && !empty($hireDate)) {

        $query = <<<SQL
        UPDATE employees.employees SET birth_date = :birthDate, first_name = :firstName, last_name = :lastName,
        gender = :gender, hire_date = :hireDate
        WHERE emp_no = :empNo
SQL;

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":empNo", $empNo);
        $stmt->bindParam(":birthDate", $birthDate);
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName", $lastName);
        $stmt->bindParam(":gender", $gender);
        $stmt->bindParam(":hireDate", $hireDate);

        $result = $stmt->execute();
        if (!$result) {
            die("Unable to update record.");
        } else {
            echo "Successfully updated " . $stmt->rowCount() . " record(s).";
        }
    }
?>

<section class="outer">
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <p><a href="main.php">Back to Main page</a></p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<?php include_once("./html/footer.html"); ?>

</body>
</html>

