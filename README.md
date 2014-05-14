# Helthe Mandrill [![Build Status](https://travis-ci.org/helthe/Mandrill.png?branch=master)](https://travis-ci.org/helthe/Mandrill) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/helthe/Mandrill/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/helthe/Mandrill/?branch=master)

Helthe Mandrill is a client library for interacting with the [Mandrill](http://www.mandrill.com) API.
It is currently designed to be a drop in alternative for sending emails with Mandrill. Features
will be added over time to be closer to the official client library.
However, for a feature complete client, you should use the official Mandrill
[client library](https://bitbucket.org/mailchimp/mandrill-api-php).

## Installation

### Using Composer

#### Manually

Add the following in your `composer.json`:

```json
{
    "require": {
        // ...
        "helthe/mandrill": "dev-master"
    }
}
```

#### Using the command line

```bash
$ composer require 'helthe/mandrill=dev-master'
```

## Usage

### Client

The Mandrill client uses a [Guzzle](https://github.com/guzzle/guzzle) client for interacting
with the Mandrill API and the Symfony [Serializer](https://github.com/symfony/serializer) for
serializing the data. The serializer is expected to have [CustomNormalizer](http://api.symfony.com/master/Symfony/Component/Serializer/Normalizer/CustomNormalizer.html)
and the [JsonEncoder](http://api.symfony.com/master/Symfony/Component/Serializer/Encoder/JsonEncoder.html).


```php
use GuzzleHttp\Client as GuzzleClient;
use Helthe\Component\Mandrill\Client;
use Helthe\Component\Mandrill\Message\Message;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Serializer.

// GuzzleHttp\ClientInterface
$guzzle = new GuzzleClient();
// Symfony\Component\Serializer\SerializerInterface
$serializer = new Serializer(array(new CustomNormalizer()), array(new JsonEncoder()));

$client = new Client($guzzle, $serializer, 'your_api_key');

$client->sendMessage(new Message('recipient@email.com', 'sender@email.com');
```

### Mailer

The mailer classes are design to hide internal workings of the library and offer a standard
interface for sending messages. The package offers to mailer classes for you to use.

#### Mailer

The `Mailer` class is used when you want to send regular text/HTML messages.

#### TemplatingEngineMailer

The `TemplatingEngineMailer` class is used when you want to render your message
content with using a templating engine implementing  the `EngineInterface`from
the Symfony [Templating](https://github.com/symfony/templating) Component.

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/helthe/Mandrill/issues/new).
