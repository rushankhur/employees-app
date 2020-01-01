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

<!-- Employees by gender TABLE -->
<section class="outer">
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="col-md-11 m-0">
                                <h3 class="m-0">Employees by gender</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-condensed">
                            <thead class="thead-dark">
                            <tr>
                                <th>Employees total</th>
                                <th>Male employees</th>
                                <th>Female employees</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            // Connection to db
                            require_once('dbconn.php');
                            $conn = getConnection();  // PDO connection

                            $total_employees = "SELECT COUNT(emp_no) FROM employees.employees";
                            $stmt = $conn->prepare($total_employees);
                            $stmt->execute();
                            $total_employees_fetch = $stmt->fetchColumn();

                            $total_employees_male = "SELECT COUNT(gender) FROM employees.employees WHERE gender='M'";
                            $stmt_male = $conn->prepare($total_employees_male);
                            $stmt_male->execute();
                            $total_employees_male_fetch = $stmt_male->fetchColumn();


                            $total_employees_female = "SELECT COUNT(gender) FROM employees.employees WHERE gender='F'";
                            $stmt_female = $conn->prepare($total_employees_female);
                            $stmt_female->execute();
                            $total_employees_female_fetch = $stmt_female->fetchColumn();

                            $recommendation = '';
                            if ($total_employees_male_fetch > $total_employees_female_fetch) {
                                $recommendation = 'Human resources committee strongly recomend you to think about gender inequality and hire more women.';
                            } else {
                                $recommendation = 'Human resources committee strongly recomend you to think about gender inequality and hire more men.';
                            }
                            ?>
                            <tr>
                                <td><?php echo "$total_employees_fetch" ?></td>
                                <td><?php echo "$total_employees_male_fetch"; ?></td>
                                <td><?php echo "$total_employees_female_fetch" ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>

<div class="container-fluid">
    <div class="row margin-bottom justify-content-center">
        <div class="col-md-11">
            <p><?php echo "<strong>Recommendation:</strong> $recommendation" ?></p>
        </div>
    </div>
</div><br><br>

<!-- Employees by department TABLE -->
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="col-md-11 m-0">
                                <h3 class="m-0">Employees by department</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-condensed">
                            <thead class="thead-dark">
                            <tr>
                                <th>Customer Service</th>
                                <th>Development</th>
                                <th>Finance</th>
                                <th>HR</th>
                                <th>Marketing</th>
                                <th>Production</th>
                                <th>QM</th>
                                <th>Research</th>
                                <th>Sales</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $query_departments = <<<SQL
                              SELECT employees.departments.dept_name, COUNT(employees.dept_emp.emp_no) AS numberOfEmployees FROM employees.dept_emp
                              LEFT JOIN employees.departments ON employees.dept_emp.dept_no = employees.departments.dept_no
                              GROUP BY dept_name
SQL;
                            $stmt_departments = $conn->prepare($query_departments);   // transform query string to a prepared statement
                            $result = $stmt_departments->execute();

                            if (!$result) {
                                die('Could not retrieve records from the Database.');
                            }

                            $departArray = [];
                            while ($row = $stmt_departments->fetch(PDO::FETCH_ASSOC)) {
                                array_push($departArray, $row['numberOfEmployees']);
                            }
                            ?>
                            <tr>
                                <td><?php echo "$departArray[0]" ?></td>
                                <td><?php echo "$departArray[1]" ?></td>
                                <td><?php echo "$departArray[2]" ?></td>
                                <td><?php echo "$departArray[3]" ?></td>
                                <td><?php echo "$departArray[4]" ?></td>
                                <td><?php echo "$departArray[5]" ?></td>
                                <td><?php echo "$departArray[6]" ?></td>
                                <td><?php echo "$departArray[7]" ?></td>
                                <td><?php echo "$departArray[8]" ?></td>
                                <td><?php echo "$departArray[9]" ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<?php include_once("./html/footer.html"); ?>

</body>
</html>

