<?php
require('isLoggedIn.php');
checkIfLoggedIn();
?>
<!--Sticky form-->
<?php
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
?>

<!DOCTYPE html>
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
    <title>Search page</title>
</head>

<body>
<!-- HEADER -->
<?php include_once("./html/header.html"); ?>
<br><br>

<section class="outer">
    <!-- SEARCH FIELD -->
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <h5 class="mb-4">Search First & Last Names From Database:</h5>
                <form action="search.php" method="post" name="employeeList">
                    <div class="form-inline">
                        <div class="col-md-1 col-form-label px-0" for="search">Search:</div>
                        <input class="form-control col-md-3" name="search" type="text" value="<?php echo $search; ?>">
                    </div>
                    <p class="mt-3">
                        <input class="btn btn-primary" name="Submit Query" type="submit">
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="container-fluid mt-4">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="col-md-11 m-0">
                                <h3 class="m-0">Employees</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-condensed">
                            <thead class="thead-dark">
                            <tr>
                                <th>Emp. Number</th>
                                <th>Birth Date</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Hire Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>


                            <?php

                            if (isset($_POST['search'])) {

                                // Including a file
                                require_once('dbconn.php');
                                $conn = getConnection();  // PDO connection

                                $message = '';
                                $search = $_POST['search'];
                                $query = "SELECT * FROM employees WHERE first_name LIKE :search OR last_name LIKE :search;";

                                $stmt = $conn->prepare($query);   // transform query string to a prepared statement
                                $stmt->bindValue(":search", '%' . $search . '%');

                                $result = $stmt->execute();
                                if (!$result) {
                                    die('Could not retrieve records from the Database.');
                                }


                            if ($stmt->rowCount() < 1) {
                                $message = 'Employee with this name was not found.';
                            } else {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr>
                                        <td><?php echo $row['emp_no'] ?></td>
                                        <td><?php echo $row['birth_date'] ?></td>
                                        <td><?php echo $row['first_name'] ?></td>
                                        <td><?php echo $row['last_name'] ?></td>
                                        <td><?php echo $row['gender'] ?></td>
                                        <td><?php echo $row['hire_date'] ?></td>
                                        <td>
                                            <form action="updateEmployee.php" method="POST">
                                                <input type="hidden" name="empNo" value="<?php echo $row['emp_no']; ?>">
                                                <button type="submit" class="btn btn-secondary btn-sm">
                                                    <em class="far fa-edit"></em>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="confirmDel.php" method="POST">
                                                <input type="hidden" name="empNo" value="<?php echo $row['emp_no']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <em class="far fa-trash-alt"></em>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php
                                endwhile;

                                }
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center mt-4">
            <div class="col-md-11">
                <p><?php echo $message ?></p>
            </div>
        </div>
    </div>
</section>


<!-- FOOTER -->
<?php include_once("./html/footer.html"); ?>

</body>
</html>



