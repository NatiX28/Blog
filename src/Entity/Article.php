<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(
    normalizationContext: ['groups' => ['article']],
)]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article'])]
    private ?int $id = null;

    
    #[ORM\Column(length: 100)]
    #[Groups(['article'])]
    private ?string $titre = null;

    
    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['article'])]
    private ?string $contenu = null;

    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['article'])]
    private ?\DateTimeInterface $date = null;

    
    #[ORM\OneToMany(mappedBy: 'larticle', targetEntity: Avis::class)]
    #[Groups(['article'])]
    private Collection $lesAvis;

    #[Groups(['article'])]
    #[ORM\ManyToOne(inversedBy: 'listeArticles')]
    private ?Utilisateur $utilisateur = null;

    
    #[ORM\ManyToOne(inversedBy: 'lesArticles')]
    private ?Categorie $categorie = null;

    
    public function __toString()
    {
        return $this->titre;
    }

    public function __construct()
    {
        $this->lesAvis = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }


    /**
     * @return Collection<int, Avis>
     */
    public function getLesAvis(): Collection
    {
        return $this->lesAvis;
    }

    public function addLesAvi(Avis $lesAvi): static
    {
        if (!$this->lesAvis->contains($lesAvi)) {
            $this->lesAvis->add($lesAvi);
            $lesAvi->setLarticle($this);
        }

        return $this;
    }

    public function removeLesAvi(Avis $lesAvi): static
    {
        if ($this->lesAvis->removeElement($lesAvi)) {
            // set the owning side to null (unless already changed)
            if ($lesAvi->getLarticle() === $this) {
                $lesAvi->setLarticle(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

  


}
