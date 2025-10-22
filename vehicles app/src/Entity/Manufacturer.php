<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "manufacturers")]
class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $manufacturer_name;

    #[ORM\OneToMany(targetEntity: Model::class, mappedBy: "manufacturer")]
    private Collection $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getManufacturerName(): string
    {
        return $this->manufacturer_name;
    }

    public function setManufacturerName(string $manufacturer_name): self
    {
        $this->manufacturer_name = $manufacturer_name;
        return $this;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setManufacturer($this);
        }

        return $this;
    }
}