<?php

namespace Ejabberd;

class Exception
{
    /**
     * Render a database exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function queryException($response)
    {
        switch ($response) {

            case 23505:
                return response()->json(
                    [
                        'error' => [
                            'message' => 'Entry already exists or in wrong format.'
                        ]
                    ], 422);
                break;

            default:
                return response()->json(
                    [
                        'error' => [
                            'message' => 'Query error.'
                        ]
                    ], 422);
                break;
        }

    }
    
    /**
     * Render a database exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function validationException($response)
    {
        return response()->json(
            [
                'error' => [
                    'message' => $response
                ]
            ], 422);
    }

    /**
     * Render a user exists exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function usernameExistsException()
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Username already exists.'
                ]
            ], 422);
    }


    /**
     * Render a user doesn't exists exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function usernameDoesntExistsException()
    {
        return response()->json(
            [
                'error' => [
                    'message' => "Username doesn't exist."
                ]
            ], 422);
    }

    /**
     * Render a users mobile doesn't exists exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function userMobileDoesntExistsException($mobile)
    {
        return response()->json(
            [
                'error' => [
                    'message' => "RSW User mobile number ".$mobile." doesn't exist."
                ]
            ], 422);
    }

    /**
     * Render a room exists exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function roomExistsException()
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Room already exists.'
                ]
            ], 422);
    }

    /**
     * Render a room doesn't exists exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function roomDoesntExistException()
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Room doesnt exist.'
                ]
            ], 422);
    }

    /**
     * Render a room invite already exists exception response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function roomInviteExistsException($room, $mobile)
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Invite to room_id '.$room.' for mobile number '.$mobile.' already exists.'
                ]
            ], 422);
    }

    /**
     * Render wrong username or password.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public static function userWrongCredentials()
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Wrong login credentials.'
                ]
            ], 422);
    }

}
