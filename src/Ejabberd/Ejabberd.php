<?php
/**
 * ejabberd package file
 * User: hervie
 * Date: 14/10/2018
 * Time: 4:02 PM
 */

namespace Ejabberd;

use Ejabberd\Commands\Contracts\IEjabberdCommand;
use Ejabberd\Commands\CreateUser;
use Ejabberd\Commands\SendMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JsonSerializable;
use Illuminate\Support\Facades\Log;
use Ejabberd\Handler;

class Ejabberd implements JsonSerializable
{

    private $api = '';
    private $user = '';
    private $password = '';
    private $domain = '';
    private $conference_domain = '';
    private $debug = '';


    public function __construct()
    {
        $this->api = env('EJABBERD_API');
        $this->user = env('EJABBERD_USER');
        $this->password = env('EJABBERD_PASSWORD');
        $this->domain = env('EJABBERD_DOMAIN');
        $this->conference_domain =  env('EJABBERD_CONFERENCE_DOMAIN');
        $this->debug = env('EJABBERD_DEBUG');

    }

    /**
     * @param IEjabberdCommand $command
     */
    public function executeQueue(IEjabberdCommand $command)
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
     * @param SendMessage $sendMessage
     * @return null|\Psr\Http\Message\StreamInterface
     */
    public function sendMessage(SendMessage $sendMessage)
    {
        return $this->execute($sendMessage);
    }


    public function usersConnectedNumber()
    {
        return self::callApi('GET', 'connected_users_number', '', 'usersConnectedNumber');
    }

    public function usersConnectedInfo()
    {
        return self::callApi('GET', 'connected_users_info', '', 'usersConnectedInfo');
    }

    public function usersConnected()
    {
        return self::callApi( 'GET', 'connected_users', '', 'usersConnected');
    }

    public function roomsList()
    {
        return self::callApi('GET', 'muc_online_rooms?host='.$this->domain, '', 'roomsList');
    }

    public function roomsDetails()
    {
        return self::callApi('GET', 'muc_online_rooms_by_regex?host='.$this->domain, '', 'roomsDetails');
    }

    public function roomOccupants($room)
    {
        return self::callApi('POST', 'get_room_occupants', ['name' => $room, 'service' => $this->conference_domain], 'roomOccupants');
    }

    public function roomOccupantsNumber($room)
    {
        return self::callApi('POST', 'get_room_occupants_number', ['name' => $room, 'service' => $this->conference_domain], 'roomOccupantsNumber');
    }

    /**
     * @param IEjabberdCommand $command
     * @return null|\Psr\Http\Message\StreamInterface
     */
    public function execute(IEjabberdCommand $command)
    {
        $client = new Client([
            'verify' => false,
            'base_uri' => $this->api
        ]);
        $command_name = $command->getCommandName();
        try {
            $response = $client->request('POST', $command_name, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'auth' => [
                    $this->user, $this->password
                ],
                'json' => $command->getCommandData()
            ]);
            if ($this->debug) {
                Log::info($command->getCommandName() . 'executed successfully.');
            }
            return $response->getBody();

        } catch (GuzzleException $e) {
            if ($this->debug) {
                Log::info("Error occurred while executing the command " . $command->getCommandName() . ".");
            }
            return null;
        } catch (\Exception $e) {
            if ($this->debug) {
                Log::info("Error occurred while executing the command " . $command->getCommandName() . ".");
            }
            return null;
        }
    }

    /**
     * @param IEjabberdCommand $command
     * @return null|\Psr\Http\Message\StreamInterface
     */
    public function callApi($method, $url, $data = false, $command)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->request($method, $this->api.$url, [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            return json_decode($res->getBody(), JSON_PRETTY_PRINT);

        } catch (ClientException $e) {
            if ($this->debug=='true') {
               Log::info("Error occurred while executing the command " . $command . " with data: '".$data."', on url: ".$url.".");
            }

            return \Ejabberd\Handler::response(json_decode($e->getResponse()->getBody(true)));

        } catch (\Exception $e) {
            if ($this->debug) {
               Log::info("Error occurred while executing the command " . $command . " with data: '".$data."', on url: ".$url.".");
            }
            return null;
        }
        
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