<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Formation;
use App\Form\EntrepriseType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,['label' => 'Titre du stage'])
            ->add('descMission', TextareaType::class,['label' => 'Description de la mission du stage'])
            ->add('mail', EmailType::class,['label' => 'Email de contact pour le stage'])
            ->add('idEntreprise', EntrepriseType::class)
            ->add('formations',EntityType::class,
                                ['class' => Formation::class,
                                'label' => 'Le stage est proposé aux formations suivantes',
                                'choice_label' => 'nom',
                                'multiple' => true,
                                'expanded' => true])
            //->add('idEntreprise')
            //->add('formations')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
