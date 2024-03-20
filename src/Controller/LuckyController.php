<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {        
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Sussy Number: '.$number.'</body></html>'
        );
    }
}