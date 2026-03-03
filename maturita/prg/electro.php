<?php
class device{
    public int $id;
    public string $device_name;
    public string $assigned_to;
    public string $return_date;

    public function __construct(int $id, string $device_name, string $assigned_to, string $return_date){
        $this->id=$id;
        $this->device_name=$device_name;
        $this->asigned_to=$assigned_to;
        $this->return_date=$return_date;
    }

    public function isOverdue():bool{
    $today=new DateTime();
    $deadline= new DateTime($this->return_date);
    return $today>$deadline;

    }
}
$jsonData = json_decode($jsonString, true);
$rentalShop=[];
foreach($jsonData as $device){
    $rentalShop[]= new device(
        $device['id'],
        $device['device_name'],
        $device['assigned_to'],
        $device['return_date']
    );
}
$overdueCount=0;
foreach($rentalShop as $device){
    if ($device->isOverdue()){
        $overdueCount+=1;
    }
}
echo "there is:". $overdueCount ."devices overdue, out of:" . count($rentalShop). ".";

usort($rentalShop, function($a, $b) {
    $dateA = new DateTime($a->return_date);
    $dateB = new DateTime($b->return_date);
    
    return $dateA <=> $dateB; 
});

$json=json_encode($rentalShop, JSON_PRETTY_PRINT);
file_put_contents("devices.json", $json);
?>