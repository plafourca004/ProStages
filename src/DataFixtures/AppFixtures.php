<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $nbEntreprises = 5;
        $nbStagesParEntreprises = 5;


        // Formations 

        $formationINFO = new Formation();
        $formationINFO->setNom("Diplome Universitaire de Technologie d'informatique");
        $formationINFO->setAcronyme("DUT INFO");
        
        $formationLP = new Formation();
        $formationLP->setNom("License Professionnelle programmation avancée");
        $formationLP->setAcronyme("LP Prog Avancée");
        
        $formationTIC = new Formation();
        $formationTIC->setNom("Diplome Universitaire de Technologie des Technologies de l'Information et de la Communication");
        $formationTIC->setAcronyme("DUT TIC");

        $manager->persist($formationINFO);
        $manager->persist($formationLP);
        $manager->persist($formationTIC);

        $tabTypeFormation = array($formationINFO, $formationLP, $formationTIC);

        $faker = \Faker\Factory::create('fr_FR');
        

        $tabEntreprises = array();
        for ( $i = 0; $i < $nbEntreprises ; $i++ ) //Entreprise
        {
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setActivite($faker->sentence($nbWords =20, $variableNbWords = true));
            $entreprise->setAdresse($faker->address);

            $nomEntreprise = $faker->company;
            $siteWeb = strtolower($nomEntreprise);
            $siteWeb = str_replace(' ','_', $siteWeb);
            $siteWeb = str_replace('.','', $siteWeb);
            $siteWeb = str_replace(',','', $siteWeb);
            


            $entreprise->setLienSite($faker->regexify('http\:\/\/'.$entreprise->getNom().'\.'.$faker->tld)); //Creation du lien (Je devrais enlever les espaces et les points)
            
            array_push($tabEntreprises, $entreprise); // Ajout dans le tableau des entreprises

            $manager->persist($entreprise);
        }

        foreach($tabEntreprises as $entrep) // loop 5 fois par entreprises
        {
            for ( $i = 0; $i < $nbStagesParEntreprises ; $i++ )
            {
                $stage = new Stage();
                $stage->setTitre($faker->jobtitle());
                $stage->setDescMission($faker->sentence($nbWords =100, $variableNbWords = true));
                $stage->setMail($faker->companyEmail);
                
                $nb = $faker->numberBetween($min=0, $max=2);
                $stage->addFormation($tabTypeFormation[$nb]);    //En mettre plusieurs en idée d'amélioration (facile a faire mais pas trop le temps)
                $tabTypeFormation[$nb]->addStage($stage);

                $manager->persist($stage);
                $manager->persist($tabTypeFormation[$nb]);

                $stage->setIdEntreprise($entrep);
                $entrep->addStage($stage);
                
                $manager->persist($stage);
                $manager->persist($entrep);
            }
        }
        $manager->flush();
    }
}
