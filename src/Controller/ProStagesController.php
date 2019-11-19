<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProStagesController extends AbstractController
{
    public function index()
    {
        return $this->render('pro_stages/index.html.twig'); 
    }

    public function entreprises()
    {
        return new Response('<h1>Cette page affichera la liste des entreprises proposant un stage</h1>');
    }

    public function formations()
    {
        return new Response('<h1>Cette page affichera la liste des formations de l\'IUT</h1>');
    }

    public function stages($id)
    {
        return new Response('<h1>Cette page affichera le descriptif du stage ayant pour identifiant '.$id.'</h1>');
    }
}
