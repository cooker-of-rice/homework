<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "cars")]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 17)]
    private string $vin_code;

    #[ORM\Column(type: "string", length: 100)]
    private string $engine_model;

    #[ORM\Column(type: "integer")]
    private int $manufactured_in;

    #[ORM\ManyToOne(targetEntity: Model::class, inversedBy: "cars")]
    #[ORM\JoinColumn(name: "id_model", referencedColumnName: "id")]
    private Model $model;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: "cars")]
    #[ORM\JoinColumn(name: "id_owner", referencedColumnName: "id", nullable: true)]
    private ?Owner $owner = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getVinCode(): string
    {
        return $this->vin_code;
    }

    public function setVinCode(string $vin_code): self
    {
        $this->vin_code = $vin_code;
        return $this;
    }

    public function getEngineModel(): string
    {
        return $this->engine_model;
    }

    public function setEngineModel(string $engine_model): self
    {
        $this->engine_model = $engine_model;
        return $this;
    }

    public function getManufacturedIn(): int
    {
        return $this->manufactured_in;
    }

    public function setManufacturedIn(int $manufactured_in): self
    {
        $this->manufactured_in = $manufactured_in;
        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;
        return $this;
    }
}