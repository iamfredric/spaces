<?php

namespace Iamfredric\Spaces;

use Aws\S3\S3Client;
use Psr\Http\Message\RequestInterface;

class Spaces
{
    protected string $bucket;

    protected string $region;

    protected string $key;

    protected string $secret;

    protected ?RequestInterface $request;

    protected ?string $id;

    protected string $contentType;

    protected ?string $uploadKey;

    public function __construct(string $bucket, string $region, string $key, string $secret)
    {
        $this->bucket = $bucket;
        $this->region = $region;
        $this->key = $key;
        $this->secret = $secret;
    }

    public function sign(string $visibility = 'private', string $contentType = 'application/octet-stream', ?string $cacheControl = null, ?int $expires = null)
    {
        $this->contentType = $contentType;
        $this->id = uniqid();

        $client = new S3Client([
            'region' => $this->region,
            'version' => 'latest',
            'signature_version' => 'v4',
        ]);

        $request = $client->getCommand('putObject', array_filter([
            'Bucket' => $this->bucket,
            'Key' => $this->key,
            'ACL' => $visibility,
            'ContentType' => $contentType,
            'CacheControl' => $cacheControl,
            'Expires' => $expires,
        ]));

        // Sign request
        $this->request = $client->createPresignedRequest(
            $this->createCommand($request, $client, $this->bucket, $this->uploadKey = ('tmp/' . $this->id)),
            '+5 minutes'
        );
    }

    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'bucket' => $this->bucket,
            'key' => $this->uploadKey,
            'url' => 'https://'.$this->request->getHost().$this->request->getPath().'?'.$this->request->getQuery(),
            'headers' => array_merge($this->request->getHeader(), [
                'content-type' => $this->contentType
            ])
        ];
    }
}