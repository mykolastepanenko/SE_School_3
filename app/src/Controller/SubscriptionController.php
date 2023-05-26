<?php

namespace App\Controller;

use App\Exceptions\NonUniqueData;
use App\Repository\Repository;
use App\Service\Handlers\SubscribeHandler;
use App\Service\Mailer\MailerServiceInterface;
use App\Service\Rate\Enums\BaseCurrency;
use App\Service\Rate\Enums\QuoteCurrency;
use App\Service\Rate\Interfaces\RateInterface;
use App\Service\Validators\ValidatorInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/api/subscribe', name: 'app_subscribe', methods: ['POST'])]
    public function subscribe(
        Request $request,
        SubscribeHandler $subscribeHandler,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $email = $request->request->get('email');

        try {
            $validator->validate($email);
            $subscribeHandler->handle($email);
            return $this->json('E-mail додано');
        } catch (NonUniqueData|InvalidArgumentException $e) {
            return $this->json($e->getMessage(), Response::HTTP_CONFLICT);
        }
    }

    #[Route('/api/sendEmails', name: 'app_send_emails', methods: ['POST'])]
    public function sendEmails(
        MailerServiceInterface $mailerService,
        Repository             $repository,
        RateInterface          $rateService,
        BaseCurrency           $base,
        QuoteCurrency          $quote
    ): JsonResponse
    {
        $emails = $repository->all();
        $rate = $rateService->getPrice();
        $subject = "{$base->value} price in {$quote->value}. Author: Nikolaua36@gmail.com";
        $message = "1 {$base->value} = {$rate->price} {$quote->value}";
        $mailerService->sendAll($emails, $subject, $message);
        return $this->json('E-mailʼи відправлено');
    }
}
