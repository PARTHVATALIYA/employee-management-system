<?php

class SendNotification extends Connection
{
    private $status, $message, $sendMail;

    public function __construct($mail = new SendMail())
    {
        parent::__construct();
        $this->sendMail = $mail;
    }

    public function sendNotification()
    {
        try {
            $subject = $_POST['subject'];
            $recipient = $_POST['recipient'];
            $description = $_POST['description'];

            $usersMailArr = explode(",", $recipient);
            $lengthOfUserMailArr = count($usersMailArr);

            if ($lengthOfUserMailArr > 5) {
                throw new Exception ("Maximum number of recipint selected is 5", 204);
            } else {
                $insertNotification = $this->connection->prepare("INSERT into notifications (subject, recipient, description) values (?, ?, ?)");
                $insertNotification->bind_param("sss", $subject, $recipient, $description);
                if ($insertNotification->execute()) {
                    $selectAdminMail = $this->connection->query("SELECT email from users where id = 1");
                    $result = $selectAdminMail->fetch_assoc();
                    $adminEmail = $result['email'];
                    $sendMailFrom = $adminEmail;
                    $subject = $subject;
                    $body = $description;
                    
                    for ($i = 0; $i < $lengthOfUserMailArr - 1; $i++ ) {
                        $sendMailTo = $usersMailArr[$i];
                        $this->sendMail->sendMail($sendMailFrom, $sendMailTo, $subject, $body);
                    }
                    
                    $this->status = 200;
                    $this->message = "Send mail successfully!";
                    
                } else {
                    throw new Exception ("Notification is not send!", 204);
                }
            }

        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: " . $this->status . ", error: " .$this->message . ", Line: " . $error->getLine() . PHP_EOL;
            $errorFile = fopen('./../errors.log', 'a');
            fwrite($errorFile, $errorMessage);
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