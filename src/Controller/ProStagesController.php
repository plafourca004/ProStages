<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

class ProStagesController extends AbstractController
{
    public function index(StageRepository $repositeryStage)
    {
        $stages = $repositeryStage->findStageEntreprise();

        return $this->render('pro_stages/index.html.twig', ['stages' => $stages]); 
    }

    public function formations(FormationRepository $repositeryFormations)
    {
        $formations = $repositeryFormations->findAll();

        return $this->render('pro_stages/formations.html.twig', ['formations' => $formations]);   
    }

    public function entreprises(EntrepriseRepository $repositeryEntreprise)
    {
        $entreprises = $repositeryEntreprise->findAll();

        return $this->render('pro_stages/entreprises.html.twig', ['entreprises' => $entreprises]);
    }

    public function stages(Stage $stage)
    {
        return $this->render('pro_stages/stages.html.twig', ['stage' => $stage]);
    }

    public function entreprise(Entreprise $entreprise)
    {
        $repositeryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositeryStage->findByEntreprise($entreprise);

        return $this->render('pro_stages/entreprise.html.twig', ['stages' => $stages, 'entreprise' => $entreprise]);
    }

    public function formation(Formation $formation)
    {
        $repositeryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stages = $repositeryStage->findByFormation($formation);
        
        return $this->render('pro_stages/formation.html.twig', ['stages' => $stages, 'formation' => $formation]);
    }
}
