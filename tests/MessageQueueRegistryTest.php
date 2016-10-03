<?php

namespace Alchemy\Queue\Tests;

use Alchemy\Queue\MessageQueue;
use Alchemy\Queue\MessageQueueRegistry;

class MessageQueueRegistryTest extends \PHPUnit_Framework_TestCase
{

    public function testRegistryIsInitiallyEmpty()
    {
        $registry = new MessageQueueRegistry();

        $this->assertFalse($registry->hasQueue('named-queue'), 'Registry should not contain a queue named "named-queue"');
    }

    public function testQueuesCanBeRegisteredUsingConfigArray()
    {
        $registry = new MessageQueueRegistry();

        $registry->bindConfiguration('default-queue', []);

        $this->assertTrue($registry->hasQueue('default-queue'));
        $this->assertInstanceOf(MessageQueue::class, $registry->getQueue('default-queue'));
    }
}
