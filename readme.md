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
This is a simple package for uploading files to Digital Ocean Spacen.  
It is shipped in two parts, this and the front end package [spaces-js](https://github.com/iamfredric/spaces-js) (```yarn add spaces```) 

### How do I use it?
```
composer require iamfredric/spaces
```

```php
use Iamfredric\Spaces\Spaces;

$spaces = new Spaces('config');

$spaces->sign('...args')->toArray();
```

### How do I use it with Laravel?
This one ships ready for Laravel. 

```
composer require iamfredric/spaces
```

```php
use Illuminate\Http\Request;
use Iamfredric\Spaces\Spaces;

class StorageController
{
    public function sign(Request $request, Spaces $spaces)
    {
        return $spaces->sign($request);
    }
}
```
### How can I contribute?
