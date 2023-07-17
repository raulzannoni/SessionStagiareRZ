<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\OneToMany(targetEntity=ModuleSession::class, mappedBy="categorie", orphanRemoval=true)
     */
    private $Modules;

    public function __construct()
    {
        $this->Modules = new ArrayCollection();
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

    /**
     * @return Collection<int, ModuleSession>
     */
    public function getModules(): Collection
    {
        return $this->Modules;
    }

    public function addModule(ModuleSession $module): self
    {
        if (!$this->Modules->contains($module)) {
            $this->Modules[] = $module;
            $module->setCategorie($this);
        }

        return $this;
    }

    public function removeModule(ModuleSession $module): self
    {
        if ($this->Modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getCategorie() === $this) {
                $module->setCategorie(null);
            }
        }

        return $this;
    }
}
