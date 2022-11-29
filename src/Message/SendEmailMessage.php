<?php

namespace App\Message;

final class SendEmailMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    private $recipient;

    public function __construct(string $recipient)
    {
        $this->recipient = $recipient;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }
}
