<?php

namespace Kgnfth\Tumblr\Api;

use GuzzleHttp\Client as HttpClient;
use Kgnfth\Tumblr\Auth\OAuth;
use League\OAuth1\Client\Credentials\TokenCredentials;

class Client
{
    protected $httpClient;

    protected $oauth;

    public function __construct(OAuth $oauth, ?HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new HttpClient(['base_uri' => 'https://api.tumblr.com/']);
        $this->oauth = $oauth;
    }

    public function getUserInfo(TokenCredentials $tokenCredentials)
    {
        return $this->getRequest('v2/user/info', null, $tokenCredentials);
    }

    public function getDashboardPosts(TokenCredentials $tokenCredentials, $options = null)
    {
        return $this->getRequest('v2/user/dashboard', $options, $tokenCredentials);
    }

    protected function getRequest($uri, $options, TokenCredentials $tokenCredentials)
    {
        $url = 'https://api.tumblr.com/'.$uri;
        $method = 'GET';

        $headers = $this->oauth->getServer()->getHeaders($tokenCredentials, $method, $url);
        $response = $this->httpClient->request($method, $url, [
            'headers' => $headers,
            'query' => $options,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
