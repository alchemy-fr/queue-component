# queue-component

[![License](https://img.shields.io/packagist/l/alchemy/queue-component.svg?style=flat-square)](https://github.com/alchemy-fr/queue-component/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/alchemy/queue-component.svg?style=flat-square)](https://packagist.org/packages/alchemy/queue-component)
[![Travis](https://img.shields.io/travis/alchemy-fr/queue-component.svg?style=flat-square)](https://travis-ci.org/alchemy-fr/queue-component)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/alchemy-fr/queue-component.svg?style=flat-square)](https://scrutinizer-ci.com/g/alchemy-fr/queue-component/?branch=master)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/alchemy-fr/queue-component.svg?style=flat-square)](https://scrutinizer-ci.com/g/alchemy-fr/queue-component/)
[![Packagist](https://img.shields.io/packagist/dt/alchemy/queue-component.svg?style=flat-square)](https://packagist.org/packages/alchemy/queue-component/stats)

alchemy/queue-component is a library providing a minimalist publish/subscribe abstraction over AMQP

## Installation

The only supported installation method is via [Composer](https://getcomposer.org). Run the following command to require 
the package in your project:

```
composer require alchemy/queue-component
```

## Quickstart guide

```php
// Note: the following array contains all available parameters and their default values
// Every configuration key is optional, and its default value used when not defined in parameters
$configuration = Alchemy\Queue\Amqp\AmqpConfiguration::parse([
    'host' => 'localhost',
    'vhost' => '/',
    'port' => 5672,
    'user' => 'guest',
    'password' => 'guest',
    'exchange' => 'alchemy-exchange',
    'dead-letter-exchange' => 'alchemy-dead-exchange',
    'queue' => 'alchemy-queue'
]);
$factory = new Alchemy\Queue\Amqp\AmqpMessageQueueFactory($configuration);

// Publish a message
$factory->getNamedQueue('my-queue')->publish(new Message('message body', 'correlation-id'));

// Consume next message in queue
$handler = new Alchemy\Queue\NullMessageHandler();
$factory->getNamedQueue('my-queue')->handle($handler);
```
