<?php

namespace Alchemy\Queue\Amqp;

use Alchemy\Queue\Message;
use Alchemy\Queue\MessageHandlerResolver;
use Alchemy\Queue\MessageHandlingException;
use Alchemy\Queue\MessagePublishingException;
use Alchemy\Queue\MessageQueue;

class AmqpMessageQueue implements MessageQueue
{
    /**
     * @var \AMQPExchange
     */
    private $exchange;

    /**
     * @var \AMQPQueue
     */
    private $queue;

    public function __construct(\AMQPExchange $exchange, \AMQPQueue $queue)
    {
        $this->exchange = $exchange;
        $this->queue = $queue;
    }

    /**
     * @param Message $message
     */
    public function publish(Message $message)
    {
        $attributes = ['correlation_id' => $message->getCorrelationId()];
        $result = $this->exchange->publish($message->getBody(), $this->queue->getName(), AMQP_DURABLE, $attributes);

        if (! $result) {
            throw new MessagePublishingException();
        }
    }

    /**
     * @param MessageHandlerResolver $resolver
     */
    public function handle(MessageHandlerResolver $resolver)
    {
        $this->queue->consume(function (\AMQPEnvelope $envelope) use ($resolver) {
            $message = new Message($envelope->getBody(), $envelope->getCorrelationId());
            $handler = $resolver->resolveHandler($message);

            try {
                $handler->handle($message);
                $this->ackMessage($envelope);
            } catch (MessageHandlingException $exception) {
                $this->nackMessage($envelope);
            }

            return false;
        }, AMQP_NOPARAM);
    }

    private function ackMessage(\AMQPEnvelope $envelope)
    {
        $this->queue->ack($envelope->getDeliveryTag(), AMQP_NOPARAM);
    }

    private function nackMessage(\AMQPEnvelope $envelope)
    {
        $this->queue->nack($envelope->getDeliveryTag(), AMQP_NOPARAM);
    }
}
