<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController {
    /**
     * @Route("/lucky/number/{max}", name="app_lucky_number")
     */
    public function number($max) {
        $number = random_int(0, $max);
        $url = $this->generateUrl('app_lucky_number', ['max' => 10]);

        if($number == 3) {
            return new Response(
                '<html><body><h1>'.$url.'</h1>Lucky number: '.$number.'</body></html>'
            );
        }

        if($number == 2) {
            return $this->redirectToRoute('/nom');
        }

        if($number == 1) {
            return $this->redirect('https://www.google.com');
        }

        throw new \Exception('Something went wrong!');

        return $this->createNotFoundException('Aucune action.');

    }
}