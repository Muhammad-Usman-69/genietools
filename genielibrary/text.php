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

        // Remove non-letter characters
        $onlyLetters = preg_replace("/[^a-zA-Z]/", "", $text);
        $letters = strlen($onlyLetters);

        $result = "Words: $words Letters: $letters";

        $id = "genietools-wordcounter-" . $this->random_str(8);

        return [
            "id" => $id,
            "text" => $result
        ];
    }
}