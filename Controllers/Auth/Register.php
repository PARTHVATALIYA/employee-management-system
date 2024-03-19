<?php

class Register extends Connection
{
    protected $responseStatus, $responseMessage, $sendMail;
    
    public function __construct()
    {
        parent::__construct();
        $this->sendMail = new SendMail();
    }

    public function register()
    {
        try {
            $dataArr = [
                'first name' => isset($_POST['firstName']) ? $_POST['firstName'] : NULL,
                'last name' => isset($_POST['lastName']) ? $_POST['lastName'] : NULL,
                'email' => isset($_POST['email']) ? $_POST['email'] : NULL,
                'password' => isset($_POST['password']) ? $_POST['password'] : NULL,
                'confirm password' => isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : NULL,
                'phone number' => isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : NULL,
                'gender' => isset($_POST['gender']) ? $_POST['gender'] : NULL,
                'hobby' => isset($_POST['hobby']) ? $_POST['hobby'] : NULL,
                'grades' => isset($_POST['grades']) ? $_POST['grades'] : NULL,
                'message' => isset($_POST['message']) ? $_POST['message'] : NULL
            ];

            $lengthOfPhoneNumber = strlen((string) $dataArr['phone number']);
            if ($lengthOfPhoneNumber > 10) {
                throw new Exception("Maximum length of phone number is 10", 400);
            }

            foreach ($dataArr as $key => $value) {
                if ($value == NULL) {
                    $flag = false;
                    throw new Exception($key . " is required", 400);
                }
            }
            $dataArr = sanitizeData($dataArr);

            if (! $dataArr) {
                throw new Exception("Invalid email address!", 400);
            }

            if ($dataArr['password'] != $dataArr['confirm password']) {
                throw new Exception("Password must be same!", 400);
            }

            $firstname = $dataArr['first name'];
            $lastName = $dataArr['last name'];    
            $email = $dataArr['email'];
            $password = password_hash($dataArr['password'], PASSWORD_DEFAULT);
            $phoneNumber = $dataArr['phone number'];
            $gender = $dataArr['gender'];
            $hobby = $dataArr['hobby'];
            $grades = $dataArr['grades'];
            $message = $dataArr['message'];
            $role = "Student";
            $createdAt = date("Y-m-d H:i:s");
            $targetDir = './../public/uploads/';
            $imageFileType = strtolower(pathinfo($_FILES['profilePicture']['name'],PATHINFO_EXTENSION));
            $imgType = ["png", "jpg", "jpeg"];
            $verificationToken = bin2hex(random_bytes(16));
            $length = strlen($email);
            
            for ($i = 0; $i < $length; $i++) {
                if ($email[$i] == '@') {
                    $userName = substr($email, 0, $i);
                    break;
                }
            }

            if (!empty($_FILES["profilePicture"]["tmp_name"]) && in_array($imageFileType, $imgType)) {
                $mimeType = mime_content_type($_FILES['profilePicture']['tmp_name']);
                $allowMimetype = ['image/png', 'image/jpeg', 'image/jpg'];

                if (! in_array($mimeType, $allowMimetype)) {
                    throw new Exception("Invalid image type", 400);
                }

                $selectGradeID = $this->connection->query("SELECT id from grades where grade = '$grades'");
                $result = $selectGradeID->fetch_assoc();
                $gradeID = $result['id'];
                $imageName = time() . "." . $imageFileType;

                $addStudent = $this->connection->prepare("INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `phone_number`, `gender`, `message`, `profile_picture`, `grade_id`, `user_name`, `role`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $addStudent->bind_param("ssssisssisss", $firstname, $lastName, $email, $password, $phoneNumber, $gender, $message, $imageName, $gradeID, $userName, $role, $createdAt);

                if ($addStudent->execute()) {
                    move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetDir . $imageName);

                    $selectID = $this->connection->query("SELECT id from users where email = '$email'");
                    $result = $selectID->fetch_assoc();
                    $id = $result['id'];

                    $addVerificationToken = $this->connection->prepare("INSERT into mail_verifications (token, user_id, created_at) values (?, ?, ?)");
                    $addVerificationToken->bind_param("sis", $verificationToken, $id, $createdAt);
                    $addVerificationToken->execute();

                    $addHobby = $this->connection->prepare("INSERT into hobbies (user_id, name) values (?,?)");
                    foreach($hobby as $value) {
                        $addHobby->bind_param("is", $id, $value);
                        $addHobby->execute();
                    }
                    $sendMailFrom = 'vatliyaparth111@gmail.com';
                    $sendMailTo = $email;
                    $subject = 'Mail verification';
                    $body = "<a href='http://localhost/practice/userManagement/views/auth/emailVerified.php?token=$verificationToken'> click me</a>";

                    $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);

                    $this->responseStatus = 201;
                    $this->responseMessage = "Mail send to your mail address";
                }
            } else{
                throw new Exception ("Image is not selected", 204);
            } 
        } catch (Exception $error) {
            $this->responseStatus = $error->getCode();
            $this->responseMessage = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: $this->responseStatus, error: $this->responseMessage, Line: " . $error->getLine() . PHP_EOL;
            $errorFile = fopen('./../errors.log', 'a');
            fwrite($errorFile, $errorMessage);
            fclose($errorFile);
        } finally {   
            $responseArr = array(
                'status' =>$this->responseStatus,
                'message' =>$this->responseMessage
            );
            return json_encode($responseArr);
        }
    }
}
?>
