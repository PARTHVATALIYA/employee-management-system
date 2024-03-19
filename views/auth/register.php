<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../public/assets/css/register.css">
        <title>Document</title>
    </head>
    <body>
        <div class="justify-content-center formLoader" id="formLoader">
            <div class="loader" id="loader"></div>
        </div>
        <div class="wrapper registrationForm" id="registrationForm">
            <div class="logo d-flex justify-content-center mt-3 mb-3">
                <img src="http://localhost/practice/userManagement/public/assets/image/logo.png" alt="">
            </div>
            <div class="inner">
                <form class="d-flex justify-content-center flex-column registrationForm" id="studentForm">
                    <h3>Sign Up</h3>
                    <div class="form-wrapper mt-2">
                        <div class="studentName mb-3 row">
                            <div class="col-lg-6 firstName">
                                <label for="firstName">Enter student first name*: </label>
                                <input class="form-control" type="text" name="firstname" id="firstname">
                            </div>
                            <div class="col-lg-6 lastName">
                                <label for="lastName">Enter student last name*: </label>
                                <input class="form-control" type="text" name="lastName" id="lastName">
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper mt-2">
                        <div class="emailAndPassword mb-3 row ">
                            <div class="email col-lg-6 col-md-6 col-sm-6">
                                <label for="email">Enter email Address*: </label>
                                <input class="form-control" class="emailInput"  type="email" name="email" id="email">
                            </div>
                            <div class="col-lg-6 grade">
                                <label for="grade">Select grade: </label>
                                <select name="grades" class="grades p-2" id="grades"></select>
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper mt-2">
                        <div class="phoneNumebrAndGender mb-3 d-flex row flex-row">
                            <div class="phoneNumber d-flex col-lg-6 col-md-6 col-sm-6 flex-column">
                                <label for="phoneNumber">Enter phone number*: </label>
                                <input class="form-control" class="phoneNumberInput"  type="number" name="phoneNumber" id="phoneNumber" >
                            </div>
                            <div class="gender d-flex col-lg-6 col-md-6 col-sm-6 flex-column">
                                <label for="gender">Select gender*: </label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type = "radio" name = "gender"  value = "Male" data-error=".genderError">
                                        <label class = "me-2" for="male">Male</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type = "radio" name = "gender"  value = "Female" data-error=".genderError">
                                        <label for="male">Female</label>
                                    </div>
                                </div>
                                <span class="genderError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="hobbyAndGrade row mb-3">
                            <div class="col-lg-6 hobby">
                                <div class="hobbyLabel">
                                    <label for="hobby">Select hobbies*: </label>
                                </div>
                                <div class="hobbyCheckbox">
                                    <input type="checkbox" id="cricket" name="hobby[]" value="cricket" data-error=".hobbyError">
                                    <label for="cricket"> cricket</label><br>
                                    <input type="checkbox" id="football" name="hobby[]" value="football" data-error=".hobbyError">
                                    <label for="football"> football</label><br>
                                    <input type="checkbox" id="basketball" name="hobby[]" value="basketball" data-error=".hobbyError">
                                    <label for="basketball"> basketball</label><br>
                                </div>
                                <span class="hobbyError"></span>
                            </div>
                            <div class="password col-lg-6 col-md-6 col-sm-6 ">
                                <div class="password">
                                    <label for="password">Enter password*: </label>
                                    <input class="form-control" class="passwordInput"  type="password" class="password" name="password" id="password" >
                                </div>    
                                <div class="confirmPassword  ">
                                    <label for="confirmPassword">Enter confirm password*: </label>
                                    <input class="form-control" class="confirmPasswordInput"  type="password" name="confirmPassword" id="confirmPassword">
                                    <span class="passwordError text-danger" id="passwordError"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="message mb-3">
                            <label for="message">Enter message*: </label>
                            <textarea class="form-control" name="message" id="message" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <div class="profilePicture mb-3">
                            <input type="file" name="profilePicture" id="profilePicture" accept="image/x-png, image/jpeg, image/jpg">
                            <p>(Only .png, .jpeg, .jpg file accepted)</p>
                        </div>
                    </div>
                    <div class="form-wrapper newUser mt-2">
                        <p>Already have an account? <a href="login.php">Sign In</a></p>    
                    </div>
                    <div class="submitButton d-flex justify-content-center m-2">
                        <button class="btn btn-primary submitData" id="submitData">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
        
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="./../../public/assets/js/register.js"></script>
</html>