<?php
/**
 * ejabberd package file
 * User: hervie
 * Date: 14/10/2018
 * Time: 4:02 PM
 */

namespace Ejabberd;

use Ejabberd\Handler;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JsonSerializable;
use Illuminate\Support\Facades\Log;

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

    /**
     * @param $room
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomOccupantsNumber($room)
    {
        return self::callApi('POST', 'get_room_occupants_number', $data = ['name' => $room, 'service' => $this->conference_domain], 'roomOccupantsNumber');
    }

    /**
     * @param $room
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomCreate($room)
    {
        return self::callApi('POST', 'create_room', $data = [ 'room' => $room, 'service' => $this->conference_domain, 'host' => $this->domain],'roomCreate');
    }

    /**
     * @param $room
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomDestroy($room)
    {
        return self::callApi('POST', 'destroy_room', $data = [ 'name' => $room, 'service' => $this->conference_domain], 'roomDestroy');
    }

    /**
     * @param $room
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomOptions($room)
    {
        return self::callApi('POST', 'get_room_options', $data = [ 'name' => $room, 'service' => $this->conference_domain] ,'roomOptions');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function usersConnectedNumber()
    {
        return self::callApi('GET', 'connected_users_number', '', 'usersConnectedNumber');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function usersConnectedInfo()
    {
        return self::callApi('GET', 'connected_users_info', '', 'usersConnectedInfo');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function usersConnected()
    {
        return self::callApi( 'GET', 'connected_users', '', 'usersConnected');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomsList()
    {
        return self::callApi('GET', 'muc_online_rooms?host='.$this->domain, '', 'roomsList');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomsDetails()
    {
        return self::callApi('POST', 'muc_online_rooms_by_regex', $data = ['host' => $this->domain], 'roomsDetails');
    }

    /**
     * @param $room
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function roomOccupants($room)
    {
        return self::callApi('POST', 'get_room_occupants', $data = ['name' => $room, 'service' => $this->conference_domain], 'roomOccupants');
    }

    /**
     * @param $username
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userAccountCheck($username)
    {
        return self::callApi('POST', 'check_account', $data = ['user' => $username, 'host' => $this->domain], 'userAccountCheck');
    }

    /**
     * @param $username
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userLastActivity($username)
    {
        return self::callApi('POST', 'get_last', $data = ['user' => $username, 'host' => $this->domain], 'userLastActivity');
    }

    /**
     * @param $username
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userSessionsInfo($username)
    {
        return self::callApi('POST', 'user_sessions_info', $data = ['user' => $username , 'host' => $this->domain], 'userSessionsInfo');
    }

    /**
     * @param $username
     * @param $password
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userRegisterOld($username, $password)
    {
        return self::callApi('GET', 'register?user='.$username.'&password='.$password.'&host='.$this->domain,'','userRegister');
    }

    /**
     * @param $username
     * @param $password
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userRegister($username, $password)
    {
        return self::callApi('POST', 'register', $data = ['user'=> $username, 'password'=>$password, 'host'=>$this->domain],'userRegister');
    }

    /**
     * @param $username
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userUnregister($username)
    {
        return self::callApi('POST', 'unregister', $data = ['user' => $username, 'host' => $this->domain],  'userUnegister');
    }

    /**
     * @param $username
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function userRooms($username)
    {
        return self::callApi('POST', 'get_user_rooms', $data = ['user' => $username, 'host' => $this->domain], 'userRooms');
    }

    /**
     * @return \Psr\Http\Message\StreamInterface|null
     */
    public function usersRegistered()
    {
        return self::callApi('POST', 'registered_users', $data = ['host' => $this->domain], 'usersRegistered');
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
                /*
                'auth' => [
                    $this->user, $this->password
                ],
                */
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
    public function callApi($method, $url, $data , $command)
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

            return \Ejabberd\Handler::regularResponse(json_decode($res->getBody(), JSON_PRETTY_PRINT));

        } catch (ClientException $e) {
            if ($this->debug=='true') {
               Log::info("Error occurred while executing the command " . $command . ", on url:".$url.".");
            }

            return \Ejabberd\Handler::noContentResponse(json_decode($e->getResponse()->getBody(true)));
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