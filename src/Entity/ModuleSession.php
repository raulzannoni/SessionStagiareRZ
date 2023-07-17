<?php

namespace App\Entity;

use App\Repository\ModuleSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleSessionRepository::class)
 */
class ModuleSession
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="Modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Represent::class, mappedBy="module", orphanRemoval=true)
     */
    private $represents;

    public function __construct()
    {
        $this->represents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Represent>
     */
    public function getRepresents(): Collection
    {
        return $this->represents;
    }

    public function addRepresent(Represent $represent): self
    {
        if (!$this->represents->contains($represent)) {
            $this->represents[] = $represent;
            $represent->setModule($this);
        }

        return $this;
    }

    public function removeRepresent(Represent $represent): self
    {
        if ($this->represents->removeElement($represent)) {
            // set the owning side to null (unless already changed)
            if ($represent->getModule() === $this) {
                $represent->setModule(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
