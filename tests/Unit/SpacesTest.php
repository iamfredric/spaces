<?php

namespace Iamfredric\Tests\Spaces\Unit;

use Iamfredric\Spaces\Spaces;
use PHPUnit\Framework\TestCase;

class SpacesTest extends TestCase
{
    /** @test */
    function it_creates_a_signed_upload_url_to_digital_ocean_spaces()
    {
        // Todo: mock guzzle

        $spaces = new Spaces($bucket = 'testbucket', $region = 'eu1', $key = 'TEST_KEY', $secret = 'VERY_SECRET');

        // Visibility
        // content_type
        // cache_control
        // Expires
        // Todo: Expect stuff
        $this->assertEquals([
//            'id' => $uuid,
//            'bucket' => $bucket,
//            'key' => $key,
//            'url' => 'https://'.$uri->getHost().$uri->getPath().'?'.$uri->getQuery(),
//            'headers' => $this->headers($request, $signedRequest),
        ], $spaces->sign($visibility = 'private', $contentType = 'application/octet-stream', $cacheControl = null, $expires = null)->toArray());
    }

    /** @test */
    function it_creates_a_signe_upload_url_to_aws()
    {
        // Todo
    }

    // Test validation
}