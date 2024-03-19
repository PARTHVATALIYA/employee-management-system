<?php

class Grade extends Connection
{
    protected $status, $message;

    function __construct()
    {
        parent::__construct();
    }

    function grade()
    {
        try {
            $gradeArr = [];
            $grade = $this->connection->query("SELECT grade from grades");
            if ($grade->num_rows) {
                while ($row = $grade->fetch_assoc()) {
                    array_push($gradeArr, $row);
                }
                $this->status = 200;
                $this->message = "Fetch grade successfully";
            } else {
                throw new Error("No grade found!", 204);
            }
        } catch (Exception $error) {
            $this->status = $error->getCode();
            $this->message = $error->getMessage();
            $errorMessage = "[ " . date("F j, Y, g:i a") . " ], file: " . basename($_SERVER['PHP_SELF']) . " Code: " . $this->status . ", error: " . $this->message . ", Line: " . $error->getLine() . PHP_EOL;
            $errorFile = fopen("./../../errors.log", 'a');
            fwrite($errorFile, $errorMessage);
            fclose($errorFile);
        } finally {
            $repsonseArr = [
                'status' => $this->status,
                'message' => $this->message
            ];
            $reponse = [
                'response' => $repsonseArr,
                'grades' => $gradeArr
            ];

            header("content-type: application/json");
            return json_encode($reponse);
        }
    }
}
?>