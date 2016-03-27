<?php

namespace Alchemy\Queue\Amqp;

use Alchemy\Queue\MessageQueue;
use Alchemy\Queue\MessageQueueFactory;

class AmqpMessageQueueFactory implements MessageQueueFactory
{
    /**
     * @var AmqpConfiguration
     */
    private $configuration;

    /**
     * @var \AMQPExchange
     */
    private $exchange;

    /**
     * @var \AMQPConnection
     */
    private $connection;

    /**
     * @var \AMQPChannel
     */
    private $channel;

    public function __construct(AmqpConfiguration $configuration = null)
    {
        $this->configuration = $configuration ?: new AmqpConfiguration();
    }

    /**
     * @param $name
     * @return MessageQueue
     */
    public function getNamedQueue($name)
    {
        $exchange = $this->declareExchange();

        return $this->buildQueue($exchange, $name, $this->configuration->getDeadLetterExchange());
    }

    /**
     * @param \AMQPExchange $exchange
     * @param $queueName
     * @param string $errorExchangeName
     * @return \AMQPQueue
     */
    private function buildQueue(\AMQPExchange $exchange, $queueName, $errorExchangeName = '')
    {
        $queue = new \AMQPQueue($exchange->getChannel());
        $queue->setName($queueName);
        $queue->setFlags(AMQP_DURABLE);

        if (trim($errorExchangeName) != '') {
            $queue->setArgument('x-dead-letter-exchange', $errorExchangeName);
        }

        $queue->declareQueue();
        $queue->bind($exchange->getName(), $queueName);

        return new AmqpMessageQueue($exchange, $queue);
    }

    protected function declareExchange()
    {
        if ($this->exchange == null) {
            $this->exchange = new \AMQPExchange($this->getChannel());

            $this->exchange->setFlags(AMQP_DURABLE);

            if ($this->configuration->getExchange() != null) {
                $this->exchange->setType(AMQP_EX_TYPE_DIRECT);
                $this->exchange->setName($this->configuration->getExchange());
                $this->exchange->declareExchange();
            }
        }

        return $this->exchange;
    }


    /**
     * @return \AMQPConnection
     */
    public function getConnection()
    {
        if ($this->connection == null) {
            $this->connection = new \AMQPConnection($this->configuration->toConnectionArray());
            $this->connection->connect();
        }

        return $this->connection;
    }

    /**
     * @return \AMQPChannel
     */
    public function getChannel()
    {
        if ($this->channel == null) {
            $this->channel = new \AMQPChannel($this->getConnection());
        }

        return $this->channel;
    }
}
