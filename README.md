<p align="center">
    <img src="g4php.png"
         height="200" alt="ghasedak for php">
</p>

 
<p align="center"><sup><strong> Ghasedak sms webservice package for php. </strong></sup></p>

## install

The easiest way to install by using Composer:

```sh
composer require ghasedak/php:"dev-master"
```
 

## usage
 

You need a [Ghasedak](https://ghasedak.io) account. Register and get your API key.


Create an instance from `Ghasedak` class with your API key:

```javascript
require __DIR__ . '/vendor/autoload.php';

$api = new \Ghasedak\GhasedakApi( 'api_key');
```

Send some sms:

```javascript
$api->SendSimple( 
      "09xxxxxxxxx",
      "Hello World!"
 );
```

:)

## License

MIT
 
