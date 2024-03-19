<?php

class ApproveUser extends Connection
{
    private $status, $message, $id, $sendMail;

    public function __construct($id, $mail = new SendMail())
    {
        parent::__construct();
        $this->id = $id;
        $this->sendMail = $mail;
    }

    public function approveUser()
    {
        try {
            $userID = $this->id;
            $userEmail = $this->connection->query("SELECT email, first_name from users where id = $userID");
            if ($userEmail->num_rows) {
                $this->connection->query("UPDATE users set is_approved = 1, status = 'active' where id = $userID");
                $result = $userEmail->fetch_assoc();
                $email = $result['email'];
                $firstName = $result['first_name'];
                $sendMailFrom = 'vatliyaparth111@gmail.com';
                $sendMailTo = $email;
                $subject = 'Approved!';
                $body = "<h2>Hello $firstName!</h2>
                        <p>You are now approved!</p>
                        <a href='http://localhost/practice/userManagement/views/auth/login.php'>Login</a>";

                $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);
                $this->status = 200;
                $this->message = "User approved successfully!";
            } else {
                throw new Exception ("Invalid user!", 400);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: $this->status, error: $this->message, Line: " . $error->getLine() . PHP_EOL;
            $errorFile = fopen('./../errors.log', 'a');
            fwrite($errorFile, $errorMessage);
            fclose($errorFile);
        } finally {
            $response = [
                'status' => $this->status,
                'message' => $this->message
            ];
            header("content-type: application/json");
            return json_encode($response);
        }
    }
}

?>