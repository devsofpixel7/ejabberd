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


    static function usersConnectedNumber()
    {
        return self::CallApi('GET', env('EJABBERD_API').'connected_users_number');
    }

    static function usersConnectedInfo()
    {
        return self::CallApi('GET', env('EJABBERD_API').'connected_users_info');
    }

    static function usersConnected()
    {
        return self::CallApi('GET', env('EJABBERD_API').'connected_users');
    }

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

        return $response;

    }

}