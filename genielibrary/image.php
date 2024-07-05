<?php

class Image extends Genie
{
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
        $id = "genietools-jpgtopng-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".png";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".png";

        //changing image
        $img = imagecreatefromjpeg($this->fileTmpName); //suppress error with @

        if ($img == false) {
            echo $this->fileTmpName;
            $this->Error("Invalid JPG file.");
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

    function WebpToPng()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating destination
        $id = "genietools-webptopng-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".png";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".png";

        //changing image
        $img = @imagecreatefromwebp($this->fileTmpName); //suppress error with @

        if ($img == false) {
            $this->Error("Invalid WEBP file.");
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

    function PngToWebp()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating destination
        $id = "genietools-pngtowebp-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".webp";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".webp";

        //changing image
        $img = @imagecreatefrompng($this->fileTmpName); //suppress error with @

        if ($img == false) {
            $this->Error("Invalid PNG file.");
        }

        $result = @imagewebp($img, $destination, 100); // 0 to 100 . Zero means no compression

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

    function JpgToWebp()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating destination
        $id = "genietools-jpgtowebp-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".webp";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".webp";

        //changing image
        $img = @imagecreatefromjpeg($this->fileTmpName); //suppress error with @

        if ($img == false) {
            $this->Error("Invalid JPG file.");
        }

        $result = @imagewebp($img, $destination, 100); // 0 to 100 . Zero means no compression

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

    function WebpToJpg()
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        //creating destination
        $id = "genietools-webptojpg-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".jpg";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".jpg";

        //changing image
        $img = @imagecreatefromwebp($this->fileTmpName); //suppress error with @


        if ($img === false) {
            $this->Error("Invalid WEBP file.");
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

            //check greator than 300000 character
            if (strlen($dataUri) > 300000) {
                $this->Error("Can't be converted to text. Image size is exceeded.");
            }
        } catch (Exception $e) {
            $this->Error("Internal error. Please try later.");
        }

        return [
            "id" => $id,
            "text" => $dataUri
        ];
    }
}