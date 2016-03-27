<?php

namespace Alchemy\Queue;

use Alchemy\Queue\Message;
use Alchemy\Queue\MessageHandler;
use Alchemy\Queue\MessageHandlingException;

class NullMessageHandler implements MessageHandler
{
    /**
     * @param Message $message
     * @return bool
     */
    public function accepts(Message $message)
    {
        return true;
    }

    /**
     * @param Message $message
     * @throws MessageHandlingException when the message cannot be processed
     */
    public function handle(Message $message)
    {
        return;
    }
}
