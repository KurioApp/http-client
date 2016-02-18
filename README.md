# http-client
A Service Provider to configure and register HTTP client

This library uses [Ivory HTTP](https://github.com/egeloen/ivory-http-adapter) as adapter in order to utilize [PSR-7 HTTP message spec](http://www.php-fig.org/psr/psr-7/).

## Installation
This library is using [Composer](https://getcomposer.org/) as dependency manager. Please install it first if you don't have any. Then add this to your `composer.json` file:

```json
{
    "require" : {
        "KurioApp/http-client" : "0.3.2"
    },
    "repositories" : [
        {
            "type" : "composer",
            "url" : "http://repo.kurio.co.id"
        }
    ]
}
```

Do `composer update` to install the library to your application

## Integration

Add this line to the providers array in your `config/app.php` file :

```php
    \Kurio\HttpClient\HttpServiceProvider::class
```

## Usage
There are 2 ways to use HTTP client, using Laravel's Container, or via Dependency Injection

### Laravel Container
To initiate HTTP Client anywhere in your project, simply use:

```php
$http = app('http'); // or
$http = app()->make('http');
```

The `$http` variable will contain a `HttpAdapterInterface` object that can be used to send requests. For the example on how to send HTTP requests, heads up to [Ivory usage documentation](https://github.com/egeloen/ivory-http-adapter/blob/master/doc/usage.md)

### Dependency Injection

You can also use dependency injection to use this library. Simply add a parameter in your Controllers/Jobs constructor which is type-hinted as `Ivory\HttpAdapter\HttpAdapterInterface` object.

```php
<?php
namespace App\Controllers;

use Ivory\HttpAdapter\HttpAdapterInterface;

class HomeController extends Controller
{
    protected $http;
    
    // Type-hint the HttpAdapterInterface to constructor
    public function __construct(HttpAdapterInterface $http)
    {
        $this->http = $http;
    }
    
    public function welcome()
    {
        // Example to make a GET request
        $response = $this->http->get('http://example.com');
        
        // the response will be a PSR-7 Response object
        return (string) $response->getBody();
    }
}
```
