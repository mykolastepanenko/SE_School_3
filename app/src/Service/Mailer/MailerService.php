<?php

namespace App\Service\Mailer;

use App\Service\Validators\ValidatorInterface;
use InvalidArgumentException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService implements MailerServiceInterface
{
    public function __construct(
        protected MailerInterface    $mailer,
        protected string             $sender,
        protected ValidatorInterface $validator
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $to, string $subject, string $message): void
    {
        $this->validator->validate($to);
        $email = (new Email())
            ->from($this->sender)
            ->to($to)
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }

    public function sendAll(array $emails, string $subject, string $message): void
    {
        foreach ($emails as $email) {
            try {
                $this->send(
                    $email,
                    $subject,
                    $message
                );
            } catch (TransportExceptionInterface|InvalidArgumentException) {
                continue;
            }
        }
    }
}