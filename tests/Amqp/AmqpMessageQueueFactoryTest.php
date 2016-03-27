<?php

namespace Alchemy\Queue\Tests\Amqp;

use Alchemy\Queue\Amqp\AmqpConfiguration;
use Alchemy\Queue\Amqp\AmqpMessageQueueFactory;
use Alchemy\Queue\Message;
use Alchemy\Queue\MessageHandler;
use Alchemy\Queue\MessageHandlerResolver;
use Prophecy\Argument;

class AmqpMessageQueueFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AmqpConfiguration
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = AmqpConfiguration::parse([
            'host' => '127.0.0.1',
            'user' => '',
            'password' => ''
        ]);
    }

    public function testFactoryCanCreateQueue()
    {
        $that = $this;

        $handler = $this->prophesize(MessageHandler::class);
        $resolver = new MessageHandlerResolver();
        $factory = new AmqpMessageQueueFactory($this->configuration);

        $resolver->addHandler($handler->reveal());

        $actualBody = null;
        $actualCorrelationId = null;

        $handler->accepts(Argument::type(Message::class))->willReturn(true);
        $handler->handle(Argument::type(Message::class))->will(function ($args) use (&$actualBody, &$actualCorrelationId) {
            $actualBody = $args[0]->getBody();
            $actualCorrelationId = $args[0]->getCorrelationId();
        })->shouldBeCalled();

        $queue = $factory->getNamedQueue('mock-queue');
        $queue->publish(new Message('mock-message', 'mock-correlation-id'));

        $queue->handle($resolver);

        $that->assertEquals('mock-message', $actualBody);
        $that->assertEquals('mock-correlation-id', $actualCorrelationId);
    }
}
