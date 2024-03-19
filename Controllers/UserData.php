<?php

class UserData extends Connection
{
    protected $status, $message;

    function __construct()
    {
        parent::__construct();
    }

    function userData($id = 0)
    {
        try {
            $userArr = [];
            if ($id) {
                $users = $this->connection->query("SELECT u.id, u.first_name, u.last_name, u.email, u.gender, u.phone_number, g.grade, u.message, h.name, u.profile_picture from users as u inner join grades as g on u.grade_id = g.id inner join hobbies as h on u.id = h.user_id where u.id = $id");
                if ($users->num_rows) {
                    while($row = $users->fetch_assoc()) {
                        array_push($userArr, $row);
                    }
                    $this->status = 200;
                    $this->message = "Fetch user successfully!";
                } else {
                    throw new Exception ("Invalid user id!", 400);
                }
            } else {
                $users = $this->connection->query("SELECT u.id, u.profile_picture, u.first_name, u.last_name, u.email, u.gender, u.phone_number, g.grade, h.name, u.status, u.is_verified, u.is_approved from users as u inner join grades as g on u.grade_id = g.id inner join hobbies as h on u.id = h.user_id order by created_at DESC");
                if ($users->num_rows) {
                    while($row = $users->fetch_assoc()) {
                        $row['userName'] = $row['first_name'] . " " . $row['last_name'];
                        $row = array_slice($row, 0, 2, true) + ['userName' => $row['userName']] + array_slice($row, 2, count($row) - 1, true);
                        $row['userName'] = ucfirst($row['userName']);
                        unset($row['first_name']);
                        unset($row['last_name']);
                        array_push($userArr, $row);
                    }
                    $this->status = 200;
                    $this->message = "Fetch all user successfully!";
                }
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: " . $this->status . ", error: " . $this->message . ", Line: " . $error->getLine() . PHP_EOL;
            $errorFile = fopen("./../../errors.log", 'a');
            fwrite($errorFile, $errorMessage);
            fclose($errorFile);
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];

            $responseArr = [
                'response' => $response,
                'users' => $userArr
            ];

            header("content-type: application/json");
            return json_encode($responseArr);
        }
    }
}
?>