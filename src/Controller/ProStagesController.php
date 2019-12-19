<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\Entreprise;

class ProStagesController extends AbstractController
{
    public function index()
    {
        $repositeryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositeryStage->findAll();

        return $this->render('pro_stages/index.html.twig', ['stages' => $stages]); 
    }

    public function formations()
    {
        $repositeryFormations = $this->getDoctrine()->getRepository(Formation::class);
        $formations = $repositeryFormations->findAll();

        return $this->render('pro_stages/formations.html.twig', ['formations' => $formations]);   
    }

    public function entreprises()
    {
        $repositeryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
        $entreprises = $repositeryEntreprise->findAll();

        return $this->render('pro_stages/entreprises.html.twig', ['entreprises' => $entreprises]);
    }

    public function stages($id)
    {
        $repositeryStages = $this->getDoctrine()->getRepository(Stage::class);
        $stage = $repositeryStages->find($id);

        return $this->render('pro_stages/stages.html.twig', ['stage' => $stage]);
    }

    public function entreprise($id)
    {
        $repositeryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositeryStage->findAll();

        return $this->render('pro_stages/entreprise.html.twig', ['id' => $id , 'stages' => $stages]);
    }

    public function formation($id)
    {
        $repositeryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositeryStage->findAll();
        
        return $this->render('pro_stages/formation.html.twig', ['id' => $id , 'stages' => $stages]);
    }
}
