<?php

namespace Kgnfth\Tumblr\Tests\Auth;

use Kgnfth\Tumblr\Auth\OAuth;
use League\OAuth1\Client\Credentials\TemporaryCredentials;
use League\OAuth1\Client\Server\Tumblr as TumblrServer;
use Mockery;
use PHPUnit\Framework\TestCase;

class OAuthTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetTemporaryCredentials()
    {
        $mockServer = Mockery::mock(TumblrServer::class);
        $mockTempCredentials = Mockery::mock(TemporaryCredentials::class);

        $mockServer->shouldReceive('getTemporaryCredentials')
            ->once()
            ->andReturn($mockTempCredentials);

        $oauth = new OAuth('client_key', 'client_secret', 'callback_uri');
        $reflection = new \ReflectionClass($oauth);
        $property = $reflection->getProperty('server');
        $property->setAccessible(true);
        $property->setValue($oauth, $mockServer);

        $temporaryCredentials = $oauth->getTemporaryCredentials();
        $this->assertInstanceOf(TemporaryCredentials::class, $temporaryCredentials);
    }
}
