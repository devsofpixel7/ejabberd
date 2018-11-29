<?php
/**
 * ejabberd package config
 * User: hervie
 * Date: 29/11/2018
 * Time: 4:02 PM
 */
return [
    'api' => env('EJABBERD_API'),
    'domain' => env('EJABBERD_DOMAIN'),
    'conference_domain' => env('EJABBERD_CONFERENCE_DOMAIN'),
    'user' => env('EJABBERD_USER'),
    'password' => env('EJABBERD_PASSWORD'),
    'debug' => env('EJABBERD_DEBUG', true)
];