<?php
    $message = '';
    $messageBot = '';
    if(isset($_POST['username'])){
        $username = $_POST['username'];
    }
    if(isset($_POST['password'])){
        $password = $_POST['password'];
    }

    if(isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    // reCAPTCHA V2
    if(isset($_POST['submit']) && !$captcha) {
        $message = "Please check the captcha form.";
    } else if (isset($_POST['submit'])) {
        $secretKey = "6LeUh74UAAAAAL_Hh_NCyUik-h3bgvIaWuC3kFhD";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        if($responseKeys["success"]) {
            $messageBot =  "You are not not a bot!";
        } else {
            $messageBot = "You are a bot! Please go away!";
        }


        // REGISTER a NEW USER
        require_once('dbconn.php');
        $conn = getConnection();  // PDO connection

        $query_isexist = "SELECT * FROM employees.newUsers WHERE user_name = :username";
        $stmt_isexist = $conn->prepare($query_isexist);
        $stmt_isexist->bindParam(":username", $username);
        $stmt_isexist->execute();

        $user = $stmt_isexist->fetch();

        if ($user) {
            $message = "The username already exists. Please use a different username.";
        } else {
            $hash = password_hash($password,PASSWORD_BCRYPT);
            $query = "INSERT INTO employees.newUsers (user_name, user_pwd) VALUES (:username, :hash)";

            $stmt = $conn->prepare($query);   // transform query string to a prepared statement
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":hash", $hash);

            $result = $stmt->execute();

            if (!$result) {
                die("Unable to insert record");

            } else {
                $message = "Successfully added " . $stmt->rowCount() . " record(s).";
            }
        }
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
    <title>Sign Up</title>
</head>

<body>
<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
        <a class="navbar-brand assignment" href="#">Assignment 1</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <form class="form-inline">
                <a class="btn btn-outline-primary my-2 my-sm-0" href="index.php" role="button">Back to Log In</a>
            </form>
    </nav>
</header><br><br>


<section class="outer">
    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center">
            <div class="col-md-11">
                <h5 class="mb-4">Create a New User:</h5>
                <form id="newUser" name="newUser" method="post" action="register.php">
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Username:</div>
                        <input class="form-control" type="text" name="username" id="username"/>
                    </div>
                    <div class="form-inline mb-3">
                        <div class="col-md-1 col-form-label px-0">Password:</div>
                        <input class="form-control" type="text" name="password" id="password"/>
                    </div>
                    <p><input class="btn btn-primary" type="submit" id="submit" name="submit" value="Submit"/></p>
                    <div class="g-recaptcha mt-5" data-sitekey="6LeUh74UAAAAAODpEBG1KftIFBhh-fwp4qv3xI9k"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row margin-bottom justify-content-center mt-4">
            <div class="col-md-11">
                <p><?php echo $messageBot ?></p>
            </div>
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

