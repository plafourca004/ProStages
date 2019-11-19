<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/pro/stages", name="pro_stages")
     */
    public function index()
    {
        return $this->render('pro_stages/index.html.twig', [
            'controller_name' => 'ProStagesController',
        ]);
    }
}
