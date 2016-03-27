<?php

namespace Alchemy\Queue\Amqp;

class AmqpConfiguration
{

    public static function parse(array $parameters)
    {
        $configuration = new self();

        $configuration->host = self::extractValueOrDefault($parameters, 'host', $configuration->host);
        $configuration->vhost = self::extractValueOrDefault($parameters, 'vhost', $configuration->vhost);
        $configuration->port = self::extractValueOrDefault($parameters, 'port', $configuration->port);
        $configuration->user = self::extractValueOrDefault($parameters, 'user', $configuration->user);
        $configuration->password = self::extractValueOrDefault($parameters, 'password', $configuration->password);
        $configuration->exchange = self::extractValueOrDefault($parameters, 'exchange', $configuration->exchange);

        $configuration->deadLetterExchange = self::extractValueOrDefault(
            $parameters,
            'dead-letter-exchange',
            $configuration->deadLetterExchange
        );

        $configuration->queue = self::extractValueOrDefault($parameters, 'queue', $configuration->queue);

        return $configuration;
    }

    private static function extractValueOrDefault(array $parameters, $key, $default = null)
    {
        return isset($parameters[$key]) ? $parameters[$key] : $default;
    }

    private $host = 'localhost';

    private $vhost = '/';

    private $port = 5672;

    private $user = 'guest';

    private $password = 'guest';

    private $deadLetterExchange = 'alchemy-dead-exchange';

    private $exchange = 'alchemy-exchange';

    private $queue = 'alchemy-queue';

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getVhost()
    {
        return $this->vhost;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDeadLetterExchange()
    {
        return $this->deadLetterExchange;
    }

    /**
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @return string
     */
    public function getQueue()
    {
        return $this->queue;
    }

    public function toConnectionArray()
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'vhost' => $this->vhost,
            'login' => $this->user,
            'password' => $this->password
        ];
    }
}

