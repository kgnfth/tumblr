<?php

namespace Kgnfth\Tumblr\Tests\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use Kgnfth\Tumblr\Api\Client;
use Kgnfth\Tumblr\Auth\OAuth;
use League\OAuth1\Client\Credentials\TokenCredentials;
use Mockery;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetUserInfo()
    {
        $mockHttpClient = Mockery::mock(HttpClient::class);
        $mockOAuth = Mockery::mock(OAuth::class);
        $mockTokenCredentials = new TokenCredentials();
        $mockTokenCredentials->setIdentifier('test_token');
        $mockTokenCredentials->setSecret('test_secret');

        $mockOAuth->shouldReceive('getServer->getHeaders')
            ->andReturn(['Authorization' => 'OAuth Header']);

        $mockResponse = new Response(200, [], json_encode(['response' => 'test']));
        $mockHttpClient->shouldReceive('request')
            ->once()
            ->with('GET', 'https://api.tumblr.com/v2/user/info', Mockery::on(function ($arg) {
                return $arg['headers']['Authorization'] === 'OAuth Header';
            }))
            ->andReturn($mockResponse);

        $client = new Client($mockOAuth, $mockHttpClient);
        $result = $client->getUserInfo($mockTokenCredentials);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('response', $result);
    }

    public function testGetDashboardPosts()
    {
        $mockHttpClient = Mockery::mock(HttpClient::class);
        $mockOAuth = Mockery::mock(OAuth::class);
        $mockTokenCredentials = new TokenCredentials();
        $mockTokenCredentials->setIdentifier('test_token');
        $mockTokenCredentials->setSecret('test_secret');

        $mockOAuth->shouldReceive('getServer->getHeaders')
            ->andReturn(['Authorization' => 'OAuth Header']);

        $mockResponse = new Response(200, [], json_encode(['response' => 'test']));
        $mockHttpClient->shouldReceive('request')
            ->once()
            ->with('GET', 'https://api.tumblr.com/v2/user/dashboard', Mockery::on(function ($arg) {
                return $arg['headers']['Authorization'] === 'OAuth Header';
            }))
            ->andReturn($mockResponse);

        $client = new Client($mockOAuth, $mockHttpClient);
        $result = $client->getDashboardPosts($mockTokenCredentials, ['limit' => 10]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('response', $result);
    }
}
