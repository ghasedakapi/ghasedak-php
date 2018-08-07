<p align="center">
    <img src="media/g4n.png"
         height="200" alt="ghasedak for php">
</p>

 
<p align="center"><sup><strong> Ghasedak sms webservice package for php. </strong></sup></p>

## install

You can simply install and use ghasedak php library from composer:

```sh
composer require ghasedak/php
```
 

## usage

Import `ghasedak` package:

```javascript
require  __DIR__ . '/vendor/autoload.php';
```

You need a [Ghasedak](https://ghasedakapi.com) account. Register and get your API key.

Create an instance from `Ghasedak` class with your API key:

```javascript
$api = new \Ghasedak\GhasedakApi( "API Key" );
```

Send some sms:

```javascript
api.SendSimple( 
	  "09xxxxxxxxx",
      "Hello World!"
 );
```

:)

##
 
