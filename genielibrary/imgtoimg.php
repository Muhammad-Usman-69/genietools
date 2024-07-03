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
            $this->Error("Type not Supported.");
        }

        //check if there is any error in file uploaded
        if ($this->fileError !== 0) {
            $this->Error("Error occured. Please try later.");
        }

        $this->checked = true;
    }

    function PngToJpg()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating destination
        $name = "genietools-pngtojpg-" . $this->random_str(8);
        $destination = "../v1/image/" . $name . ".jpg";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $name . ".jpg";

        //changing image
        $img = @imagecreatefrompng($this->fileTmpName); //suppress error with @


        if ($img === false) {
            $this->Error("Invalid PNG file.");
        }

        $result = imagejpeg($img, $destination, 100);

        if ($result === false) {
            $this->Error("Image conversion failed.");
        }

        imagedestroy($img);

        return [
            "id" => $name,
            "url" => $destination,
            "share_url" => $share_url
        ];
    }
}