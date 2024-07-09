<?php

require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class AI extends Genie
{
    function getVoicesElevenLabs($apiKey)
    {
        try {
            // The ElevenLabs API endpoint to get supported languages
            $endpoint = 'https://api.elevenlabs.io/v1/voices';

            // Create a Guzzle HTTP client
            $client = new Client();

            // Send the GET request to the API endpoint
            $response = $client->request('GET', $endpoint, [
                'headers' => [
                    'xi-api-key' => $apiKey
                ],
            ]);

            // Get the response body
            $body = $response->getBody()->getContents();
            $arr = json_decode($body, true);

            //itterating through voices
            foreach ($arr as $voices) {
                foreach ($voices as $voice) {
                    //pushing to voice array
                    $voices_arr[] = [
                        "voice_id" => $voice["voice_id"],
                        "voice_name" => $voice["name"],
                        "voice_gender" => ucfirst($voice["labels"]["gender"]),
                        "voice_accent" => ucfirst($voice["labels"]["accent"])
                    ];
                }
            }

            header("Content-Type: JSON");

            return json_encode($voices_arr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } catch (Exception $e) {
            // Handle the request exception
            $this->Error("Server not responding, please try later.");
        }
    }

    function TextToAudioElevenLabs($prompt, $voice, $apiKey)
    {
        try {
            $client = new Client();

            $endpoint = "https://api.elevenlabs.io/v1/text-to-speech/" . $voice;

            //sending message
            $response = $client->post($endpoint, [
                'headers' => [
                    'xi-api-key' => "$apiKey",
                    'Accept' => 'application/audio',
                    'X-Api-Version' => 'v1',
                    "Content-Type: application/json",
                ],
                'json' => [
                    'text' => "$prompt",
                    'model_id' => 'eleven_multilingual_v2',
                    "voice_settings" => [
                        "stability" => 0.5,
                        "similarity_boost" => 0.5
                    ]
                ]
            ]);

            //getting data
            $body = $response->getBody();

            //creating id
            $id = "genie-texttoaudio-" . $this->random_str(8);

            $fname = $id . ".mp3";

            // Define the path where you want to save the audio file
            $destination = "../v1/audio/$fname";
            $share_url = "{$_SERVER["SERVER_NAME"]}/v1/audio/$fname";

            // Open a file in write mode ('w')
            $file = fopen($destination, 'w');

            // Write the stream to the file if body is still giving it data
            while (!$body->eof()) {
                fwrite($file, $body->read(1024)); // Reading 1024 bytes at a time
            }

            // Close the file
            fclose($file);

            return [
                "url" => $destination,
                "share_url" => $share_url,
                "id" => $id
            ];

        } catch (ClientException $e) {
            // Handle the request exception
            $this->Error("Server not responding, please try later.");
        }
    }

    function TextToImageLimeWire($prompt, $aspect_ratio, $apiKey)
    {
        try {
            $client = new Client();

            $endpoint = 'https://api.limewire.com/api/image/generation';

            //sending message
            $response = $client->post($endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json',
                    'X-Api-Version' => 'v1',
                    "Content-Type: application/json"
                ],
                'json' => [
                    'prompt' => "$prompt",
                    'aspect_ratio' => "$aspect_ratio"
                ]

            ]);

            //getting data
            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $status = $responseData["status"];

            //check if status is completed
            if ($status != "COMPLETED") {
                $this->Error("Request couldn't be finished");
            }


            //creating id
            $id = "genie-texttoimage-" . $this->random_str(8);

            //saving image
            $remote_url = $responseData["data"][0]["asset_url"];

            //getting extension
            $type = $responseData["data"][0]["type"];
            $typeArr = explode("/", $type);
            $file_ext = end($typeArr);

            $destination = "../v1/image/$id.$file_ext";

            file_put_contents($destination, file_get_contents($remote_url));

            $share_url = "{$_SERVER["SERVER_NAME"]}/v1/audio/$id.$file_ext";

            return [
                "url" => $destination,
                "share_url" => $share_url,
                "id" => $id
            ];

        } catch (ClientException $e) {
            // Handle the request exception
            $this->Error("Server not responding, please try later.");
        }
    }

    function RemoveBackground($apiKey)
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        try {
            $client = new Client();

            $endpoint = "https://api.remove.bg/v1.0/removebg";

            //sending message
            $response = $client->post($endpoint, [
                'headers' => [
                    'X-Api-Key' => "$apiKey"
                ],
                'multipart' => [
                    [
                        'name' => 'image_file',
                        'contents' => fopen($this->fileTmpName, "r")
                    ]
                ]
            ]);
        } catch (Exception $e) {
            echo print_r($e);
            $this->Error("Server not responding, please try later.");
        }

        //creating destination
        $id = "genietools-removebg-" . $this->random_str(8);
        $destination = "../v1/image/" . $id . ".png";
        $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".png";

        //saving file
        $fp = fopen($destination, "wb");
        fwrite($fp, $response->getBody());
        fclose($fp);

        return [
            "url" => $destination,
            "share_url" => $share_url,
            "id" => $id
        ];
    }

    function ImgTxtReaderEdenAI($apiKey)
    {
        //if not checked
        if ($this->checked == false) {
            $this->Error("Not Checked.");
        }

        $id = "genietools-imagetextreader-" . $this->random_str(8);

        $tempData = file_get_contents($this->fileTmpName);

        //creating temp path to send data
        $tempPath = "../v1/temp/$id." . $this->fileActualExt;
        $fp = fopen($tempPath, "w");
        fwrite($fp, $tempData);
        fclose($fp);

        $client = new Client();

        try {
            $endpoint = "https://api.edenai.run/v2/ocr/ocr";

            //sending message
            $response = $client->post($endpoint, [
                'headers' => [
                    'authorization' => "Bearer $apiKey"
                ],
                'multipart' => [
                    [
                        'name' => 'providers',
                        'contents' => 'google',
                    ],
                    [
                        'name' => 'file',
                        'contents' => fopen($tempPath, 'r'),
                    ],
                    [
                        'name' => 'language',
                        'contents' => 'en',
                    ]
                ],
            ]);

            //creating destination
            $destination = "../v1/text/" . $id . ".txt";
            $share_url = "{$_SERVER["SERVER_NAME"]}/v1/image/" . $id . ".txt";

            $body = json_decode($response->getBody());

            //deleting img
            unlink($tempPath);

            //to access stdClass
            $text = $body->{"google"}->{"text"};

            //saving file
            $fp = fopen($destination, "w");
            fwrite($fp, $text);
            fclose($fp);

            return [
                "url" => $destination,
                "share_url" => $share_url,
                "id" => $id
            ];
        } catch (Exception $e) {
            //deleting img
            unlink($tempPath);
            
            $this->Error("Server not responding, please try later.");
        }


    }
}