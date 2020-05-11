<?php

namespace Iamfredric\Tests\Spaces\Unit;

use Aws\CommandInterface;
use Aws\S3\S3Client;
use Iamfredric\Spaces\Spaces;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class SpacesTest extends TestCase
{
    /** @test */
    function it_creates_a_signed_upload_url_to_digital_ocean_spaces()
    {
        $client = \Mockery::mock(S3Client::class);
        $commandInterface = \Mockery::mock(CommandInterface::class);
        $requestInterface = \Mockery::mock(RequestInterface::class);
        $uriInterface = \Mockery::mock(UriInterface::class);

        $client->shouldReceive('createPresignedRequest')->andReturn($requestInterface);
        $client->shouldReceive('getCommand')->andReturn($commandInterface);

        $requestInterface->shouldReceive('getUri')->andReturn($uriInterface);
        $uriInterface->shouldReceive('getHost')->andReturn('region.example.com/');
        $uriInterface->shouldReceive('getPath')->andReturn('the-path');
        $uriInterface->shouldReceive('getQuery')->andReturn('test=running&testcoverage=somewhat');
        $requestInterface->shouldReceive('getHeaders')->andReturn(['Authorization' => 'Bearer TOKEN']);

        $spaces = new Spaces($client, 'me-bucket');

        $array = $spaces->sign();

        $this->assertEquals('https://region.example.com/the-path?test=running&testcoverage=somewhat', $array['url']);
        $this->assertEquals([
            'Authorization' => 'Bearer TOKEN',
            'Content-Type' => 'application/octet-stream'
        ], $array['headers']);
    }
}
