<?php

class ImgToImg extends Genie
{
    public $fileName;
    public $fileTmpName;
    public $fileError;
    protected $error = false;
    public $checked = false;

    function Check($img, $allowed)
    {
        //taking file properties
        $this->fileName = $img["name"];
        $this->fileTmpName = $img["tmp_name"]; //path of image
        $this->fileError = $img["error"];

        //we get an array for file name and extension
        $fileExt = explode(".", $this->fileName);

        //making it lower case and taking (last element) extension like .jpg
        $fileActualExt = strtolower(end($fileExt));

        //check if file has extension which is not allowed
        if (!in_array($fileActualExt, $allowed)) {
            $this->setError("Type not Supported.");
        }

        //check if there is any error in file uploaded
        if ($this->fileError !== 0) {
            $this->setError("Error occured. Please try later.");
        }

        $this->checked = true;
    }

    function PngToJpg()
    {
        //if not checked
        if ($this->checked == false) {
            $this->setError("Not Checked.");
            return;
        }

        //creating destination
        $name = "genietools-pngtojpg-" . $this->random_str(8);
        $destination = "../v1/images/" . $name . ".jpg";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/images/" . $name . ".jpg";

        //changing image
        $img = imagecreatefrompng($this->fileTmpName);
        $result = imagejpeg($img, $destination, 100);

        if ($result == false) {
            $this->setError("Image conversion failed.");
            return;
        }

        imagedestroy($img);

        return [
            "id" => $name,
            "image_url" => $destination,
            "share_url" => $share_url
        ];
    }

    function saveToDb($id, $method, $type, $prompt, $url)
    {

        // Taking current time
        date_default_timezone_set("Asia/Karachi");
        $time = date("Y:m:d g:i a");

        try {
            $sql = "INSERT INTO `prompts` (`id`, `method`, `type`, `prompt`, `url`, `time`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $id, $method, $type, $prompt, $url, $time);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();
        } catch (Exception $err) {
            $this->setError("Database connection failed.");
            //deleting file
            unlink($url);
            return;
        }
    }
}