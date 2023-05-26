<?php

namespace App\Controller;

use App\Service\Rate\Interfaces\RateInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RateController extends AbstractController
{
    /**
     * @param RateInterface $rateService
     * @return JsonResponse
     */
    #[Route('/api/rate', name: 'app_rate', methods: ['GET'])]
    public function index(RateInterface $rateService): JsonResponse
    {
        try {
            $rate = $rateService->getPrice();
            return $this->json($rate->price);
        } catch (HttpExceptionInterface|TransportExceptionInterface|\InvalidArgumentException) {
            return $this->json('Invalid status value', Response::HTTP_BAD_REQUEST);
        }
    }
}
