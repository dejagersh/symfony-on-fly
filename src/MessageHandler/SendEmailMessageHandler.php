<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendEmailMessageHandler implements MessageHandlerInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(SendEmailMessage $message)
    {
        $this->logger->info('Sending email to ' . $message->getRecipient());
    }
}
