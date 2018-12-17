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
                            'code' => 422,
                            'message' => 'Entry already exists or in wrong format.'
                        ]
                    ], 422);
                break;

            default:
                return response()->json(
                    [
                        'error' => [
                            'code' => 422,
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
                    'code' => 422,
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
                    'code' => 422,
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
                    'code' => 422,
                    'message' => "Username doesn't exist."
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
                    'code' => 422,
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
                    'code' => 422,
                    'message' => 'Room doesnt exist.'
                ]
            ], 422);
    }

}
