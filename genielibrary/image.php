<?php

class Image extends Genie
{
    public $fileName;
    public $fileTmpName;
    public $fileError;
    public $fileActualExt;
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
        $this->fileActualExt = strtolower(end($fileExt));

        //check if file has extension which is not allowed
        if (!in_array($this->fileActualExt, $allowed)) {
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
        $id = "genietools-pngtojpg-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".jpg";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".jpg";

        //changing image
        $img = @imagecreatefrompng($this->fileTmpName); //suppress error with @


        if ($img === false) {
            $this->Error("Invalid PNG file.");
        }

        $result = imagejpeg($img, $destination, 100); //100 is quality. 0 means worst and compressed

        if ($result === false) {
            $this->Error("Image conversion failed.");
        }

        imagedestroy($img);

        return [
            "id" => $id,
            "url" => $destination,
            "share_url" => $share_url
        ];
    }

    function JpgToPng()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating destination
        $id = "genietools-pngtojpg-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".png";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".png";

        //changing image
        $img = @imagecreatefromjpeg($this->fileTmpName); //suppress error with @

        if ($img == false) {
            $this->Error("Invalid PNG file.");
        }

        $result = @imagepng($img, $destination, 0); // 0 to 9 . Zero means no compression

        if ($result == false) {
            unlink($destination);
            $this->Error("Image conversion failed.");
        }

        imagedestroy($img);

        return [
            "id" => $id,
            "url" => $destination,
            "share_url" => $share_url
        ];
    }
    function ImgToText()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating id
        $id = "genietools-imagetotext-" . $this->random_str(8);

        //converting to text
        try {
            $data = file_get_contents($this->fileTmpName);
            $dataUri = 'data:image/' . $this->fileActualExt . ';base64,' . base64_encode($data);
        } catch (Exception $e) {
            $this->Error("Internal error. Please try later.");
        }

        return [
            "id" => $id,
            "url" => $dataUri,
            "share_url" => ""
        ];
    }
}