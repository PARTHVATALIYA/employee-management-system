<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="http://localhost/practice/userManagement/public/assets/css/navbar.css">
        <link rel="stylesheet" href="http://localhost/practice/userManagement/public/assets/css/sidebar.css">
        <link rel="stylesheet" href="http://localhost/practice/userManagement/public/assets/css/notification.css">
        <title>Document</title>
    </head>
    <body>
        <?php
            session_start();
            if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
                require './layout/navbar.php';
                require './layout/sidebar.php'
        ?>
        <button class="backButton" onclick="history.go(-1);"><i class="fa-solid fa-arrow-left"></i></button>
        <section>
            <button type="button" class="btn btn-primary sendNotification" data-bs-toggle="modal" data-bs-target="#model">Send notification</button>
            <div class="modal fade" id="model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Send notification</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="sendNotificationForms">
                                <div class="mb-3">
                                    <label for="subject-name" class="col-form-label">Subject:</label>
                                    <input type="text" class="form-control" id="subject-name" name="subject">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Recipient:</label>
                                    <select class="form-control recipients" id="recipientName" multiple="true" name="recipient[]" data-error=".recipientError">
                                    </select>
                                    <span class="recipientError"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">description:</label>
                                    <textarea class="form-control" id="message-description" name="description"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="sendNotification">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="modal fade" id="notificationDataModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Notification</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="subject-name" class="col-form-label">Subject:</label>
                                <label for="subjectName" class="col-form-label" id="subject"></label>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <label for="recipientName" class="col-form-label" id="recipient"></label>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">description:</label>
                                <textarea class="form-control" id="description" disabled></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="table">
            <thead>
                <th>Subject</th>
                <th>Recipient</th>
                <th>Show</th>
            </thead>
            <tbody class="notifications">

            </tbody>
        </table>
        <?php
            } else {
                header("location: ./../auth/login.php");
            }
        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="http://localhost/practice/userManagement/public/assets/js/navbar.js"></script>
    <script src="http://localhost/practice/userManagement/public/assets/js/sidebar.js"></script>
    <script src="http://localhost/practice/userManagement/public/assets/js/notification.js"></script>
</html>