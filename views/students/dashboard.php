<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="http://localhost/practice/userManagement/public/assets/css/userDashboard.css">
        <link rel="stylesheet" href="http://localhost/practice/userManagement/public/assets/css/userNavbar.css">
        <title>Document</title>
    </head>
    <body>
        <?php
            session_start();

            if (isset($_SESSION['user']) && $_SESSION['user'] != 'admin') {
                require_once './../../middleware/checkStatus.php';
                require './layout/navbar.php';
        ?>
            <section class="dashboardSection">
                <div class="dashboard d-flex justify-content-center">
                    <div class="user" id="user">

                    </div>
                </div>
            </section>
        <?php
            } else {
                header("location: ./../auth/login.php");
            }
        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="http://localhost/practice/userManagement/public/assets/js/userDashboard.js"></script>
</html>