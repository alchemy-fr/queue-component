<?php

namespace Alchemy\Queue\Amqp;

class AmqpConfiguration
{

    public static function parse(array $parameters)
    {
        $configuration = new self();

        $configuration->host = isset($parameters['host']) ? $parameters['host'] : $configuration->host;
        $configuration->vhost = isset($parameters['vhost']) ? $parameters['vhost'] : $configuration->vhost;
        $configuration->port = isset($parameters['port']) ? $parameters['port'] : $configuration->port;
        $configuration->user = isset($parameters['user']) ? $parameters['user'] : $configuration->user;
        $configuration->password = isset($parameters['password']) ? $parameters['password'] : $configuration->password;
        $configuration->exchange = isset($parameters['exchange']) ? $parameters['exchange'] : $configuration->exchange;
        $configuration->deadLetterExchange = isset($parameters['dead-letter-exchange']) ?
            $parameters['dead-letter-exchange'] :
            $configuration->deadLetterExchange;
        $configuration->queue = isset($parameters['queue']) ? $parameters['queue'] : $configuration->queue;

        return $configuration;
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

