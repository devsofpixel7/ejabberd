<?php

namespace Ejabberd;

use Exception;

class Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function noContentResponse($response)
    {

        return response()->json(
            [
                'no_content' => [
                    'data' => $response,
                ]
            ]);

    }

    /**
     * Render a regular response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function regularResponse($response)
    {

        return response()->json(
            [
                    'data' => $response
            ]);

    }

    /**
     * Render an extended response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function extendedResponse($dbResponse, $ejResponse)
    {

        return response()->json(
            [
                    'data' => $dbResponse,
                    'meta' => $ejResponse
            ]);

    }


    /**
     * Render a database exception response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public static function queryExceptionResponse($response)
    {

        switch($response) {

            case 23505:
                return response()->json(
                [
                    'error' => [
                        'message' => 'Entry already exists.'
                    ]
                ], 422);
                break;


        }



    }

}
