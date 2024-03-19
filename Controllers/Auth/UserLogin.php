<?php

session_start();
class UserLogin extends Connection
{
    protected $status, $message, $userType;

    function __construct()
    {
        parent::__construct();
    }
    function userLogin($id = 0)
    {
        try {
            $userArr = [];

            $dataArr = [
                'user name' => isset($_POST['userName']) ? $_POST['userName'] : NULL,
                'password' => isset($_POST['password']) ? $_POST['password'] : NULL,
            ];

            foreach ($dataArr as $key => $value) {
                if ($value == NULL) {
                    $flag = false;
                    throw new Exception($key . " is required", 400);
                }
            }
            $dataArr = sanitizeData($dataArr);
            $userName = $dataArr['user name'];
            $password = $dataArr['password'];
            $userPassword = $this->connection->query("SELECT password from users where email = '$userName' || user_name = '$userName'");
            
            if ($userPassword->num_rows) {
                $result = $userPassword->fetch_assoc();
                $userPassword = $result['password'];

                if (password_verify($password, $userPassword)) {
                    $user = $this->connection->query("SELECT status, is_verified, is_approved, role, created_at from users where (email = '$userName' || user_name = '$userName')");
                    
                    if ($user->num_rows) {
                        $row = $user->fetch_assoc();
                        $createdAt = date_create($row['created_at']);
                        $currentDate = date_create(date("Y/m/d"));
                        $dateDifference = date_diff($currentDate, $createdAt);
                        
                        if ((int)$dateDifference->format("%a") > (365*4)) {
                            $this->connection->query("UPDATE users set status = 'de-active' where email = '$userName' || user_name = '$userName'");
                        }
                        array_push($userArr, $row);
                        if ($row['status'] == 'active' && $row['is_verified'] && $row['is_approved'] ) {
                            $_SESSION['user'] = $userName;
                            setcookie("user", "$userName", time() + (86400 * 30), '/');
                        }
                        $this->status = 200;
                        $this->message = "Login successfully";
                    } else {
                        throw new Exception("Email or password invalid!", 204);
                    }
                } else {
                    throw new Exception ("Password not valid!", 204);
                }
            } else {
                throw new Exception ("Invalid user!", 204);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: " . $this->status . ", error: " . $this->message . ", Line: " . $error->getLine() . PHP_EOL;
            $errorFile = fopen("./../errors.log", 'a');
            fwrite($errorFile, $errorMessage);
            fclose($errorFile);
        } finally {
            $responseArr = [
                'status' => $this->status,
                'message' => $this->message
            ];

            $response = [
                'response' => $responseArr,
                'user' => $userArr,
            ];

            header("content-type: application/json");
            return json_encode($response);
        }
    }
}
?>