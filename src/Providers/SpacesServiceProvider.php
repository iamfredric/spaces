<?php

namespace Iamfredric\Spaces\Providers;

use Aws\S3\S3Client;
use Iamfredric\Spaces\Spaces;

class SpacesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Spaces::class, function ($app) {
            $config = config('filesystem.spaces_key', 'filesystems.disks.s3');

            return new Spaces(new S3Client([
                'version' => 'latest',
                'region'  => config("{$config}.region"),
                'endpoint' => config("{$config}.endpoint"),
                'credentials' => [
                    'key'    => config("{$config}.key"),
                    'secret' => config("{$config}.secret"),
                ]
            ]), config("{$config}.bucket"));
        });
    }
}