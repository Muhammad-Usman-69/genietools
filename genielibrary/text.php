<?php

class Text extends Genie
{
    function TextToMD5($text)
    {
        //creating id
        $id = "genie-texttomd5-" . $this->random_str(8);

        $md5 = md5($text);

        return [
            "id" => $id,
            "text" => $md5
        ];
    }

    function CaseConvert($text, $type)
    {
        if ($type == "uppercase") {
            $result = strtoupper($text);
        } else if ($type == "lowercase") {
            $result = strtolower($text);
        } else if ($type == "capitalize") {
            $result = ucwords(strtolower($text));
        } else if ($type == "sentencecase") {
            $result = preg_replace_callback('/([.!?])\s*(\w)/', function ($matches) {
                return strtoupper($matches[1] . ' ' . $matches[2]);
            }, ucfirst(strtolower($text)));
        } else {
            $this->Error("Unknown Type");
        }

        $id = "genietools-caseconvertor-$type-" . $this->random_str(8);

        return [
            "id" => $id,
            "text" => $result
        ];
    }

    function WordCounter($text)
    {
        $words = str_word_count($text);

        //returning sentences based of regular expressions
        $sentences = preg_match_all('([^\.\!\?]+[\.\?\!]*)', $text);

        // Remove non-letter characters
        $onlyLetters = preg_replace("/[^a-zA-Z]/", "", $text);
        $letters = strlen($onlyLetters);

        $result = "Words: $words Letters: $letters Sentences: $sentences";

        $id = "genietools-wordcounter-" . $this->random_str(8);

        return [
            "id" => $id,
            "text" => $result
        ];
    }

    function RgbaToHex($red, $green, $blue, $alpha)
    {
        //check
        if ($red > 255 || $green > 255 || $blue > 255 || $alpha > 1 || $red < 0 || $green < 0 || $blue < 0 || $alpha < 0) {
            $this->Error("Not a valid rgba code");
        }

        try {
            //format must be like #000000 instead of #000 (excluding alpha)
            $red = str_pad(dechex($red), 2, "0", STR_PAD_LEFT);
            $green = str_pad(dechex($green), 2, "0", STR_PAD_LEFT);
            $blue = str_pad(dechex($blue), 2, "0", STR_PAD_LEFT);

            //if alpha is 1
            if ($alpha == 1) {
                $code = "#" . $red . $green . $blue;
            } else {
                $alpha = dechex($alpha * 256); //multiplying by 256 bcz it can't be converted to hex otherwise
                //converting
                $code = "#" . $red . $green . $blue . $alpha;
            }
        } catch (Exception $e) {
            $this->Error("There is an error with the color code provided.");
        }


        $id = "genietools-colorcodeconvertor-rgbatohex-" . $this->random_str(8);

        return [
            "id" => $id,
            "text" => $code
        ];
    }

    function HexToRgba($hex)
    {
        //checking
        if (!preg_match("/[0-9a-fA-F]+/i", $hex)) {
            $this->Error("Not a valid hex code");
        }

        //converting
        if (strlen($hex) == 3 || strlen($hex) == 6) {
            
            if (strlen($hex) == 3) {
                //if #fff format
                $arr = str_split($hex, 1);
            } else {
                //if #ffffff format
                $arr = str_split($hex, 2);
            }

            //looping and converting each
            foreach ($arr as $value) {
                $codes[] = hexdec($value);
            }

            $code = "rgba($codes[0] $codes[1] $codes[2])";

        } else if (strlen($hex) == 8 || strlen($hex) == 7) {
            //if #11123311 format
            $arr = str_split($hex, 2);

            //looping and converting each
            foreach ($arr as $value) {
                $codes[] = hexdec($value);
            }

            $code = "rgba($codes[0] $codes[1] $codes[2] ". round($codes[3] / 255, 2) . ")";

        } else {
            //not accepted
            $this->Error("Wrong format of hex. Must be in 3 (fff), 6 (ffffff) or 7-8 (ffffff80) digit format.");
        }

        $id = "genietools-colorcodeconvertor-hextorbga-" . $this->random_str(8);

        return [
            "id" => $id,
            "text" => $code
        ];
    }
}