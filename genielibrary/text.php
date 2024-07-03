<?php

class Text extends Genie {
    function TextToMD5($text) {
        //creating id
        $id = "genie-texttomd5-" . $this->random_str(8);

        $md5 = md5($text);

        return [
            "id" => $id,
            "url" => $md5,
            "share_url" => ""
        ];
    }
}