<?php
class Product{
    public string $name;
    public int $price;
    public int $quantity;
    public string $cathegory;

    public function __construct(string $name,int $price,int $quantity, string $cathegory) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->cathegory = $cathegory;
    }

    public  function getTotalValue(): int{
        return $this->price*$this->quantity;
    }

    public function isAvailable(): bool{
        return $this->quantity>=1;
    }
}
$lines=file("facility.txt", FILE_IGNORE_NEW_LINES);
$list=[];
foreach($lines as $line){
    $parts=explode(";", $line);
    $name=$parts[0];
    $price=$parts[1];
    $quantity=$parts[2];
    $cathegory=$parts[3];

    $list[]= new Product($name,$price, $quantity, $cathegory);

}
$periferie=[];
foreach ($list as $item){
    if ($item->cathegory=="Periferie"){
        $periferie[]=$item;
    }
}

usort($periferie, function($a, $b){
   return $b->price <=> $a->price;
});
$totalTotal=0;
foreach ($periferie as $item){
echo "[". $item->name . "] - Skladem: [" . ($item->isAvailable() ? "ANO" : "NE") . "] | Hodnota zásob: [" . $item->getTotalValue() . "] Kč";   $totalTotal+= $item->getTotalValue(). PHP_EOL;
}
echo $totalTotal;


?>