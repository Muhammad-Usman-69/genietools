<?php

class Genie
{
    protected $error = false;

    public $checked = false;

    protected $conn;

    function random_str(
        $length,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyz'
    ) {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    protected function setError($err)
    {
        $this->error = $err;
    }

    function getError()
    {
        return $this->error;
    }

    function printError()
    {
        if ($this->error) {
            echo json_encode(["error" => $this->error]);
            exit();
        }
    }

    function dbConnect($server, $user, $pass, $db) {
        $this->conn = new mysqli($server, $user, $pass, $db);
    } 

    function getToolNames()
    {

        try {
            $sql = "SELECT * FROM `tools`";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $names[] = $row;
            }
            $stmt->close();
            $this->conn->close();
            return $names;
        } catch (Exception $err) {
            $this->setError("Database connection failed.");
            return;
        }
    }
}