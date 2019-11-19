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

    public function formations()
    {
        return $this->render('pro_stages/formations.html.twig');     
    }

    public function entreprises()
    {
        return $this->render('pro_stages/entreprises.html.twig');}

    public function stages($id)
    {
        return $this->render('pro_stages/stages.html.twig');}
}
