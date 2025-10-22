<?php
namespace App\Repository;

use App\Entity\Model;
use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    /**
     * Načte všechny modely včetně informací o výrobci
     *
     * @return array
     */
    public function findAllWithManufacturers(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'mfr')
            ->join('m.manufacturer', 'mfr')
            ->getQuery()
            ->getResult();
    }

    /**
     * Filtruje modely podle jména výrobce
     *
     * @param string $manufacturerName
     * @return array
     */
    public function findByManufacturerName(string $manufacturerName): array
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'mfr')
            ->join('m.manufacturer', 'mfr')
            ->where('mfr.manufacturer_name = :manufacturer_name')
            ->setParameter('manufacturer_name', $manufacturerName)
            ->getQuery()
            ->getResult();
    }

    /**
     * Filtruje modely podle názvu modelu
     *
     * @param string $modelName
     * @return array
     */
    public function findByModelName(string $modelName): array
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'mfr')
            ->join('m.manufacturer', 'mfr')
            ->where('m.model_name LIKE :model_name')
            ->setParameter('model_name', '%' . $modelName . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Získá seznam všech modelů vozidel s informacemi o majiteli, pokud existuje vazba
     *
     * @return array
     */
    public function findModelsWithOwners(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m', 'mfr', 'c', 'o')
            ->join('m.manufacturer', 'mfr')
            ->leftJoin('m.cars', 'c')
            ->leftJoin('c.owner', 'o')
            ->getQuery()
            ->getResult();
    }
}