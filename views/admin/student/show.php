<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="http://localhost/practice/userManagement/public/assets/css/show.css">
        <title>Document</title>
    </head>
    <body>
    <?php
        session_start();

        if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
    ?>
        <button class="backButton" onclick="history.go(-1);"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="wrapper registrationForm" id="registrationForm">
            <div class="inner">
                <form class="d-flex justify-content-center flex-column registrationForm" id="userUpdateForm">
                    <div class="form-wrapper mt-2 d-flex align-items-center">
                        <div>
                            <div class="form-wrapper d-flex align-items-center">
                                <span class="userProfilePicture" id="userProfilePicture"></span>
                            </div>
                        </div>
                        <div class="ms-5">
                            <div class="studentName mb-3 row">
                                <div class="col-lg-6 firstName">
                                    <!-- <label for="firstName">Enter student first name*: </label>
                                    <input class="form-control" type="text" name="firstname" id="firstname" disabled> -->
                                    <label for="firstName">First name: </label>
                                    <label for="firstName" id="firstname"></label>
                                </div>
                                <div class="col-lg-6 lastName">
                                    <label for="lastname">Last name: </label>
                                    <label for="lastname" id="lastName"></label>
                                </div>
                            </div>
                            <div class="form-wrapper mt-2">
                                <div class="emailAndUserName mb-3 row ">
                                    <div class="email col-lg-6 col-md-6 col-sm-6">
                                        <label for="email">Email address: </label>
                                        <label for="email" id="email"></label>
                                    </div>
                                    <div class="col-lg-6 userName">
                                        <label for="userName">User name: </label>
                                        <label for="userName" id="userName"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper mt-2">
                                <div class="phoneNumebrAndGender mb-3 d-flex row ">
                                    <div class="phoneNumber col-lg-6 col-md-6 col-sm-6 ">
                                        <label for="phoneNumber">Phone number: </label>
                                        <label for="phoneNumber" id="phoneNumber"></label>
                                    </div>
                                    <div class="gender col-lg-6 col-md-6 col-sm-6 ">
                                        <label for="gender">Gender: </label>
                                        <label for="gender" id="gender"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-wrapper mt-2">
                                <div class="hobbyAndGrade mb-3 d-flex row ">
                                    <div class="hobby col-lg-6 col-md-6 col-sm-6">
                                        <label for="hobby">Hobbies: </label>
                                        <label for="hobby" id="hobby"></label>
                                    </div>
                                    <div class="grade col-lg-6 col-md-6 col-sm-6">
                                        <label for="grade">Grade: </label>
                                        <label for="grade" id="grade"></label>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-wrapper">
                                <div class="message mb-3">
                                    <label for="message">Message: </label>
                                    <label for="message" id="message"></label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    <?php    
        } else {
            header("location: ./../../auth/login.php"); 
        }
    ?>
        
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="http://localhost/practice/userManagement/public/assets/js/show.js"></script>
</html>