<?php

namespace Kgnfth\Tumblr\Auth;

use League\OAuth1\Client\Server\Tumblr as TumblrServer;

class OAuth
{
    protected $server;

    public function __construct($clientKey, $clientSecret, $callbackUri)
    {
        $this->server = new TumblrServer([
            'identifier' => $clientKey,
            'secret' => $clientSecret,
            'callback_uri' => $callbackUri,
        ]);
    }

    public function getTemporaryCredentials()
    {
        return $this->server->getTemporaryCredentials();
    }

    public function getAuthorizationUrl($temporaryCredentials)
    {
        return $this->server->getAuthorizationUrl($temporaryCredentials);
    }

    public function getTokenCredentials($temporaryCredentials, $temporaryIdentifier, $verifier)
    {
        return $this->server->getTokenCredentials($temporaryCredentials, $temporaryIdentifier, $verifier);
    }

    public function getServer()
    {
        return $this->server;
    }
}
