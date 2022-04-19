<?php

namespace App\Entity;

use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: SocieteRepository::class)]
#[ApiResource]
class Societe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\ManyToOne(targetEntity: Domaine::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $domaine;

    #[ORM\OneToMany(mappedBy: 'societe', targetEntity: OffreStage::class, orphanRemoval: true)]
    private $offres_stage;

    #[ORM\ManyToOne(targetEntity: OffreEmploi::class, inversedBy: 'societes')]
    private $offre_emploi;

    public function __construct()
    {
        $this->offres_stage = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    /**
     * @return Collection|OffreStage[]
     */
    public function getOffresStage(): Collection
    {
        return $this->offres_stage;
    }

    public function addOffre(OffreStage $offre): self
    {
        if (!$this->offres_stage->contains($offre)) {
            $this->offres_stage[] = $offre;
            $offre->setSociete($this);
        }

        return $this;
    }

    public function removeOffre(OffreStage $offre): self
    {
        if ($this->offres_stage->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getSociete() === $this) {
                $offre->setSociete(null);
            }
        }

        return $this;
    }

    public function getOffreEmploi(): ?OffreEmploi
    {
        return $this->offre_emploi;
    }

    public function setOffreEmploi(?OffreEmploi $offre_emploi): self
    {
        $this->offre_emploi = $offre_emploi;

        return $this;
    }
}
