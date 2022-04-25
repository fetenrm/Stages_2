<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
#[ApiResource(
    itemOperations: [
        'get',
        'post_publication' => [
            'method' => 'POST',
            'path' => '/formations/{id}',
            'controller' => DemandeController::class,
            'deserialize'=> false
        ],
    ]
)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: OffreStage::class, inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $offreStage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $CV;

    #[ORM\ManyToOne(targetEntity: OffreEmploi::class, inversedBy: 'demandes')]
    private $offres_emploi;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffreStage(): ?OffreStage
    {
        return $this->offreStage;
    }

    public function setOffreStage(?OffreStage $offre): self
    {
        $this->offreStage = $offre;

        return $this;
    }

    public function getCV(): ?string
    {
        return $this->CV;
    }

    public function setCV(?string $CV): self
    {
        $this->CV = $CV;

        return $this;
    }

    public function getOffresEmploi(): ?OffreEmploi
    {
        return $this->offres_emploi;
    }

    public function setOffresEmploi(?OffreEmploi $offres_emploi): self
    {
        $this->offres_emploi = $offres_emploi;

        return $this;
    }

   
}
