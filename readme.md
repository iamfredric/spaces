# Spaces

### Table of contents 
1. Requirements
1. What is this
1. How do I use it?
1. Laravel integration 
1. Contributing

### Requirements
You will need to use php 7.4 or above. 
 
### What's this?
This is a simple package for uploading files to Digital Ocean Spaces or S3.  
It is shipped in two parts, this and the front end package [spaces-js](https://github.com/iamfredric/spaces-js) (```yarn add spaces```) 

### How do I use it?
```
composer require iamfredric/spaces
```

```php
use \Aws\S3\S3Client;
use Iamfredric\Spaces\Spaces;

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'ENTER_REGION',
    'endpoint' => 'ENTER_ENDPOINT',
    'credentials' => [
        'key'    => 'ENTER_KEY',
        'secret' => 'ENTER_SECRET',
    ],
]);

$spaces = new Spaces($s3, $bucket = 'bucket');

// You would want to return this response
$response = $spaces->sign();
```

### How do I use it with Laravel?
This one ships ready for Laravel. 

```
composer require iamfredric/spaces
```

The configurations is per default set to filesystems.disks.s3 if you want to use anyother configurations, define this in filesystem.spaces_key. 
The required params is region, endpoint, key, secret, and bucket

```php
use Illuminate\Http\Request;
use Iamfredric\Spaces\Spaces;

class StorageController
{
    public function sign(Spaces $spaces)
    {
        return response($spaces->sign(), 201);
    }
}
```

### How can I contribute?
