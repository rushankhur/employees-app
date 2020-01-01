<?php
    require('isLoggedIn.php');
    checkIfLoggedIn();
?>
<!DOCTYPE html>
<html>
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
    <script src="validation.js" type="text/javascript"></script>
    <title>Add new Employee</title>
</head>

<body>
<!-- HEADER -->
<?php include_once("./html/header.html"); ?>
<br><br>

<section class="outer">
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <h5 class="mb-4">Add a New Employee to Database:</h5>
                <form id="newEmployee" name="newEmployee" method="post" action="add.php" onsubmit="return validateForm(this)">
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Birth Date:</div>
                        <input class="form-control" type="text" name="birthDate" id="birthDate" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="bdWarning" id="bdWarning">Must be in YYYY-MM-DD number format</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">First Name:</div>
                        <input class="form-control" type="text" name="firstName" id="firstName" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="fnWarning" id="fnWarning">Must begin with a capital letter followed by one or more lower case letters</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Last Name:</div>
                        <input class="form-control" type="text" name="lastName" id="lastName" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="lnWarning" id="lnWarning">Must begin with a capital letter followed by one or more lower case letters</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Gender:</div>
                        <input class="form-control" type="text" name="gender" id="gender" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="gWarning" id="gWarning">Must be 'M' or 'F'</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Hire Date:</div>
                        <input class="form-control" type="text" name="hireDate" id="hireDate" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="hdWarning" id="hdWarning">Must be in YYYY-MM-DD number format</span>
                    </div>
                    <p><input class="btn btn-primary" type="submit" id="submit" value="Submit"/></p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
    $birthDate = $_POST['birthDate'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $hireDate = $_POST['hireDate'];

    if (!empty($birthDate) && !empty($firstName) && !empty($lastName) && !empty($gender) && !empty($hireDate)) {
        // Connection to db
        require_once('dbconn.php');
        $conn = getConnection();  // PDO connection

//     Heredoc syntax:
    $query = <<<SQL
        INSERT INTO employees.employees (birth_date, first_name, last_name, gender, hire_date) VALUES
        (STR_TO_DATE(:birthDate,'%Y-%m-%d'), :firstName, :lastName, :gender, STR_TO_DATE(:hireDate,'%Y-%m-%d'))
SQL;

    $stmt = $conn->prepare($query);   // transform query string to a prepared statement
    $stmt->bindParam(":birthDate", $birthDate);
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":lastName", $lastName);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":hireDate", $hireDate);

    $result = $stmt->execute();

    if (!$result) {
        die("Unable to insert record");
    } else {
        echo "Successfully added " . $stmt->rowCount() . " record(s).";
    }
}
?>

<!-- FOOTER -->
<?php include_once("./html/footer.html"); ?>

</body>
</html>
