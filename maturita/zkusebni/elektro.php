<?php
class product{
    private string $name;
    private float $price;
    private int $ammount;

    public function __construct(string $name, float $price, int $ammount){
        $this->name= $name;
        $this->price=$price;
        $this->ammount=$ammount;
        }

    public function getName(string $name):string{
       return $this->name;
    }

    public function getPrice(float $price):float{
        return $this->price;
    }

    public function geAmmount(int $ammount):string{
        return $this->ammount;
    }
}
$total=0;
    foreach ($stock as $product){
        $total+=($product->getPrice()*$product->getAmmount())
    }

$stock=[];
    $stock[]= new product("notebook", 11.01, 3);
    $stock[]= new product("phone", 21.01, 4);


$priciestProduct=$stock[0];
    foreach ($stock as $product){
        if ($product->getPrice() > $priciestProduct->getPrice()){
            $priciestProduct=$product;
        }
    }
?>