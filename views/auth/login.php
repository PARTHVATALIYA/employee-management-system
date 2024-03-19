<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/login.css">
        <title>Sign In</title>
    </head>
    <body>
    <?php
        session_start();
        use Dotenv\Dotenv;

        require_once './../../middleware/checkRole.php';
        require("./../../vendor/autoload.php");
        $dotenv = Dotenv::createImmutable("./../../");
        $dotenv->load();
        $googleCredentials = include('./../../config/google.php');
        include './../../services/googleService.php';
        $loginWithgoogle = new LoginWithGoogleService();

        // if (isset($_COOKIE['user'])) {
        //     setcookie("user", $_COOKIE['user'], time() + (86400 * 30), "/");
        //     if ($_COOKIE['user'] == 'admin') {
        //         header("location: admin.php");
        //     } else {
        //         header("location: userDashboard.php");
        //     }
        // } else {
    ?>
        <div class="wrapper loginForm">
            <div class="logo d-flex justify-content-center mt-5 mb-5">
                <img src="http://localhost/practice/userManagement/public/assets/image/logo.png" alt="">
            </div>
            <div class="inner">
                <form class="d-flex justify-content-center flex-column loginForm" id="loginForm">
                    <h3>Sign In</h3>
                    <div class="d-flex justify-content-center">
                        <span class="text-success" id="success"></span>
                    </div>
                    <div class="form-wrapper userName mt-2">
                        <input type="text" class="form-control userNameField" id="userName" name="userName" placeholder="Enter user name or email">
                    </div>
                    <div class="form-wrapper password mt-2">
                        <input type="password" class="form-control passwordField" id="password" name="password" placeholder="Enter password">
                    </div>
                    <span class="text-danger mt-2" id="error"></span>
                    <div class="form-wrapper forgotPassword mt-2">
                        <p><a href="forgotPassword.php">Forgot password?</a></p>
                    </div>
                    <div class="form-wrapper newUser mt-2">
                        <p>Don't have an account? <a href="register.php">Sign Up</a></p>    
                    </div>
                    <div class="btn">
                        <a href="<?php 
                            echo $loginWithgoogle->createAuthUrl(); ?>"><img class = "google"src="http://localhost/practice/userManagement/public/assets/image/google.png" alt="Google Logo"> Sign In with Google</a>
                    </div>
                    <div class="submit mt-2" id="submit">
                        <input type="submit" class="btn btn-primary" id="login" value="Sign In">
                    </div>
                </form>
            </div>
        </div>
    <?php
        // }
        
    ?>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./../../public/assets/js/login.js"></script>
    <?php
        if (isset($_SESSION['status']) && $_SESSION['status'] == 'de-active') {
    ?>
    <script>
        notificationBox ("You are de-activated!");
    </script>
    <?php
        }
        if (isset($_SESSION['approve']) && $_SESSION['approve'] == 0) {
    ?>
    <script>
        notificationBox ("Wait for admin approval");
    </script>
    <?php
        }
    ?>
</html>