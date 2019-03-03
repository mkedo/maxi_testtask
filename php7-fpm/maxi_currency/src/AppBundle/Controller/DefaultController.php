<?php

namespace AppBundle\Controller;

use MaxiTest\CurrencyBundle\Service\EuroExchangeRate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('rate.html.twig');
    }

    /**
     * @Route("/rates", name="rates")
     */
    public function getRatesAction(EuroExchangeRate $euroRate)
    {
        return $this->json([
            'EUR' => $euroRate->getRubles(),
        ]);
    }
}
