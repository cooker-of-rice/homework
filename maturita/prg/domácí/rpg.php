<?php
class item{
    public int $id;
    public string $item_name;
    public string $rarity;
    public int $price;
    public  string $found_at;

    public function __construct(int $id, string $item_name, string $rarity, int $price, string $found_at){
        $this->id=$id;
        $this->item_name=$item_name;
        $this->rarity=$rarity;
        $this->price=$price;
        $this->found_at=$found_at;
    }

    public function isntCommon():bool{
        return $this->rarity!="Common";
    }

    public function foundBefore(): bool{
        $markpoint= new DateTime("2026-03-01");
        $itemDate = new DateTime($this->found_at);
        
        return $markpoint>=$itemDate;
        
    }
}

$jsonData=json_decode("inventory.json", true);
$inventory=[];

foreach($jsonData as $item){
    $inventory[]= new item (
        $item['id'],
        $item['item_name'],
        $item['rarity'],
        $item['price'],
        $item['found_at']
    );
}
$filteredInv=[];
foreach($inventory as $item){
    if ($item->isntCommon() && $item->foundBefore()){
        $filteredInv[]= $item;
    }
}

usort($filteredInv, function($a, $b){
    return $b->price<=>$a->price;
});
$json=json_encode($filteredInv, JSON_PRETTY_PRINT);
file_put_contents("sorted inventory.json", $json);
?>