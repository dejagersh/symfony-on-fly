<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendEmailMessageHandler implements MessageHandlerInterface
{
    public function __invoke(SendEmailMessage $message)
    {
        // do something with your message
    }
}
