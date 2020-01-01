<?php
    require('isLoggedIn.php');
    checkIfLoggedIn();
    
    // Including a file
    require_once('dbconn.php');
    $conn = getConnection();  // PDO connection

    $empNo = $_POST['empNo'];

    $query = "CALL GetEmployeeByNumber(:empNo);";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":empNo", $empNo, PDO::PARAM_INT);

    $result = $stmt->execute();
    if (!$result) {
        die("Employee with number $empNo was not found");
    } else {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $birthDate = $data['birth_date'];
        $firstName = $data['first_name'];
        $lastName = $data['last_name'];
        $gender = $data['gender'];
        $hireDate = $data['hire_date'];
    }
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
    <title>Update Employee</title>
</head>

<body>
<!-- HEADER -->
<?php include_once("./html/header.html"); ?>
<br><br>

<section class="outer">
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <h5 class="mb-4">Update Employee Records:</h5>
                <form id="newEmployee" name="newEmployee" method="post" action="updateCompleted.php" onsubmit="return validateForm(this)">
                    <p><input type="hidden" name="empNo" id="empNo" value="<?php echo $empNo; ?>"></p>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Birth Date:</div>
                        <input class="form-control" type="text" name="birthDate" id="birthDate" value="<?php echo $birthDate; ?>" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="bdWarning" id="bdWarning">Must be in YYYY-MM-DD number format</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">First Name:</div>
                        <input class="form-control" type="text" name="firstName" id="firstName" value="<?php echo $firstName; ?>" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="fnWarning" id="fnWarning">Must begin with a capital letter followed by one or more lower case letters</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Last Name:</div>
                        <input class="form-control" type="text" name="lastName" id="lastName" value="<?php echo $lastName; ?>" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="lnWarning" id="lnWarning">Must begin with a capital letter followed by one or more lower case letters</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Gender:</div>
                        <input class="form-control" type="text" name="gender" id="gender" value="<?php echo $gender; ?>" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="gWarning" id="gWarning">Must be 'M' or 'F'</span>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Hire Date:</div>
                        <input class="form-control" type="text" name="hireDate" id="hireDate" value="<?php echo $hireDate; ?>" onblur="returnUsual(this.id)"/>
                        <span class="ml-3" hidden style="color:red;" name="hdWarning" id="hdWarning">Must be in YYYY-MM-DD number format</span>
                    </div>
                    <p><input class="btn btn-primary" type="submit" id="submit" value="Update"/></p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<?php include_once("./html/footer.html"); ?>

</body>
</html>





