<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\ModelRepository")]
#[ORM\Table(name: "models")]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $model_name;

    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: "models")]
    #[ORM\JoinColumn(name: "id_manufacturer", referencedColumnName: "id")]
    private Manufacturer $manufacturer;

    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: "model")]
    private Collection $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getModelName(): string
    {
        return $this->model_name;
    }

    public function setModelName(string $model_name): self
    {
        $this->model_name = $model_name;
        return $this;
    }

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(Manufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setModel($this);
        }

        return $this;
    }
}