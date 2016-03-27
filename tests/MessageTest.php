<?php

namespace Alchemy\Queue\Tests;

use Alchemy\Queue\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    public function testMessageHasBody()
    {
        $message = new Message('mock-body');

        $this->assertEquals('mock-body', $message->getBody());
    }

    public function testMessageHasDefaultCorrelationId()
    {
        $message = new Message('mock-body');

        $this->assertNotEmpty($message->getCorrelationId(), 'Message should have default correlation ID');
    }

    public function testMessageCorrelationIdCanBeOverridden()
    {
        $message = new Message('mock-body', 'mock-correlation-id');

        $this->assertEquals('mock-correlation-id', $message->getCorrelationId());
    }
}
