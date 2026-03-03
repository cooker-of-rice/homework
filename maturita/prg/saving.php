<?php
class document{
public string $name;
public float $size;
public int $value;

public function __construct(string $name, int $size, int $value){
    $this->name=$name;
    $this->size=$size;
    $this->value=$value;
}

public function getEfectivity(): float{
    return $this->value / $this->size;
}
}
$lines=file("vault.txt", FILE_IGNORE_NEW_LINES);
$list=[];

foreach ($lines as $line){
    $parts=explode("|", $line);

    $name=trim(str_replace("DOC", " ", $parts[0]));
    $size=(float) trim(str_replace("S:", " ", $parts[1]));
    $value=(int) trim(str_replace("V:", " ", $parts[2]));

    $list[]=new document($name, $size, $value);
}
usort($list, function(){
    return $b->getEfectivity() <=> $a->getEfectivity();
});
$creds=0;
$curentSize=400;
$stolenData=[];//hacker by to asi tak nepojmenoval
foreach($list as $document){
    if ($document->size<=$curentSize){
        $curentSize-=$document->size;
        $creds+=$document->value;
        $stolenData[]=[$document->name,$document->size, $document->value];
    }
}
    $json=json_encode($stolenData, JSON_PRETTY_PRINT);
    file_put_contents("stolen.json", $json);
?>