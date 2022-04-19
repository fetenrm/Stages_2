<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[ApiResource(
    itemOperations: [
        'get',
        'post_publication' => [
            'method' => 'POST',
            'path' => '/formations/{id}',
            'controller' => FormationController::class,
            'deserialize'=> false
        ],
        'delete',
    ]
)]
class Formation
{
    #[ORM\Id]
    
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #Groups("affichable")
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #Groups("affichable")
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $contenu;

    #[ORM\ManyToOne(targetEntity: Domaine::class, inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private $domaine;

    #[ORM\ManyToOne(targetEntity: CentreFormation::class, inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private $centreFormation;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getCentreFormation(): ?CentreFormation
    {
        return $this->centreFormation;
    }

    public function setCentreFormation(?CentreFormation $centreFormation): self
    {
        $this->centreFormation = $centreFormation;

        return $this;
    }
}
