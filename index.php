<?php
        // reCAPTCHA V2
        $response = $_POST["g-recaptcha-response"];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => 'YOUR_SECRET',
            'response' => $_POST["g-recaptcha-response"]
        );
        $options = array(
            'http' => array (
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success=json_decode($verify);
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Main Login</title>
</head>

<!--INFO and SIGN UP BUTTONS -->
<header>
    <div id="container-fluid">
        <div class="row">
            <div class="col-md-11 mt-3">
                <button type="button" class="btn btn-warning btn-circle btn-lg ml-3" data-toggle="modal" data-target="#infoModal">
                    <i class="fa fa-info"></i>
                </button>
            </div>
            <div class="col-md-1 float-right mt-3 pl-0">
                <a class="btn btn-outline-primary my-sm-0" href="register.php" role="button">Sign Up</a>
            </div>
        </div>
    </div>
</header>

<!-- MODAL -->
<?php include_once("./html/modal.html"); ?>


<body class="mainLogin-bgImage">

<!-- LOG IN CARD -->
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="card" style="width: 22rem;">
            <article class="card-body">
                <h4 class="card-title text-center mb-4 mt-1">Log in</h4>
                <hr>
                <form class="mt-4" name="loginForm" id="loginForm" method="post" action="checkLogin.php">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>
                            <input name="loginUser" id="loginUser" type="text" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                            </div>
                            <input class="form-control" name="loginPwd" id="loginPwd" type="password" placeholder="******">
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LeUh74UAAAAAODpEBG1KftIFBhh-fwp4qv3xI9k" data-callback="enableBtn"></div>
                    <div class="form-group row justify-content-center mt-3">
                        <input type="submit" name="submit" id="button1" value="Login" class="btn btn-primary btn-block col-md-5" />
                    </div>
                </form>
            </article>
        </div>
    </div>
</div>

<script>
    document.getElementById("button1").disabled = true;
    function enableBtn(){
        document.getElementById("button1").disabled = false;
    }
</script>

</body>
</html>