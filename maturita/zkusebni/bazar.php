<?php
class car{
private string $brand;
private int $mileage;
private bool $isAvailable;

    public function __construct (string $brand, int $mileage, bool $isAvailable){
        $this->brand=$brand;
        $this->mileage=$mileage;
        $this->isAvailable=$isAvailable;
    }

    public function getBrand():string{
        return $this->brand;
    }
    public function getMileage():int{
        return $this->mileage;
    }
     public function getIsAvailable():bool{
        return $this->isAvailable;
    }
}
$count=0;
$dealership=[];
$dealership[]=new car("Škoda", 120000, true);
$dealership[]=new car("BMW", 200000, true);
$dealership[]=new car("Audi", 50000,false);
$dealership[]=new car("Hyundai", 80000, true);

foreach ($dealership as $car){
    if($car->getIsAvailable()===true && $car->getMileage()<150000){
        echo $car->getBrand()."<br>";
        $count+=1;
        echo $count;
    }
    
 }



?>