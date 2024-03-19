<?php
    use Dotenv\Dotenv;

    require_once realpath("./../vendor/autoload.php");
    $dotenv = Dotenv::createImmutable('./../');
    $dotenv->load();
    $database = require_once('./../config/database.php');
    $mail = require_once('./../config/mail.php');

    require_once './../services/mailService.php';
    require_once './../Controllers/Connection.php';
    require_once './../Controllers/Auth/UserLogin.php';
    require_once './../Controllers/Auth/Register.php';
    require_once './../Controllers/Grade.php';
    require_once './../Controllers/UserData.php';
    require_once './../Controllers/Admin/DeleteUser.php';
    require_once './../Controllers/UpdateUserData.php';
    require_once './../Controllers/Admin/ChangeUserStatus.php';
    require_once './../Controllers/Student/GetUserProfile.php';
    require_once './../Controllers/Student/VerifiedUser.php';
    require_once './../Controllers/Auth/ForgotPassword.php';
    require_once './../Controllers/Auth/ResetPassword.php';
    require_once './../Controllers/Admin/ApproveUser.php';
    require_once './../Controllers/Auth/LinkExpire.php';
    require_once './../Controllers/Student/CheckUser.php';
    require_once './../Controllers/Admin/GetAdmin.php';
    require_once './../Controllers/Admin/ShowUser.php';
    require_once './../Controllers/Admin/UsersMail.php';
    require_once './../Controllers/Admin/SendNotification.php';
    require_once './../Controllers/Admin/GetNotifications.php';
    require_once './../Controllers/Admin/GetNotificationData.php';
    require_once './../middleware/checkToken.php';
    require_once './../middleware/sanitizeData.php';

    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case 'POST': 
            $endpoint = $_SERVER['PATH_INFO'];
            
            switch ($endpoint) {
                case '/login':
                    $user = new UserLogin();
                    echo $user->userLogin();
                    break;
                case '/updateUser':
                    $updateUserData = new UpdateUserData();
                    echo $updateUserData->updateUserData($_GET['id']);
                    break;
                case '/registration':
                    $register = new Register();
                    echo $register->Register();
                    break;
                case '/changeUserStatus':
                    $changeUserStatus = new ChangeUserStatus();
                    echo $changeUserStatus->changeUserStatus($_GET['id']);
                    break;
                case '/forgotPassword':
                    $forgotPassword = new ForgotPassword();
                    echo $forgotPassword->forgotPassword();
                    break;
                case '/resetPassword':
                    $resetPassword = new ResetPassword();
                    echo $resetPassword->resetPassword($_GET['token']);
                    break;
                case '/approveUser':
                    $approveUser = new ApproveUser($_GET['id']);
                    echo $approveUser->approveUser();
                    break;
                case '/sendNotification':
                    $sendNotification = new SendNotification();
                    echo $sendNotification->sendNotification();
                    break;
                case '/loginWithgoogle':
                    $loginWithgoogle = new LoginWithgoogle();
                    echo $loginWithgoogle->loginWithgoogle();
            }

        case 'GET':
            $endpoint = $_SERVER['PATH_INFO'];

            switch ($endpoint) {
                case '/userData':
                    if (isset($_GET['id'])) {
                        $userData = new UserData();
                        echo $userData->userData($_GET['id']);
                    } else {
                        $userData = new userData();
                        echo $userData->userData();
                    }
                    break;
                case '/grade':
                    $grade = new Grade();
                    echo $grade->grade();
                    break;
                case '/userProfile':
                    $userProfile = new GetUserProfile();
                    echo $userProfile->getUserProfile();
                    break;
                case '/verifiedUser':
                    $verifiedUser = new VerifiedUser();
                    echo $verifiedUser->verifiedUser($_GET['token']);
                    break;
                case '/linkExpire' :
                    $linkExpire = new LinkExpire();
                    echo $linkExpire->linkExpire($_GET['token']);
                    break;
                case '/checkUser' :
                    $checkUser = new CheckUser();
                    echo $checkUser->checkUser($_GET['id']);
                    break;
                case '/admin' :
                    $admin = new GetAdmin();
                    echo $admin->getAdmin();
                    break;
                case '/showUser':
                    $showUser = new ShowUser();
                    echo $showUser->showUser($_GET['id']);
                    break;
                case '/userMail':
                    $userMails = new UsersMail();
                    echo $userMails->usersMail();
                    break;
                case '/getNotifications':
                    $getNotifications = new GetNotifications();
                    echo $getNotifications->getNotifications();
                    break;
                case '/getNotificationData':
                    $getNotificationData = new GetNotificationData();
                    echo $getNotificationData->getNotificationData($_GET['id']);
                    break;
                
            }
        case 'DELETE':
            $endpoint = $_SERVER['PATH_INFO'];
            if ($endpoint == '/deleteUser') {
                $deleteUser = new DeleteUser();
                echo $deleteUser->deleteUser($_GET['id']);
            }
    }
?>