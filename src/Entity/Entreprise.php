<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     * min = 4,
     * minMessage = "Le nom de l'entreprise doit faire au moins {{ limit }} caractères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     * message = "Cette valeur ne doit pas etre vide"
     * )
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Regex(
     * pattern = "# [0-9]{5} #",
     * message = "Il semble y avoir un problème avec le code postal"
     * )
     * @Assert\Regex(
     * pattern = "# rue | avenue | boulevard | impasse | allée | place | route | voie #",
     * message = "Le type de route/voie semble incorrect"
     * )
     * @Assert\Regex(
     * pattern = "#^[1-9][0-9]{,2}(bis)|( bis) #",
     * message = "Le numéro de rue semble incorrect"
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Url(
     * message = "Cette valeur n'est pas une URL valide"
     * )
     */
    private $lienSite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="idEntreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLienSite(): ?string
    {
        return $this->lienSite;
    }

    public function setLienSite(?string $lienSite): self
    {
        $this->lienSite = $lienSite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setIdEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getIdEntreprise() === $this) {
                $stage->setIdEntreprise(null);
            }
        }

        return $this;
    }

    public function __tostring()
    {
        return $this->getNom();
    }
}
