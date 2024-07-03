<?php

require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class AI extends Genie
{
    function getVoices($apiKey)
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

    function TextToAudio($prompt, $voice, $apiKey)
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
            $audio_url = "../v1/audio/$fname";
            $share_url = "{$_SERVER["SERVER_NAME"]}/v1/audio/$fname";

            // Open a file in write mode ('w')
            $file = fopen($audio_url, 'w');

            // Write the stream to the file if body is still giving it data
            while (!$body->eof()) {
                fwrite($file, $body->read(1024)); // Reading 1024 bytes at a time
            }

            // Close the file
            fclose($file);

            return [
                "url" => $audio_url,
                "share_url" => $share_url,
                "id" => $id
            ];

        } catch (ClientException $e) {
            // Handle the request exception
            $this->Error("Server not responding, please try later.");
        }
    }
}