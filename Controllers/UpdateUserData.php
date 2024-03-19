<?php

class UpdateUserData extends Connection
{
    protected $responseStatus, $responseMessage;

    function __construct()
    {
        parent::__construct();
    }

    function updateUserData($id = 0)
    {
        try {
            $dataArr = [
                'first name' => isset($_POST['firstName']) ? $_POST['firstName'] : NULL,
                'last name' => isset($_POST['lastName']) ? $_POST['lastName'] : NULL,
                'email' => isset($_POST['email']) ? $_POST['email'] : NULL,
                'phone number' => isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : NULL,
                'gender' => isset($_POST['gender']) ? $_POST['gender'] : NULL,
                'hobby' => isset($_POST['hobby']) ? $_POST['hobby'] : NULL,
                'grades' => isset($_POST['grades']) ? $_POST['grades'] : NULL,
                'message' => isset($_POST['message']) ? $_POST['message'] : NULL,
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

            $firstname = $dataArr['first name'];
            $lastname = $dataArr['last name'];
            $email = $dataArr['email'];
            $grade = $dataArr['grades'];
            $phoneNumber = $dataArr['phone number'];
            $gender = $dataArr['gender'];
            $hobby = $dataArr['hobby'];
            $message = $dataArr['message'];
            $userName = explode('@', $email)[0];
            $updatedAt = date("Y/m/d");

            if ($id) {
                $selectGradeID = $this->connection->query("SELECT id from grades where grade = '$grade'");
                $row = $selectGradeID->fetch_assoc();
                $gradeID = $row['id'];
                
                $updateUserData = $this->connection->query("UPDATE users set first_name = '$firstname', last_name = '$lastname', email = '$email', grade_id = $gradeID, phone_number = $phoneNumber, gender = '$gender', message = '$message', user_name = '$userName', updated_at = '$updatedAt' where id = $id");
                
                $deleteHobby = $this->connection->query("DELETE from hobbies where user_id = $id");
                $updateHobby = $this->connection->prepare("INSERT into hobbies (name, user_id) values(?, ?)");
                
                foreach($hobby as $value) {
                    $updateHobby->bind_param('si', $value, $id);
                    $updateHobby->execute();
                }

                if (strlen( $_FILES['profilePicture']['name'])) {
                    $selectImage = $this->connection->query("SELECT profile_picture from users where id = $id");
                    $result = $selectImage->fetch_assoc();
                    $userImage = $result['profile_picture'];
                    
                    if (file_exists('./../public/uploads/' . $userImage)) {
                        
                        $targetDir = './../public/uploads/';
                        $imageFileType = strtolower(pathinfo($_FILES['profilePicture']['name'],PATHINFO_EXTENSION));
                        $imgType = ["png", "jpg", "jpeg"];
                        $mimeType = mime_content_type($_FILES['profilePicture']['tmp_name']);
                        $allowMimetype = ['image/png', 'image/jpeg', 'image/jpg'];

                        if (! in_array($mimeType, $allowMimetype)) {
                            throw new Exception("Invalid image type", 400);
                        }

                        if (in_array($imageFileType, $imgType)) {
                            if (file_exists('./../pubic/uploads' . $userImage)) {
                                unlink('./../public/uploads/' . $userImage);
                                $imageName = time() . "." . $imageFileType;
                                move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetDir . $imageName);
                                $this->connection->query("UPDATE users set profile_picture = '$imageName' where id = $id");
                            }
                        } else {
                            throw new Exception("Invalid image type", 204);
                        }
                    }
                }
                $this->responseStatus = 200;
                $this->responseMessage = "User updated successfully";
                $_SESSION['status'] = $this->responseStatus;
            } else {
                throw new Exception ("User not found!", 404);
            }
        } catch (Exception $error) {
            $this->responseStatus = $error->getCode();
            $this->responseMessage = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: $this->responseStatus, error: $this->responseMessage, Line: " . $error->getLine() . PHP_EOL;
            file_put_contents('./../../errors.log', $errorMessage, FILE_APPEND);
        } finally {
            $response = [
                'status' => $this->responseStatus,
                'message' => $this->responseMessage
            ];
            return json_encode($response);
        }
    }
}
?>