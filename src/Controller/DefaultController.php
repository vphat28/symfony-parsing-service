<?php

// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $number = random_int(0, 5);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
