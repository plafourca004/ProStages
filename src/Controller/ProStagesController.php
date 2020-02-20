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

use App\Form\EntrepriseType;
use App\Form\StageType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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

    public function ajouterEntreprise(Request $requetteHttp, ObjectManager $manager)
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('pro_stages/ajouterEntreprise.html.twig', ['form' => $formulaireEntreprise->createView()]);
    }

    public function modifierEntreprise(Request $requetteHttp, ObjectManager $manager, Entreprise $entreprise)
    {
        
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('pro_stages/modifierEntreprise.html.twig', ['form' => $formulaireEntreprise->createView()]);
    }

    public function ajouterStage(Request $requetteHttp, ObjectManager $manager)
    {
        $stage = new Stage();

        $formulaireStage = $this->createForm(StageType::class, $stage);

        $formulaireStage->handleRequest($requetteHttp);

        if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
        {
            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('pro_stages/ajouterStage.html.twig', ['form' => $formulaireStage->createView()]);
    }
}
