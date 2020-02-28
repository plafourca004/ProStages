<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        //CREATION D'UTILISATEURS DE TEST

        $paul = new User();
        $paul->setPrenom("Paul");
        $paul->setNom("Lafourcade");
        $paul->setUsername("Apolo");
        $paul->setEmail("paulwoow@gmail.com");
        $paul->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $paul->setPassword('$2y$10$lKpDyLexfIseqNX/q4xFber96zl2ryz2GLW9Xvo61QelE8sBqe9le');
        $manager->persist($paul);
        
        $louison = new User();
        $louison->setPrenom("Louison");
        $louison->setNom("Vincent");
        $louison->setUsername("Arkait53");
        $louison->setEmail("louison@gmail.com");
        $louison->setRoles(['ROLE_USER']);
        $louison->setPassword('$2y$10$QftqffqqAvUgYn2Npt6AB.X6gAG8k2PQXaHB6DFyLhHqF4AEhanRG');
        $manager->persist($louison);








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
            $entreprise->setActivite($faker->sentence($nbWords =10, $variableNbWords = true));
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
