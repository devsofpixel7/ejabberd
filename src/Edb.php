<?php
/**
 * ejabberd package file
 * User: hervie
 * Date: 14/01/2019
 * Time: 1:19 PM
 */

namespace Ejabberd;

use Ejabberd\Handler;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JsonSerializable;
use Illuminate\Support\Facades\Log;

class Edb implements JsonSerializable
{

    private $api = '';
    private $user = '';
    private $password = '';
    private $domain = '';
    private $conference_domain = '';
    private $debug = '';


    public function __construct()
    {


    }

    /**
     * @param CreateUser $createUser
     * @return null|\Psr\Http\Message\StreamInterface
     */
    public function createUser(CreateUser $createUser)
    {
        return $this->execute($createUser);
    }




    /**
     * @param Object
     * @return null|\JsonSerializable
     */
    public function jsonSerialize() {
        return [
            'status', 'code' , 'message', 'num_sessions'
        ];
    }


}