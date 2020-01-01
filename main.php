<?php
    require('isLoggedIn.php');
    checkIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
<!--    <script type="text/javascript" src="form_process.js"></script>-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <title>Main page</title>
</head>

<body>
    <!-- HEADER -->
    <?php include_once("./html/header.html"); ?>
<br><br>

<!-- TABLE -->
<section>
    <div class="container-fluid">
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

                            if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                            } else {
                                $pageno = 1;
                            }
                            $no_of_records_per_page = 25;
                            $offset = ($pageno - 1) * $no_of_records_per_page;

                            // Connection to db
                            require_once('dbconn.php');
                            $conn = getConnection();  // PDO connection

                            $total_pages_sql = "SELECT COUNT(*) FROM employees";
                            $stmt = $conn->prepare($total_pages_sql);
                            $stmt->execute();

                            $total_rows = $stmt->fetchColumn();
                            $total_pages = ceil($total_rows / $no_of_records_per_page);

                            $query = "SELECT * FROM employees LIMIT $offset, $no_of_records_per_page";
                            $stmt_next = $conn->prepare($query);
                            $stmt_next->execute();

                            while ($row = $stmt_next->fetch(PDO::FETCH_ASSOC)):
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
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--    PAGINATION-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <ul class="pagination justify-content-end my-4">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="<?php if ($pageno <= 1) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link" href="<?php if ($pageno <= 1) {
                        echo '#';
                    } else {
                        echo "?pageno=" . ($pageno - 1);
                    } ?>">Prev</a>
                </li>
                <li class="<?php if ($pageno >= $total_pages) {
                    echo 'disabled';
                } ?>">
                    <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                    } else {
                        echo "?pageno=" . ($pageno + 1);
                    } ?>">Next</a>
                </li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?php include_once("./html/footer.html"); ?>

</body>
</html>

<!--https://www.myprogrammingtutorials.com/create-pagination-with-php-and-mysql.html-->
<!--https://www.a2zwebhelp.com/php-mysql-pagination-->

<!--Are you sure you want to delete this record?-->
