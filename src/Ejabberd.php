<?php
/**
 * ejabberd package file
 * User: hervie
 * Date: 29/11/2018
 * Time: 4:02 PM
 */

namespace Ejabberd;

class Ejabberd
{

    // Method: POST, PUT, GET etc
    // Data: array("param" => "value") ==> index.php?param=value

    static function CallApi($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }


        // Optional Authentication if server requires one:
        /*
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        */

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        if (curl_error($curl)) {
            $response = curl_error($curl);
        }
        else
        {
            $response = response()->json(json_decode($result, JSON_UNESCAPED_SLASHES));
        }

        curl_close($curl);


        //return response()->json(json_decode($result, JSON_UNESCAPED_SLASHES));
        return $response;

        /*
        return response()->json(
            [
                'error' => [
                    'code' => $rendered->getStatusCode(),
                    'message' => $e->getMessage(),
                ]
            ],
            $rendered->getStatusCode());
            */

        /*
        return response()->json(
            [
                'result' => [
                    $result
                ]
            ]);
        */



    }

}