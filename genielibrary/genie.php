<?php

class Genie
{
    protected $conn;
    public $fileName;
    public $fileTmpName;
    public $fileError;
    public $fileActualExt;
    protected $error = false;
    public $checked = false;

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

    protected function Error($err)
    {
        $this->error = $err;
        echo json_encode(["error" => $this->error]);
        exit();
    }

    function dbConnect($server, $user, $pass, $db)
    {
        try {
            $this->conn = new mysqli($server, $user, $pass, $db);
        } catch (Exception $err) {
            $this->Error("Connection failed. Please try later.");
        }
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
            $this->Error("Database connection failed.");
        }
    }

    function saveToDb($id, $method, $type, $prompt, $url)
    {
        // return;

        // Taking current time
        date_default_timezone_set("Asia/Karachi");
        $time = date("Y:m:d g:i a");

        try {
            $sql = "INSERT INTO `prompts` (`id`, `method`, `type`, `prompt`, `url/result`, `time`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $id, $method, $type, $prompt, $url, $time);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();
        } catch (Exception $err) {
            //deleting file
            unlink($url);
            $this->Error("Couldn't save file. Please try later.");
        }
    }

    function Check($img, $allowed)
    {
        //taking file properties
        $this->fileName = $img["name"];
        $this->fileTmpName = $img["tmp_name"]; //path of image
        $this->fileError = $img["error"];

        //we get an array for file name and extension
        $fileExt = explode(".", $this->fileName);

        //making it lower case and taking (last element) extension like .jpg
        $this->fileActualExt = strtolower(end($fileExt));

        //check if file has extension which is not allowed
        if (!in_array($this->fileActualExt, $allowed)) {
            $this->Error("Type not Supported.");
        }

        //check if there is any error in file uploaded
        if ($this->fileError !== 0) {
            $this->Error("Error occured. Please try later.");
        }

        return $this->checked = true;
    }

    function BypassCheck($img) {
        //taking file properties
        $this->fileName = $img["name"];
        $this->fileTmpName = $img["tmp_name"]; //path of image
        $this->fileError = $img["error"];

        //setting as check
        return $this->checked = true;
    }
}