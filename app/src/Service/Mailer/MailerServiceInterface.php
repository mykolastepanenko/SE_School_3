<?php

namespace App\Service\Mailer;

interface MailerServiceInterface
{
    public function send(string $to, string $subject, string $message): void;
    public function sendAll(array $emails, string $subject, string $message): void;
}