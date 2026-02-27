<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExchangeController extends AbstractController
{
    #[Route('/exchange', name: 'exchange')]
    public function index(): Response
    {
        return $this->render('exchange/exchange.html.twig', [
            'controller_name' => 'ExchangeController',
        ]);
    }
}
