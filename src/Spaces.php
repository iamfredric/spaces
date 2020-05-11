<?php

namespace Iamfredric\Spaces;

use Aws\CommandInterface;
use Aws\S3\S3Client;
use Psr\Http\Message\RequestInterface;

class Spaces
{
    protected S3Client $client;

    protected string $bucket;

    public function __construct(S3Client $client, $bucket)
    {
        $this->client = $client;
        $this->bucket = $bucket;
    }

    public function sign(?string $contentType = null)
    {
        $signedRequest = $this->signRequest(
             $key = $this->generateKey($id = uniqid())
        );

        $uri = $signedRequest->getUri();

        return [
            'id' => $id,
            'bucket' => $this->bucket,
            'key' => $key,
            'url' => 'https://'.$uri->getHost().$uri->getPath().'?'.$uri->getQuery(),
            'headers' => array_merge($signedRequest->getHeaders(), [
                'Content-Type' => $contentType ?: 'application/octet-stream'
            ])
        ];
    }

    protected function createCommand(string $key) : CommandInterface
    {
        return $this->client->getCommand('putObject', array_filter([
            'Bucket' => $this->bucket,
            'Key' => $key
        ]));
    }

    protected function generateKey(string $id) : string
    {
        return "tmp/{$id}";
    }

    protected function signRequest($key) : RequestInterface
    {
        return $this->client->createPresignedRequest(
            $this->createCommand(
                $key
            ),
            '+5 minutes'
        );
    }
}
